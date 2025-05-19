<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total',
        'status',
        'direccion',
        'provincia',
        'codigo_postal',
        'forma_pago',
        'nombre_receptor',
    ];

    public function usuario()
    {
    return $this->belongsTo(User::class, 'user_id');
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'pedido_producto')->withPivot('cantidad', 'precio');
    }
}