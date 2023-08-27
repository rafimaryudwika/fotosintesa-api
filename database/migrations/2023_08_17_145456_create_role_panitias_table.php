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
        Schema::create('role_panitias', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::table('panitias', function (Blueprint $table) {
            $table->foreignId('role')->constrained('role_panitias');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('panitias', function (Blueprint $table) {
            $table->removeColumn('role');
        });

        Schema::dropIfExists('role_panitias');
    }
};
