<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Rappasoft\LaravelAuthenticationLog\Traits\AuthenticationLoggable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasRoles;
    use HasFactory;
    use AuthenticationLoggable;
    use Notifiable;
    use LogsActivity;

    /**



     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'company_id',
        'phone',
        'is_active',
        'last_login_at',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */

    protected $hidden = [
        'password',
        'remember_token',

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

    protected $casts = [
        'email_verified_at' => 'datetime',

    ];



    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->setDescriptionForEvent(fn(string $eventName) => "A User has been {$eventName}")
        ->useLogName('User')
        ->logOnly(['name', 'email', 'phone', 'is_active', 'last_login_at', 'company_id'])
        ->logOnlyDirty();
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function site()
    {
        return $this->hasOne(Site::class);
    }

}
