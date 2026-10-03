<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('settings')
            ->where('setting_key', 'share_on')
            ->where(function ($query) {
                $query->whereNull('setting_value')
                    ->orWhere('setting_value', '');
            })
            ->update([
                'setting_value' => '[]',
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        // Non-destructive.
    }
};
