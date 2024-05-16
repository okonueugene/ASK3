<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patrol extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start',
        'end',
        'company_id',
        'site_id',
        'guard_id',
        'type'
    ];
    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }

    public function owner()
    {
        return $this->belongsTo(Guard::class, 'guard_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function history()
    {
        return $this->hasMany(PatrolHistory::class);
    }
}
