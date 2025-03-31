<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'Cliente';
    protected $primaryKey = 'id_cliente';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'apellidos',
        'ci',
    ];
}
