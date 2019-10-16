<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{

    protected $fillable = ['level'];

    public function cv()
    {
        return $this->belongsToMany(CV::class, 'language_cvs');
    }
}
