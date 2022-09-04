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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('mobile')->nullable();
            $table->date('birth_date')->nullable();
			$table->string('role_name')->default('not_verified');
			$table->enum('gender', ['male', 'female']);
            $table->string('status');
            $table->string('language')->nullable();
            $table->string('profile_picture', 1000)->nullable();
            $table->rememberToken();
            $table->timestamps();
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     * $2y$10$7mv70CQw8zxyQtl2W5jmz.ZdZ2t22BDDL4DxszkBAM6JOgHcB9YI2
	 * storage/users/hwbnTkhbSmF88qS6qG3c3BsGI6719L2lKa3hcHyZ.jpg
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
