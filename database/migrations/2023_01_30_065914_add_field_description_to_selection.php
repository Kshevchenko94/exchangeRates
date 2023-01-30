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
        Schema::create('descriptions', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable()->default(null);
            $table->timestamps();
        });

        Schema::table('selections', function (Blueprint $table) {
            $table->unsignedBigInteger('description_id')->nullable()->default(null);
            $table->foreign('description_id')->references('id')->on('descriptions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        if (Schema::hasColumn('selections', 'description_id')) {
            Schema::table('selections', function (Blueprint $table) {
                $table->dropColumn('description_id');
            });
        }
        Schema::drop('descriptions');
    }
};
