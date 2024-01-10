<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatrolHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'site_id',
        'guard_id',
        'patrol_id',
        'tag_id',
        'date',
        'time',
        'status'
    ];

    public function patrol()
    {
        return $this->belongsTo(Patrol::class, 'patrol_id');
    }

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function owner()
    {
        return $this->belongsTo(Guard::class, 'guard_id');
    }
}
