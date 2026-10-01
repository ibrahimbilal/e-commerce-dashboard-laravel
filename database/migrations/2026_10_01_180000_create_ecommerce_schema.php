<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('options', function (Blueprint $table) {
            $table->increments('id');
            $table->string('option_key', 100)->nullable();
            $table->string('option_value', 100)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });

        Schema::create('langs', function (Blueprint $table) {
            $table->unsignedTinyInteger('id')->primary();
            $table->text('code');
            $table->text('name');
            $table->text('direction');
            $table->boolean('active')->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });

        Schema::create('currencies', function (Blueprint $table) {
            $table->unsignedTinyInteger('id')->primary();
            $table->text('code');
            $table->text('symbol');
            $table->boolean('active')->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });

        Schema::create('discounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 191);
            $table->float('discount', 100, 2);
            $table->string('type', 10)->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->string('apply_to', 191)->nullable();
            $table->boolean('active')->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        });

        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email', 50);
            $table->string('password', 191);
            $table->rememberToken();
            $table->string('gender', 191)->nullable();
            $table->string('first_name', 50)->nullable();
            $table->string('last_name', 50)->nullable();
            $table->date('birth_date')->nullable();
            $table->string('mobile', 20)->nullable();
            $table->string('profile_picture', 191)->nullable();
            $table->string('ip_address', 50)->nullable();
            $table->boolean('deleted')->default(false);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->text('sku');
            $table->string('product_img', 191)->nullable();
            $table->integer('regular_price')->nullable();
            $table->integer('sale_price')->nullable();
            $table->string('schedule_sale', 191)->nullable();
            $table->integer('quantity');
            $table->string('status', 191)->nullable();
            $table->boolean('new')->default(true);
            $table->boolean('featured')->default(false);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        });

        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('img_url', 191);
            $table->string('img_meta', 191);
            $table->string('img_sizes_url', 191);
            $table->boolean('deleted')->default(false);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        });

        Schema::create('attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('attribute_key', 100);
            $table->string('attribute_value', 100);
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 50);
            $table->string('description', 150)->nullable();
            $table->string('category_slug', 191)->nullable();
            $table->string('cat_img', 191)->nullable();
            $table->boolean('active')->default(true);
            $table->unsignedInteger('parent_id');
            $table->text('locale');
            $table->string('meta_title', 191)->nullable();
            $table->string('meta_keywords', 191)->nullable();
            $table->string('meta_description', 191)->nullable();
            $table->boolean('deleted')->default(false);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 50);
            $table->string('tag_slug', 191)->nullable();
            $table->boolean('deleted')->default(false);
            $table->unsignedInteger('parent_id');
            $table->text('locale');
            $table->string('meta_title', 191)->nullable();
            $table->string('meta_keywords', 191)->nullable();
            $table->string('meta_description', 191)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        });

        Schema::create('product_locales', function (Blueprint $table) {
            $table->unsignedInteger('product_id');
            $table->text('locale');
            $table->string('name', 100);
            $table->string('description', 255)->nullable();
            $table->string('product_slug', 191)->nullable();
            $table->string('meta_title', 191)->nullable();
            $table->string('meta_keywords', 191)->nullable();
            $table->string('meta_description', 191)->nullable();

            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
        });

        Schema::create('products_tags', function (Blueprint $table) {
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('tag_id');

            $table->primary(['product_id', 'tag_id']);
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
            $table->foreign('tag_id')->references('id')->on('tags')->cascadeOnDelete();
        });

        Schema::create('products_cats', function (Blueprint $table) {
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('cat_id');

            $table->primary(['product_id', 'cat_id']);
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
            $table->foreign('cat_id')->references('id')->on('categories')->cascadeOnDelete();
        });

        Schema::create('products_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('attribute_1_id');
            $table->unsignedInteger('attribute_2_id');

            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
            $table->foreign('attribute_1_id')->references('id')->on('attributes')->cascadeOnDelete();
            $table->foreign('attribute_2_id')->references('id')->on('attributes')->cascadeOnDelete();
        });

        Schema::create('order_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        });

        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100);
            $table->string('code', 10);
            $table->float('discount', 100, 2);
            $table->string('type', 10)->nullable();
            $table->integer('usage_limit');
            $table->integer('usage_per_customer');
            $table->timestamp('expired_at')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        });

        Schema::create('subscribers_list', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email', 100);
            $table->unsignedInteger('customer_id')->default(0);
            $table->string('token', 100)->nullable();
            $table->boolean('is_subscriber')->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });

        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('customer_id');
            $table->string('address_title', 100)->nullable();
            $table->string('mobile', 50)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('address_1', 100)->nullable();
            $table->string('address_2', 100)->nullable();
            $table->string('postcode', 5)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();

            $table->foreign('customer_id')->references('id')->on('customers')->cascadeOnDelete();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('address_id');
            $table->integer('amount');
            $table->unsignedInteger('order_status_id');
            $table->unsignedInteger('coupon_id')->default(0);
            $table->unsignedInteger('updated_by')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();

            $table->foreign('customer_id')->references('id')->on('customers')->cascadeOnDelete();
            $table->foreign('address_id')->references('id')->on('addresses')->cascadeOnDelete();
            $table->foreign('order_status_id')->references('id')->on('order_statuses')->cascadeOnDelete();
            $table->foreign('coupon_id')->references('id')->on('coupons');
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id');
            $table->unsignedInteger('product_attribute_id');
            $table->integer('quantity');
            $table->integer('price');

            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
            $table->foreign('product_attribute_id')->references('id')->on('products_attributes')->cascadeOnDelete();
        });

        Schema::create('customer_coupons_usage', function (Blueprint $table) {
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('coupon_id');
            $table->integer('times_used');

            $table->primary(['customer_id', 'coupon_id']);
            $table->foreign('customer_id')->references('id')->on('customers')->cascadeOnDelete();
            $table->foreign('coupon_id')->references('id')->on('coupons')->cascadeOnDelete();
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_no');
            $table->unsignedInteger('order_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->softDeletes();

            $table->foreign('order_id')->references('id')->on('orders')->nullOnDelete();
        });

        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('product_id')->nullable();
            $table->string('comment', 191);
            $table->unsignedTinyInteger('rate')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();

            $table->foreign('customer_id')->references('id')->on('customers')->cascadeOnDelete();
            $table->foreign('product_id')->references('id')->on('products')->nullOnDelete();
        });

        Schema::table('subscribers_list', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customers');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('categories');
        });

        Schema::table('tags', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('tags');
        });
    }

    public function down(): void
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
        });

        Schema::table('subscribers_list', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
        });

        Schema::dropIfExists('reviews');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('customer_coupons_usage');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('addresses');
        Schema::dropIfExists('subscribers_list');
        Schema::dropIfExists('coupons');
        Schema::dropIfExists('order_statuses');
        Schema::dropIfExists('products_attributes');
        Schema::dropIfExists('products_cats');
        Schema::dropIfExists('products_tags');
        Schema::dropIfExists('product_locales');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('attributes');
        Schema::dropIfExists('images');
        Schema::dropIfExists('products');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('discounts');
        Schema::dropIfExists('currencies');
        Schema::dropIfExists('langs');
        Schema::dropIfExists('options');
    }
};
