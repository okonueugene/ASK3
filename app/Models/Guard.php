<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Guard extends Authenticatable
{
    use HasFactory;
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
    public function scopeSearch($query, $term)
    {
        $term = "%term%";
        $query->where(function ($query) use ($term) {
            $query->where('name', 'like', $term)
                ->orWhere('id_number', 'like', $term)
                ->orWhere('phone', 'like', $term)
                ->orWhere('email', 'like', $term);
        });
    }

    public function shifts()
    {
        return $this->hasMany(Shift::class);
    }

}
