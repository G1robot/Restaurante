<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioModel extends Model
{
    protected $table = 'Usuario';
    protected $fillable = ['nombre', 'apellidos', 'ci', 'usuario', 'contrasena', 'rol'];
    protected $primaryKey = 'id_usuario';
}
