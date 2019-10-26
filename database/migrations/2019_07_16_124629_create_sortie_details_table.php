<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSortieDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sortie_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('article_id')->unsigned();
            $table->foreign('article_id')->references('id')->on('articles');
            $table->biginteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->float('prix_de_vente_1');
            $table->float('prix_de_vente_2');
            $table->biginteger('nombre');
            $table->date('date');
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
        Schema::dropIfExists('sortie_details');
    }
}
