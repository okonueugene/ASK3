<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


class Attendance extends Model
{
    use HasFactory;
    use LogsActivity;


    protected $fillable = [
        'time_in',
        'time_out',
        'guard_id',
        'day',
        'company_id',
        'site_id'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->useLogName('Attendance')
        ->logOnly(['*'])
        ->logOnlyDirty() 
        ->setDescriptionForEvent(function (string $eventName) {
            $guardName = $this->owner->name ?? 'Unknown';
            $siteName = $this->site->name ?? 'Unknown';
            return "$guardName has just logged in to " . $siteName;
        });


    }

    public function owner()
    {
        return $this->belongsTo(Guard::class, 'guard_id');
    }

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }
}
