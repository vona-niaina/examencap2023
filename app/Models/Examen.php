<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examen extends Model
{
    use HasFactory;

    protected $fillable= [
        'typeExamen',
        'anneeExamen',
        'debutExamen',
        'finExamen',
        'debutInscription',
        'finInscription'
    ] ;

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }//end func
}
