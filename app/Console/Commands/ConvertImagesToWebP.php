<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;

class ConvertImagesToWebP extends Command
{
    protected $signature = 'images:convert-webp {--disk=public : Filesystem disk to use} {--dir=uploads : Directory to scan inside the disk} {--quality=75 : Compression quality (0-100)}';

    protected $description = 'Convert all images in a folder to WebP format';

    public function handle()
    {
        $disk = $this->option('disk');
        $dir = $this->option('dir');
        $quality = (int) $this->option('quality');

        $files = Storage::disk($disk)->allFiles($dir);
        $converted = 0;
        $manager = new ImageManager(Driver::class);

        foreach ($files as $file) {
            if (!preg_match('/\.(jpe?g|png)$/i', $file)) continue;

            $this->line("Converting: $file");

            $image = $manager->read(Storage::disk($disk)->get($file));
            $image = $image->encode(new WebpEncoder(quality: $quality));

            $newFile = preg_replace('/\.(jpe?g|png)$/i', '.webp', $file);

            Storage::disk($disk)->put($newFile, (string) $image);
            $converted++;
        }

        $this->info("Conversion completed. Total converted: $converted");
    }
}
