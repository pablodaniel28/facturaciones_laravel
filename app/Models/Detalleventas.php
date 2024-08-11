<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalleventas extends Model
{
    use HasFactory;
    protected $fillable = [
        'venta_id',
        'monto',
        'cantidad',
        'descuento',
        'producto_id',
    ];
    public function detalles()
    {
        return $this->belongsTo(DetalleVentas::class, 'venta_id');
    }
    public function producto()
    {
        return $this->belongsTo(producto::class, 'producto_id');
    }

}

