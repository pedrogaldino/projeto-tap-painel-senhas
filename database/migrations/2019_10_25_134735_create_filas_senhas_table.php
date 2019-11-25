<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilasSenhasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filas_senhas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('valor');
            $table->boolean('preferencial')->default(false);
            $table->dateTime('ultima_chamada_em')->nullable();
            $table->unsignedBigInteger('fila_id');
            $table->text('notification_token')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table
                ->foreign('fila_id')
                ->references('id')
                ->on('filas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('filas_senhas');
    }
}
