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
        Schema::create('place_views', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('sessions_id')->constrained('sessions');

            $table->foreignUuid('place_id')->constrained('places');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('place_views');
    }
};
