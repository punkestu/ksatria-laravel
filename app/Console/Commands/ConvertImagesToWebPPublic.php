<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;

class ConvertImagesToWebPPublic extends Command
{
    protected $signature = 'images:convert-webp-public {--dir= : Path inside /public (default is whole public)} {--quality=75 : Compression quality (0–100)} {--delete-original : Delete original image after conversion}';

    protected $description = 'Convert all .jpg, .jpeg, .png images in /public to .webp';

    public function handle()
    {
        $basePath = public_path($this->option('dir') ?? '');
        $quality = (int) $this->option('quality');
        $deleteOriginal = $this->option('delete-original');

        if (!is_dir($basePath)) {
            $this->error("Directory not found: $basePath");
            return;
        }

        $imageFiles = collect(scandir($basePath))
            ->filter(fn($file) => preg_match('/\.(jpe?g|png)$/i', $file))
            ->map(fn($file) => $basePath . DIRECTORY_SEPARATOR . $file);

        $converted = 0;
        $manager = new ImageManager(Driver::class);

        foreach ($imageFiles as $filePath) {
            $this->line("Converting: $filePath");

            try {
                $image = $manager->read($filePath);
                $image = $image->encode(new WebpEncoder(quality: $quality));
                $webpPath = preg_replace('/\.(jpe?g|png)$/i', '.webp', $filePath);

                $image->save($webpPath);
                $converted++;

                if ($deleteOriginal) {
                    unlink($filePath);
                    $this->warn("Deleted: $filePath");
                }
            } catch (\Exception $e) {
                $this->error("Failed to convert $filePath: " . $e->getMessage());
            }
        }

        $this->info("Done! Total converted: $converted");
    }
}
