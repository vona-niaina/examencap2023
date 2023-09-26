<?php

namespace App\Models;

use App\Models\Etab;
use App\Models\User;
use App\Models\Cisco;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Zap extends Model
{
    use HasFactory;

    protected $fillable= [
        'codeZap',
        'nomZap',
        'cisco_id'
    ] ;

    public function cisco()
    {
        return $this->belongsTo(Cisco::class);
    }//end func

    public function etabs()
    {
        return $this->hasMany(Etab::class);
    }//end func

    public function users()
    {
        return $this->hasManyThrough(User::class, Etab::class);
    }//end func
}
