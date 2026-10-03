<?php

use App\Support\AdminSettingDefaults;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        AdminSettingDefaults::persistMissing();
    }

    public function down(): void
    {
        // Non-destructive: leave inserted keys in place.
    }
};
