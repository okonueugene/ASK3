<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dob extends Model
{
    use HasFactory;

    protected $fillable = [
        'dob_no',
        'comments',
        'date',
        'time',
        'time_duty_start',
        'time_duty_end',
        'company_id',
        'guard_id',
        'site_id'
    ];

    public function owner(){
        return $this->belongsTo(Guard::class, 'guard_id');
    }

}

