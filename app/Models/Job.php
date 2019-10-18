<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'title', 'description', 'requirement', 'salary',
        'job_source_id', 'schedule_type_id', 'department_id',
        'published_by', 'contact_email'
    ];

    public function publisher()
    {
        return $this->belongsTo(User::class, 'published_by', 'id');
    }

    public function medias()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function studentsApply()
    {
        return $this->belongsToMany(User::class, 'applied_jobs', 'job_id', 'user_id');
    }

    public function studentsBookmark()
    {
        return $this->belongsToMany(User::class, 'bookmarks', 'job_id', 'user_id');
    }
}
