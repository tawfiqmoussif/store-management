<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('fournisseur')->unsigned();
            $table->foreign('fournisseur')->references('id')->on('users');
            $table->biginteger('client')->unsigned();
            $table->foreign('client')->references('id')->on('users');
            $table->biginteger('serie_id')->unsigned();
            $table->foreign('serie_id')->references('id')->on('series');
            $table->string('etat');
            $table->string('date');
            $table->float('prix');
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
        Schema::dropIfExists('commandes');
    }
}
