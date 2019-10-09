<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'medias';

    protected $fillable = ['mediable_type', 'mediable_id', 'url', 'description', 'name'];

    public function mediable()
    {
        return $this->morphTo();
    }
}
