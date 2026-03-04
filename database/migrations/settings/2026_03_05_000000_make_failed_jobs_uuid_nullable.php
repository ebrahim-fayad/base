<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE failed_jobs MODIFY uuid VARCHAR(255) NULL UNIQUE');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE failed_jobs MODIFY uuid VARCHAR(255) NOT NULL UNIQUE');
    }
};
