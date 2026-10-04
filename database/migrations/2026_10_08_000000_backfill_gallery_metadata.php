<?php

use App\Support\GalleryMetadataBackfill;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        GalleryMetadataBackfill::run();
    }

    public function down(): void
    {
        // Idempotent data backfill; no schema rollback.
    }
};
