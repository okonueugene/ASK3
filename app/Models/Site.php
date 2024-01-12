<?php

namespace App\Models;

use App\Models\User;
use App\Models\Guard;
use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Site extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;


    protected $fillable = [
        'name',
        'location',
        'lat',
        'long',
        'user_id',
        'company_id',
        'timezone',
        'country',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('site_logo')->singleFile();
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function guards()
    {
        return $this->hasMany(Guard::class, 'site_id');
    }
    public function patrols()
    {
        return $this->hasMany(Patrol::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    public function incidents()
    {
        return $this->hasMany(Incident::class, 'site_id');
    }

}
