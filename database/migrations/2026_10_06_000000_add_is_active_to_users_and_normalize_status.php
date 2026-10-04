<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('status');
        });

        DB::table('users')
            ->where('status', 'inactive')
            ->update(['is_active' => false]);

        $legacyStatuses = ['active', 'inactive', ''];

        $legacyUsers = DB::table('users')
            ->where(function ($query) use ($legacyStatuses) {
                $query->whereIn('status', $legacyStatuses)
                    ->orWhereNull('status');
            })
            ->get(['id', 'email_verified_at']);

        foreach ($legacyUsers as $user) {
            DB::table('users')
                ->where('id', $user->id)
                ->update([
                    'status' => $user->email_verified_at !== null ? 'verified' : 'not_verified',
                    'updated_at' => now(),
                ]);
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
};
