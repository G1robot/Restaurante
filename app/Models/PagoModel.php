<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagoModel extends Model
{
    protected $table = 'Pago';
    protected $fillable = ['nombre'];
    protected $primaryKey = 'id_pago';
}