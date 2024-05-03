<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("agenda", function (Blueprint $table) {
            $table->id();
            $table->string("nome", 150);
            $table->text("descricao");
            $table->timestamp("data_conclusao")->nullable();
            $table
                ->enum("status", ["Pendente", "Concluído"])
                ->default("Pendente");
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
        Schema::dropIfExists("agenda");
    }
}
