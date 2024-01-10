<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guard extends Authenticatable
{
    use HasFactory;
    use LogsActivity;
    use HasApiTokens;
    use Notifiable;



    protected $fillable = [
        'name',
        'email',
        'phone',
        'company_id',
        'id_number',
        'is_active',
        'password',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
    ];



    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->useLogName('Guard')
        ->setDescriptionForEvent(fn(string $eventName) => "A Guard has been {$eventName}")
        ->logOnly(['*']);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function patrols()
    {
        return $this->hasMany(Patrol::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function dobs()
    {
        return $this->hasMany(Dob::class);
    }

    public function incidents()
    {
        return $this->hasMany(Incident::class, 'guard_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'guard_id');
    }

}
