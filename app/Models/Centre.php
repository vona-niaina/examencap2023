<?php

namespace App\Models;

use App\Models\Salle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Centre extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomCentre',
        'emplacementCentre',
        'texteNumCandidat'
    ];

    public function salles()
    {
        return $this->hasMany(Salle::class);
    }//end func
}
