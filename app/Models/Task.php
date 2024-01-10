<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Task extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'company_id',
        'guard_id',
        'site_id',
        'title',
        'description',
        'comments',
        'date',
        'from',
        'to',
        'status'
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
