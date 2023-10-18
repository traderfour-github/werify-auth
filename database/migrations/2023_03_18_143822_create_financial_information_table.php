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
        Schema::create('financial_information', function (Blueprint $table) {
            $table->id();
            $table->string('job')->nullable();
            $table->integer('income_min')->nullable();
            $table->integer('income_max')->nullable();
            $table->integer('salary_min')->nullable();
            $table->integer('salary_max')->nullable();
            $table->string('fund_source')->nullable();
            $table->double('initial_capital')->nullable();
            $table->string('wealth_source')->nullable();
            $table->string('goals_to_join')->nullable();
            $table->string('preferer_market')->nullable();
            $table->double('lose_min')->nullable();
            $table->double('lose_max')->nullable();
            $table->double('monthly_saving_min')->nullable();
            $table->double('monthly_saving_max')->nullable();
            $table->double('target_min')->nullable();
            $table->double('target_max')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_information');
    }
};
