<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tracker_entries', function (Blueprint $table) {
            $table->enum('status', ['Reading', 'Plan to Read', 'Completed', 'On-hold', 'Dropped'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tracker_entries', function (Blueprint $table) {
            $table->enum('status', ['Plan to Read', 'Completed', 'On-hold', 'Dropped'])->change();
        });
    }
};
