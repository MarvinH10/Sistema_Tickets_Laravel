<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pabellon extends Model
{
    use HasFactory;

    protected $fillable = [
        'pab_nombre', 
        'pab_activo', 
        'sed_id', 
    ];

    public function sede()
    {
        return $this->belongsTo(Sede::class, 'sed_id');
    }

}
