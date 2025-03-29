<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlatoModel extends Model
{
    protected $table = 'Plato';
    protected $fillable = ['nombre','precio','stock','estado','descripcion','foto'];
    protected $primaryKey = 'id_producto';
}
