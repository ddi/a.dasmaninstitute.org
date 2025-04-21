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
        Schema::create('hub_links', function (Blueprint $table) {
            $table->id();
            $table->string('title', length:22);
            $table->string('url', length:255);
            $table->string('description', length:66)->nullable();
            $table->string('icon', length:255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hub_links');
    }
};
