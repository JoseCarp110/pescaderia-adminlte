<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->string('direccion')->nullable(false)->change(); // Cambia si deseas permitir valores NULL
        });
    }

    public function down()
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->string('direccion')->nullable()->change(); // Reversión a NULL si fuera necesario
        });
    }
};