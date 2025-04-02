<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VentaModel extends Model
{
    protected $table = 'Venta';
    protected $fillable = ['fecha','total','id_usuario','id_cliente','id_pago','id_promocion','estado','id_restaurante'];
    protected $primaryKey = 'id_venta';
}