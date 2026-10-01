<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign('users_role_foreign');
                $table->dropColumn('role');
            });
        }

        Schema::dropIfExists('legacy_roles');
    }

    public function down(): void
    {
        //
    }
};
