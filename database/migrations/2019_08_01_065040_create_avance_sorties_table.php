<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvanceSortiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avance_sorties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('sortie_id')->unsigned();
            $table->foreign('sortie_id')->references('id')->on('sorties');
            $table->biginteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('type_paiement');
            $table->date('date');
            $table->string('numero')->nullable();
            $table->string('valider');
            $table->string('description');
            $table->float('montant');
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
        Schema::dropIfExists('avance_sorties');
    }
}
