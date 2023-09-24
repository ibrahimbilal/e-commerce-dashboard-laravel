<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
			$table->string('url');
			$table->text('metas')->json()->nullable();
			$table->text('sizes_url')->json()->nullable();
			$table->foreignId('user_id')->index();
            $table->timestamps();
			$table->softDeletes();

			$table->foreign('user_id')
                ->references('id') // user id
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('galleries');
    }
};
