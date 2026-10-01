<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('spatie_permissions') || Schema::hasTable('permissions')) {
            return;
        }

        if (Schema::hasTable('roles') && ! Schema::hasColumn('roles', 'guard_name')) {
            if (Schema::hasColumn('users', 'role')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropForeign('users_role_foreign');
                    $table->dropColumn('role');
                });
            }

            Schema::drop('roles');
        }

        DB::statement('RENAME TABLE
            spatie_permissions TO permissions,
            spatie_roles TO roles,
            spatie_model_has_permissions TO model_has_permissions,
            spatie_model_has_roles TO model_has_roles,
            spatie_role_has_permissions TO role_has_permissions
        ');
    }

    public function down(): void
    {
        if (! Schema::hasTable('permissions') || Schema::hasTable('spatie_permissions')) {
            return;
        }

        DB::statement('RENAME TABLE
            permissions TO spatie_permissions,
            roles TO spatie_roles,
            model_has_permissions TO spatie_model_has_permissions,
            model_has_roles TO spatie_model_has_roles,
            role_has_permissions TO spatie_role_has_permissions
        ');

    }
};
