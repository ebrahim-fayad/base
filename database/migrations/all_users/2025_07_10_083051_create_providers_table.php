<?php

use App\Enums\ApprovementStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvidersTable extends Migration
{
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('name', 50)->nullable();
            $table->string('country_code', 5)->default('966');
            $table->string('phone', 15);
            $table->string('email', 50)->nullable();
            $table->string('lang', 2)->default('ar');

            $table->string('commercial_image')->nullable();
            $table->string('identity_numb')->nullable();

            $table->boolean('active')->default(0);
            $table->boolean('is_blocked')->default(0);
            $table->tinyInteger('is_approved')->default(ApprovementStatusEnum::PENDING->value);
            $table->boolean('is_notify')->default(true);



            $table->string('map_desc')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();

            $table->string(column: 'cancel_reason')->nullable();

            $table->string('code', 10)->nullable();
            $table->timestamp('code_expire')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // Indexes
            $table->index('phone');
            $table->fullText('name');
        });
    }

    public function down()
    {
        Schema::dropIfExists('providers');
    }
}
