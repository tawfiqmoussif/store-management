<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('personne_id')->unsigned();
            $table->foreign('personne_id')->references('id')->on('personnes');
            $table->biginteger('magasin_id')->unsigned();
            $table->foreign('magasin_id')->references('id')->on('magasins');
            $table->biginteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('salaire');
            $table->string('sommesalaires');
            $table->date('date_recrutement');
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
        Schema::dropIfExists('employes');
    }
}
