<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ventas extends Model
{
    use HasFactory;
    protected $fillable = [
        'fecha',
        'metodo',
        'total',
        'cliente_id',
    ];
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
    public function ventas()
    {
        return $this->belongsTo(Ventas::class, 'venta_id');
    }
    // En el modelo Ventas
    public function detalles()
    {
        return $this->hasMany(Detalleventas::class, 'venta_id');
    }
}
