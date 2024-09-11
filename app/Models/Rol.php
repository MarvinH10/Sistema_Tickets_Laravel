<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    public $fillable = ['rol_nombre', 'rol_activo'];

    public function users()
    {
        return $this->hasMany(User::class, 'rol_id');
    }
}
