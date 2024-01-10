<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'time_in',
        'time_out',
        'guard_id',
        'day',
        'company_id',
        'site_id'
    ];

    public function owner()
    {
        return $this->belongsTo(Guard::class, 'guard_id');
    }

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }
}
