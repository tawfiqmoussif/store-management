<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLigneSortiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ligne_sorties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('sortie_id')->unsigned();
            $table->foreign('sortie_id')->references('id')->on('sorties');
            $table->biginteger('serie_id')->unsigned();
            $table->foreign('serie_id')->references('id')->on('series');
            $table->biginteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->float('prix_unitaire');
            $table->integer('qte');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ligne_sorties');
    }
}
