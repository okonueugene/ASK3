<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Sos extends Model
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'company_id',
        'guard_id',
        'site_id',
        'date',
        'time',
        'latitude',
        'longitude',
    ];

    public function owner()
    {
        return $this->belongsTo(Guard::class, 'guard_id');
    }

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    


}
