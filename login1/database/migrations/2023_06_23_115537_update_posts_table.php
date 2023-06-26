<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            //creo la foreign key mancante
            $table->unsignedBigInteger('user_id')->after('id');
            //2 assegno la foreign key alla colonna creata ovvero dico che la colonna appena creata e una FK


            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
                        //1 elimino la foreign key Tra parentesi devo mettere il nome della colonna quindi uso quadre

            $table->dropForeign(['user_id']);
                        //2 cancella la colonna

            $table->dropColumn('user_id');
        });
    }
};