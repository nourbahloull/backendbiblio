<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rapport extends Model
{
    protected $fillable = ['titre', 'description', 'filiere_id'];

    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }
}

