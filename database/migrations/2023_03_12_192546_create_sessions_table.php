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
        Schema::create(
            'sessions',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('hash')->default('');
                $table->string('type');
                $table->boolean('claimed')->default(false);
                $table->unsignedBigInteger('user_id')->default(0);
                $table->softDeletes();
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
