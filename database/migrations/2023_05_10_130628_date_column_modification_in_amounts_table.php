<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('amounts', function (Blueprint $table) {
            DB::statement('ALTER TABLE `amounts` MODIFY COLUMN `amount` FLOAT NOT NULL');
            $table->dropColumn('date');
            $table->timestamp('created_at')->useCurrent();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('amounts', function (Blueprint $table) {
            DB::statement('ALTER TABLE `amounts` MODIFY COLUMN `amount` DOUBLE NOT NULL ');
            $table->dropColumn('created_at');
            $table->timestamp('date')->useCurrent();
        });
    }
};
