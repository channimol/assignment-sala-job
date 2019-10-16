<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $table = "work_experiences";
    protected $fillable = [
        "title", "cv_id", "company", "location", "start_date", "end_date", "description", "references"
    ];

    public function cv()
    {
        return $this->belongsTo(CV::class);
    }
}
