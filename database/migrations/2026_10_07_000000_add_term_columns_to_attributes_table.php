<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attributes', function (Blueprint $table) {
            $table->string('term_title', 100)->nullable()->after('attribute_value');
            $table->string('term_type', 10)->default('text')->after('term_title');
        });

        DB::table('attributes')->update([
            'term_title' => DB::raw('attribute_value'),
            'term_type' => 'text',
        ]);
    }

    public function down(): void
    {
        Schema::table('attributes', function (Blueprint $table) {
            $table->dropColumn(['term_title', 'term_type']);
        });
    }
};
