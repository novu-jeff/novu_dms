<?php

namespace App\Console\Commands;

use App\Models\File;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CheckMissingFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dms:check-missing-files
                            {--export= : Export missing files to CSV path (e.g. storage/app/missing_files.csv)}
                            {--disk= : Check this disk only (default: config filesystems.default)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if file records in the database have corresponding files on disk (for re-upload after data loss)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $diskName = $this->option('disk') ?: config('filesystems.default');
        $disk = Storage::disk($diskName);
        $exportPath = $this->option('export');

        $this->info("Checking files from database against disk: {$diskName}");
        $this->newLine();

        $files = File::orderBy('id')->get();
        $missing = [];
        $checked = 0;

        $bar = $this->output->createProgressBar($files->count());
        $bar->start();

        foreach ($files as $file) {
            $path = $file->file_path;
            $exists = $disk->exists($path);
            if (!$exists && $path !== '' && $path !== null) {
                $missing[] = [
                    'id' => $file->id,
                    'file_name' => $file->file_name,
                    'file_path' => $path,
                    'fileable_id' => $file->fileable_id,
                    'fileable_type' => $file->fileable_type,
                    'file_version' => $file->file_version ?? 1,
                ];
            }
            $checked++;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->table(
            ['ID', 'File name', 'File path', 'Document ID', 'Version'],
            array_map(function ($row) {
                return [
                    $row['id'],
                    $row['file_name'],
                    $row['file_path'],
                    $row['fileable_id'],
                    $row['file_version'],
                ];
            }, $missing)
        );

        $this->newLine();
        $this->info("Total records: {$checked}");
        $this->info('Missing on disk: ' . count($missing));

        if (count($missing) > 0 && $exportPath) {
            $fullPath = base_path($exportPath);
            $dir = dirname($fullPath);
            if (!is_dir($dir)) {
                @mkdir($dir, 0755, true);
            }
            $fp = fopen($fullPath, 'w');
            if ($fp) {
                fputcsv($fp, ['id', 'file_name', 'file_path', 'fileable_id', 'fileable_type', 'file_version']);
                foreach ($missing as $row) {
                    fputcsv($fp, $row);
                }
                fclose($fp);
                $this->info("Exported to: {$fullPath}");
            } else {
                $this->warn("Could not write export file: {$fullPath}");
            }
        }

        return count($missing) > 0 ? 1 : 0;
    }
}
