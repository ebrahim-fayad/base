<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration {
  public function up() {
    Schema::create('admins', function (Blueprint $table) {
      $table->id();
      $table->enum('type', ['admin', 'super_admin'])->default('admin');
      $table->string('name');
      $table->string('email')->nullable();
      $table->string('country_code',5)->nullable();
      $table->string('phone')->nullable();
      $table->string('password');
      $table->string('image', 50)->nullable();
      $table->integer('role_id')->nullable();
      $table->boolean('is_blocked')->default(0);
      $table->boolean('is_notify')->default(true);
      $table->softDeletes();
      $table->timestamps();
    });
  }

  public function down() {
    Schema::dropIfExists('admins');
  }
}
