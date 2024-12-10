<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{
    protected $fillable = ['nombre', 'descripcion', 'precio', 'imagen_url'];
}
