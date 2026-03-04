<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->id();
            $table->integer('rate');
            $table->morphs('ratedable');  // The entity being rated (user, consultant, etc.)
            $table->morphs('ratingable'); // The entity giving the rating
            $table->text('message')->nullable();
            // Add the orderable polymorphic relationship columns
            $table->morphs('orderable'); // The order being rated (consultation, course, etc.)
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
        Schema::dropIfExists('rates');
    }
};
