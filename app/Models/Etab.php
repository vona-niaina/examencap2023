<?php

namespace App\Models;

use App\Models\Zap;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Etab extends Model
{
    use HasFactory;

    protected $fillable= [
        'codeEtab', 'nomEtab', 'codeSecteurEtab', 'codeNiveauEtab', 'zap_id'
    ];

    // zap
    public function zap()
    {
        return $this->belongsTo(Zap::class);
    }//end func

    // users candidat
    public function users()
    {
        return $this->hasMany(User::class);
    }//end func

}
