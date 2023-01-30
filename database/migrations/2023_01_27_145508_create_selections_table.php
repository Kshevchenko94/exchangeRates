<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('selections', function (Blueprint $table) {
            $table->date('selection_date');
            $table->unsignedBigInteger('exchange_rates_id');
            $table->index(['selection_date']);
            $table->foreign('exchange_rates_id')->references('id')->on('exchange_rates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('selections');
    }
};
