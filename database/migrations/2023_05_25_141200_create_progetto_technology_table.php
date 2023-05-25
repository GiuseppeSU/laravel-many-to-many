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
            $table->foreign('progetto_id')->references('id')->on('progetti')->onDelete('CASCADE');


            $table->unsignedBigInteger('tecnology_id');
            $table->foreign('tecnology_id')->references('id')->on('tecnologies')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('progetto_technology');
    }
};