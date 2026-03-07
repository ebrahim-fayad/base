<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProviderUpdatesTable extends Migration
{
    public function up()
    {
        Schema::create('provider_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_id')->unique()->constrained('providers')->onDelete('cascade');

            // Fields that can be updated
            $table->string('name', 50)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('country_code', 5)->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('image')->nullable();
            $table->string('commercial_number')->nullable();
            $table->string('map_desc')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();

            // Categories (stored as JSON string of IDs)
            $table->text('categories')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('provider_updates');
    }
}
