<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            //$table->id();
            $table->string('id');
            $table->string('cedula');
            $table->string('nombre');
            $table->string('apellido')->default('Araujo');
            $table->date('fecha_nac');
            $table->date('fecha_ing')->nullable(true);
            $table->integer('edad');
            $table->dateTime('contratado', $precision = 0);
            $table->string('email', 100);
            $table->boolean('trabajando');
            $table->decimal('sueldo', $precision = 8, $scale = 2);
            $table->double('bono', 8, 2);
            $table->float('primas', 8, 2);
            $table->ipAddress('mi_ip');
            $table->json('opciones');
            $table->text('observacion');
            $table->timestamps();
            $table->primary(['id', 'cedula']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
