<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Hotel;

class CleanOrphanedImages extends Command
{
    protected $signature = 'images:clean';
    protected $description = 'Nettoyer les images orphelines';

    public function handle()
    {
        $storage = Storage::disk('public');
        $allImages = $storage->allFiles('hotels');
        $usedImages = Hotel::whereNotNull('image')->pluck('image')->toArray();

        $orphanedImages = array_diff($allImages, $usedImages);

        foreach ($orphanedImages as $image) {
            $storage->delete($image);
            $this->info("Supprimé: $image");
        }

        $this->info(count($orphanedImages) . ' images orphelines supprimées.');
    }
}