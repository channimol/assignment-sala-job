<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles, HasApiTokens, Notifiable;

    protected $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'dob', 'gender_id', 'phone', 'department_id', 'role_id', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email_verified_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['role_list', 'department_name', 'media_url'];

    public function media()
    {
        return $this->morphOne(Media::class, 'mediable');
    }

    public function jobs()
    {
        return $this->hasMany(Job::class, 'published_by', 'id');
    }

    public function applyJobs()
    {
        return $this->belongsToMany(Job::class, 'applied_jobs', 'user_id', 'job_id')->with('medias');
    }
    public function bookmarkJobs()
    {
        return $this->belongsToMany(Job::class, 'bookmarks', 'user_id', 'job_id')->with('medias');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function cv()
    {
        return $this->hasOne(CV::class);
    }

    public function getRoleListAttribute()
    {
        return $this->roles->pluck('name');
    }

    public function getDepartmentNameAttribute()
    {
        $department = $this->department;
        if (is_null($department)) {
            return  null;
        } else {
            return $department->name;
        }
    }

    public function getMediaUrlAttribute()
    {
        $media = $this->media;
        return $media;
    }
}
