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
        Schema::table('profiles', function (Blueprint $table) {
            // Add the 'pin' column
            // We'll make it a string to match the Filament field validation,
            // and nullable if it's not always required.
            $table->string('pin', 4)->nullable()->after('name'); // Place it after the 'name' column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            // Drop the 'pin' column if the migration is rolled back
            $table->dropColumn('pin');
        });
    }
};