<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('password_reset_tokens');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name', 'email', 'email_verified_at', 'password');
            $table->string('username')->unique()->after('id');
            $table->string('person_id')->unique()->after('username')->nullable();
        });
    }

    public function down(): void
    {
    }
};
