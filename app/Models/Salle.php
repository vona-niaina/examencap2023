<?php

namespace App\Models;

use App\Models\Centre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Salle extends Model
{
    use HasFactory;

    protected $fillable= [
        'numSalle',
        'capaciteSalle',
        'centre_id'
    ] ;

    public function centre()
    {
        return $this->belongsTo(Centre::class);
    }//end func

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }//end func
}
