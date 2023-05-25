<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progetto_technology', function (Blueprint $table) {
            //$table->id();
            //$table->timestamps();

            $table->unsignedBigInteger('progetto_id');
            $table->foreign('progetto_id')->references('id')->on('progettos')->onDelete('CASCADE');


            $table->unsignedBigInteger('technology_id');
            $table->foreign('technology_id')->references('id')->on('technologies')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('progettos_technology');
    }
};