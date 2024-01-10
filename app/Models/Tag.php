<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'site_id',
        'name',
        'type',
        'code',
        'location',
        'lat',
        'long'
    ];

    public function patrols()
    {
        return $this->belongsTo(Patrol::class);
    }

    public function history()
    {
        return $this->hasMany(PatrolHistory::class);
    }
}
