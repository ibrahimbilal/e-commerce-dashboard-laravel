<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'birth_date')) {
                $table->date('birth_date')->nullable()->after('mobile');
            }
            if (! Schema::hasColumn('users', 'role_name')) {
                $table->string('role_name')->default('not_verified')->after('birth_date');
            }
            if (! Schema::hasColumn('users', 'gender')) {
                $table->enum('gender', ['male', 'female'])->after('role_name');
            }
            if (! Schema::hasColumn('users', 'status')) {
                $table->string('status')->after('gender');
            }
            if (! Schema::hasColumn('users', 'language')) {
                $table->string('language')->nullable()->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            foreach (['birth_date', 'role_name', 'gender', 'status', 'language'] as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
