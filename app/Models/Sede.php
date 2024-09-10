<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    use HasFactory;

    public $fillable = ['sed_nombre', 'sed_direccion', 'sed_ciudad', 'sed_telefono', 'sed_activo'];
}
