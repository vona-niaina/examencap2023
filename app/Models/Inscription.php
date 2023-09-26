<?php

namespace App\Models;

use App\Models\User;
use App\Models\Salle;
use App\Models\Examen;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inscription extends Model
{
    use HasFactory;

    protected $fillable= [
        'examen_id',
        'user_id',
        'salle_id',
        'numeroUniqueConvocation',
        
        'reussitExam',
        'creditCandidat'
    ] ;

    public function examen()
    {
        return $this->belongsTo(Examen::class);
    }//end 
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }//end func

    public function salle()
    {
        return $this->belongsTo(Salle::class);
    }//end func

}
