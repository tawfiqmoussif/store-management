<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLigneEntreesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ligne_entrees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('entree_id')->unsigned();
            $table->foreign('entree_id')->references('id')->on('entrees');
            $table->biginteger('serie_id')->unsigned();
            $table->foreign('serie_id')->references('id')->on('series');
            $table->biginteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->float('prix_unitaire');
            $table->float('prix_de_vente');
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
        Schema::dropIfExists('ligne_entrees');
    }
}
