<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CV extends Model
{
    protected $table = 'cvs';

    protected $fillable = ['user_id', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function media()
    {
        return $this->morphOne(Media::class, 'mediable');
    }
    public function workExperiences()
    {
        return $this->hasMany(Experience::class, 'cv_id', 'id');
    }
    public function skills()
    {
        return $this->hasMany(Skill::class, 'cv_id', 'id');
    }
    public function languages()
    {
        return $this->belongsToMany(Language::class, 'language_cvs', 'cv_id', 'language_id')->withPivot('id', 'level');
    }
}
