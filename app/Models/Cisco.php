<?php

namespace App\Models;

use App\Models\Zap;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cisco extends Model
{
    use HasFactory;

    protected $fillable = [
        'codeCisco',
        'nomCisco'
    ];
    
    public function zaps()
    {
        return $this->hasMany(Zap::class);
    }//end func

}
