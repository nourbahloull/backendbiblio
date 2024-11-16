<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    protected $fillable = ['nomFiliere'];

    public function rapports()
    {
        return $this->hasMany(Rapport::class);
    }
}

