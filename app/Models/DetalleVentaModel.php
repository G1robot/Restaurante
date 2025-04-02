<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleVentaModel extends Model
{
    protected $table = 'Detalle_venta';
    protected $fillable = ['cantidad','id_plato','id_venta'];
    protected $primaryKey = 'id_detalle';
}