<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('productos', function (Blueprint $table) {
        $table->integer('cantidad')->default(0); // Añade el campo de cantidad con valor por defecto 0
    });
}

public function down(): void
{
    Schema::table('productos', function (Blueprint $table) {
        $table->dropColumn('cantidad');
    });
}
};
