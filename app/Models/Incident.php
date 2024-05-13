<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Incident extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'company_id',
        'guard_id',
        'site_id',
        'incident_no',
        'title',
        'status',
        'details',
        'actions_taken',
        'police_ref',
        'reported_by',
        'date',
        'time',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('incident_images');
    }

    public function siteIncident()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }

    public function owner()
    {
        return $this->belongsTo(Guard::class, 'guard_id');
    }
}
