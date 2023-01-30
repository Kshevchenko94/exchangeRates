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
        Schema::create('exchange_rates', function (Blueprint $table) {
            $table->id();
            $table->string('valute_id');
            $table->string('num_code');
            $table->string('char_code');
            $table->integer('nominal');
            $table->string('name');
            //По уму тут должно быть float но почему то запись произходить только при таком формате
            $table->string('value');
            $table->date('date');
            $table->index(['char_code', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::drop('exchange_rates');
    }
};
