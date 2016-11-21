<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('username', 100)->unique();
            $table->string('email', 255)->unique();
            $table->string('password');
            $table->string('display_name', 150);
            $table->string('first_name', 100);
            $table->string('last_name', 100)->nullable();
            $table->string('activation_code', 100)->nullable();
            $table->string('avatar', 255)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('mobile_phone', 20)->nullable();
            $table->enum('sex', ['male', 'female', 'other'])->default('male');
            $table->enum('status', ['activated', 'disabled', 'deleted'])->default('activated');
            $table->timestamp('birthday')->nullable();
            $table->text('description')->nullable();
            $table->rememberToken();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamp('disabled_until')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });

        Schema::create('password_resets', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
        Schema::drop('password_resets');
    }
}
