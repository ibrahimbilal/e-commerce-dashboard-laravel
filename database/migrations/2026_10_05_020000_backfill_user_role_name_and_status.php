<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $users = User::withTrashed()->with('roles')->get();

        foreach ($users as $user) {
            $updates = [];

            $role = $user->roles->first();
            if ($role !== null && ($user->role_name === null || $user->role_name === '' || $user->role_name === 'not_verified')) {
                $updates['role_name'] = $role->name;
            }

            if ($user->status === null || $user->status === '') {
                $updates['status'] = 'active';
            }

            if ($updates !== []) {
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(array_merge($updates, ['updated_at' => now()]));
            }
        }
    }

    public function down(): void
    {
        // Non-destructive.
    }
};
