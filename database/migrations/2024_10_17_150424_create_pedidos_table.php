<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('pedidos', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id'); // Usuario que hizo el pedido
        $table->decimal('total', 8, 2); // Total del pedido
        //$table->string('status')->default('pendiente'); // Estado del pedido
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
