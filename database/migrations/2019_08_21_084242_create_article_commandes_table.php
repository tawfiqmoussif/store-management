<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleCommandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_commandes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->Integer('taille');
            $table->biginteger('qte');
            $table->biginteger('commande_id')->unsigned();
            $table->foreign('commande_id')->references('id')->on('commandes');
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
        Schema::dropIfExists('article_commandes');
    }
}
