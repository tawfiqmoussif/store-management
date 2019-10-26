<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvanceEntreesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avance_entrees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('entree_id')->unsigned();
            $table->foreign('entree_id')->references('id')->on('entrees');
            $table->biginteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('type_paiement');
            $table->string('numero')->nullable();
            $table->string('valider');
            $table->date('date');
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
        Schema::dropIfExists('avance_entrees');
    }
}
