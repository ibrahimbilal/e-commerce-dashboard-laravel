<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE product_locales MODIFY locale VARCHAR(10) NOT NULL');
        DB::statement('ALTER TABLE product_locales ADD PRIMARY KEY (product_id, locale)');

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['coupon_id']);
        });
        DB::statement('ALTER TABLE orders MODIFY coupon_id INT UNSIGNED NULL DEFAULT NULL');
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('coupon_id')->references('id')->on('coupons')->nullOnDelete();
        });

        Schema::table('subscribers_list', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
        });
        DB::statement('ALTER TABLE subscribers_list MODIFY customer_id INT UNSIGNED NULL DEFAULT NULL');
        Schema::table('subscribers_list', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customers')->nullOnDelete();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
        });
        DB::statement('ALTER TABLE categories MODIFY parent_id INT UNSIGNED NULL DEFAULT NULL');
        Schema::table('categories', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('categories')->nullOnDelete();
        });

        Schema::table('tags', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
        });
        DB::statement('ALTER TABLE tags MODIFY parent_id INT UNSIGNED NULL DEFAULT NULL');
        Schema::table('tags', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('tags')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
        });
        DB::statement('ALTER TABLE tags MODIFY parent_id INT UNSIGNED NOT NULL');
        Schema::table('tags', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('tags');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
        });
        DB::statement('ALTER TABLE categories MODIFY parent_id INT UNSIGNED NOT NULL');
        Schema::table('categories', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('categories');
        });

        Schema::table('subscribers_list', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
        });
        DB::statement('ALTER TABLE subscribers_list MODIFY customer_id INT UNSIGNED NOT NULL DEFAULT 0');
        Schema::table('subscribers_list', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customers');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['coupon_id']);
        });
        DB::statement('ALTER TABLE orders MODIFY coupon_id INT UNSIGNED NOT NULL DEFAULT 0');
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('coupon_id')->references('id')->on('coupons');
        });

        DB::statement('ALTER TABLE product_locales DROP PRIMARY KEY');
        DB::statement('ALTER TABLE product_locales MODIFY locale TEXT NOT NULL');
    }
};
