<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\File;
use App\Models\Folder;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Seeds 25 linked DMS documents, each with 1 PDF file + 1 image file.
 * Link keys DUMMY-001..DUMMY-025 match CMS / LIS seeders.
 */
class DummyMediaSeeder extends Seeder
{
    public function run(): void
    {
        $manifestPath = storage_path('app/dummy_media_manifest.json');
        if (! is_file($manifestPath)) {
            $this->command?->error("Missing manifest: {$manifestPath}. Generate dummy files first.");
            return;
        }

        $manifest = json_decode(file_get_contents($manifestPath), true);
        $count = count($manifest['link_key'] ?? []);
        if ($count < 20) {
            $this->command?->error('Manifest must contain at least 20 items.');
            return;
        }

        if (Document::where('tags', 'like', '%DUMMY-001%')->exists()) {
            $this->command?->info('DMS dummy media already seeded — skipping.');
            return;
        }

        $folder = Folder::firstOrCreate(
            ['name' => 'Dummy Seed Data'],
            [
                'branch_id' => 1,
                'department_id' => 1,
                'division_id' => 1,
                'section_id' => 1,
                'status' => 1,
            ]
        );

        // Physical files were written under storage/app/3/ — keep paths in sync with folder id.
        $expectedDir = storage_path('app/3');
        $actualDir = storage_path('app/' . $folder->id);
        if ($folder->id != 3 && is_dir($expectedDir) && ! is_dir($actualDir)) {
            rename($expectedDir, $actualDir);
            foreach (['dms_pdf', 'dms_img'] as $key) {
                $manifest[$key] = array_map(
                    fn ($p) => preg_replace('#^3/#', $folder->id . '/', $p),
                    $manifest[$key]
                );
            }
        }

        $now = Carbon::now();
        $types = ['1', '2', '3', '4', '5'];
        $authors = ['Sec. Reyes', 'Hon. Santos', 'Atty. Cruz', 'Admin Seed', 'Clerk Demo'];

        DB::transaction(function () use ($manifest, $folder, $now, $types, $authors, $count) {
            for ($i = 0; $i < $count; $i++) {
                $key = $manifest['link_key'][$i];
                $n = $i + 1;

                $document = Document::create([
                    'title' => "{$key} — Seed Document {$n}",
                    'author' => $authors[$i % count($authors)],
                    'description' => "Cross-linked dummy document {$key} for LIS-CMS-DMS demo.",
                    'branch_id' => 1,
                    'department_id' => 1,
                    'division_id' => 1,
                    'section_id' => 1,
                    'folder_id' => $folder->id,
                    'document_access' => (string) (($i % 3) + 1),
                    'tags' => "{$key},dummy,seed,lis-cms-dms",
                    'type' => $types[$i % count($types)],
                    'doc_date' => $now->copy()->subDays($count - $i),
                ]);

                $pdfPath = $manifest['dms_pdf'][$i];
                $imgPath = $manifest['dms_img'][$i];

                File::create([
                    'fileable_id' => $document->id,
                    'fileable_type' => Document::class,
                    'file_name' => strtolower(basename($pdfPath)),
                    'file_path' => $pdfPath,
                    'file_size' => $this->humanSize(storage_path('app/' . $pdfPath)),
                    'file_version' => 1,
                    'uploaded_by' => 1,
                ]);

                File::create([
                    'fileable_id' => $document->id,
                    'fileable_type' => Document::class,
                    'file_name' => strtolower(basename($imgPath)),
                    'file_path' => $imgPath,
                    'file_size' => $this->humanSize(storage_path('app/' . $imgPath)),
                    'file_version' => 1,
                    'uploaded_by' => 1,
                ]);
            }
        });

        $this->command?->info("Seeded {$count} DMS documents with " . ($count * 2) . ' files (PDF + image each).');
    }

    private function humanSize(string $absolutePath): string
    {
        if (! is_file($absolutePath)) {
            return '1 kB';
        }
        $bytes = filesize($absolutePath);
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 2) . ' MB';
        }
        return round($bytes / 1024, 2) . ' kB';
    }
}
