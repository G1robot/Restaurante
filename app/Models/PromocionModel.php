<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromocionModel extends Model
{
    protected $table = 'Promocion';
    protected $fillable = ['nombre', 'descuento', 'fecha', 'foto', 'estado'];
    protected $primaryKey = 'id_promocion';
}
