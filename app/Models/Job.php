<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'title', 'description', 'requirement', 'salary',
        'job_source_id', 'schedule_type_id', 'department_id',
        'published_by'
    ];

    protected $appends = ['user_email'];

    public function users()
    {
        $this->belongsTo(User::class, 'id', 'published_by');
    }

    public function medias()
    {
        $this->morphMany(Media::class, 'mediable');
    }

    public function getUserEmailAttribute()
    {
        return $this->users();
    }
}
