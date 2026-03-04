<?php

use App\Enums\UserTypesEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->nullable();
            $table->string('country_code', 5)->default('966');
            $table->string('phone', 15);
            $table->string('age')->nullable();
            $table->string('image', 50)->nullable();
            $table->decimal('lat', 10, 8)->nullable();
            $table->decimal('lng', 11, 8)->nullable();
            $table->string('map_desc')->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->decimal('height', 5, 2)->nullable();
            $table->decimal('waist_circumference', 5, 2)->nullable();
            $table->string('lang', 2)->default('ar');
            $table->string('password')->nullable();
            $table->boolean('active')->default(false);
            $table->boolean('is_blocked')->default(false);
            $table->boolean('is_notify')->default(true);
            $table->string('code', 10)->nullable();
            $table->timestamp('code_expire')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
