<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sourceDir = base_path('gambar_produk');
        $destinationDir = public_path('storage/products');

        // Create destination directory if it doesn't exist
        if (!File::exists($destinationDir)) {
            File::makeDirectory($destinationDir, 0755, true);
            $this->command->info("Created directory: {$destinationDir}");
        }

        // Check if source directory exists
        if (!File::exists($sourceDir)) {
            $this->command->error("Source directory not found: {$sourceDir}");
            return;
        }

        // Get all files from source directory
        $files = File::files($sourceDir);
        $copiedCount = 0;
        $failedCount = 0;

        foreach ($files as $file) {
            $filename = $file->getFilename();
            $destination = $destinationDir . DIRECTORY_SEPARATOR . $filename;

            try {
                File::copy($file->getPathname(), $destination);
                $copiedCount++;
                $this->command->info("Copied: {$filename}");
            } catch (\Exception $e) {
                $failedCount++;
                $this->command->error("Failed to copy {$filename}: " . $e->getMessage());
            }
        }

        $this->command->info("Image seeding completed!");
        $this->command->info("Total copied: {$copiedCount}");
        if ($failedCount > 0) {
            $this->command->warn("Total failed: {$failedCount}");
        }
    }
}
