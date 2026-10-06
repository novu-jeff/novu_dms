<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

/**
 * Mirror local storage/app contents to S3 (bucket prefix: dms/jones).
 * Run once to import existing files; new files are uploaded to S3 automatically when FILESYSTEM_DISK=s3.
 */
class StorageMirrorToS3 extends Command
{
    protected $signature = 'storage:mirror-to-s3
                            {--dry-run : List files that would be uploaded without uploading}
                            {--force : Overwrite existing files on S3}';

    protected $description = 'Mirror local storage (app) to S3 for easy access and backup';

    public function handle(): int
    {
        $localRoot = storage_path('app');
        if (!is_dir($localRoot)) {
            $this->error('Local storage path does not exist: ' . $localRoot);
            return self::FAILURE;
        }

        $dryRun = $this->option('dry-run');
        $force = $this->option('force');

        if ($dryRun) {
            $this->info('Dry run – no files will be uploaded.');
        }

        $files = $this->collectRelativePaths($localRoot, '');
        $total = count($files);
        $this->info("Found {$total} file(s) under storage/app.");

        if ($total === 0) {
            $this->info('Nothing to mirror.');
            return self::SUCCESS;
        }

        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $uploaded = 0;
        $skipped = 0;
        $errors = [];

        foreach ($files as $relativePath) {
            try {
                $shouldSkip = false;
                if (!$dryRun && !$force) {
                    try {
                        if (Storage::disk('s3')->exists($relativePath)) {
                            $shouldSkip = true;
                            $skipped++;
                        }
                    } catch (\Throwable $e) {
                        // S3 exists check failed (e.g. SSL/connection); attempt upload anyway
                    }
                }
                if ($shouldSkip) {
                    $bar->advance();
                    continue;
                }
                if ($dryRun) {
                    $uploaded++;
                } else {
                    $fullPath = $localRoot . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relativePath);
                    $contents = file_get_contents($fullPath);
                    Storage::disk('s3')->put($relativePath, $contents);
                    $uploaded++;
                }
            } catch (\Throwable $e) {
                $errors[] = "{$relativePath}: " . $e->getMessage();
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        if ($dryRun) {
            $this->info("Would upload {$uploaded} file(s).");
        } else {
            $this->info("Uploaded: {$uploaded}, Skipped (exists): {$skipped}.");
        }

        if (!empty($errors)) {
            $this->error('Errors:');
            foreach ($errors as $err) {
                $this->line('  ' . $err);
            }
            return self::FAILURE;
        }

        $this->info('Mirror complete. S3 path prefix: ' . config('filesystems.disks.s3.root', 'dms/jones') . '/');
        return self::SUCCESS;
    }

    /**
     * Collect relative paths of all files under $dir (relative to $localRoot).
     */
    private function collectRelativePaths(string $dir, string $relativePrefix): array
    {
        $paths = [];
        try {
            $items = new \DirectoryIterator($dir);
        } catch (\Throwable $e) {
            return $paths;
        }
        foreach ($items as $item) {
            if ($item->isDot()) {
                continue;
            }
            $name = $item->getFilename();
            $rel = $relativePrefix === '' ? $name : $relativePrefix . '/' . $name;
            if ($item->isDir()) {
                $paths = array_merge(
                    $paths,
                    $this->collectRelativePaths($item->getPathname(), $rel)
                );
            } elseif ($item->isFile()) {
                $paths[] = $rel;
            }
        }
        return $paths;
    }
}
