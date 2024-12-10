<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
    Schema::table('pedidos', function (Blueprint $table) {
        $table->string('direccion');
        $table->string('provincia');
        $table->string('codigo_postal');
        $table->string('forma_pago');
        $table->string('nombre_receptor');
     });
    }

    public function down() 
    {
    Schema::table('pedidos', function (Blueprint $table) {
        $table->dropColumn(['direccion', 'provincia', 'codigo_postal', 'forma_pago', 'nombre_receptor']);
     });
    }

};
