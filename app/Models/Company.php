<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;


    protected $fillable = [
        'company_name',
        'company_email',
        'status',
    ];
    public function users(){
        return $this->hasMany(User::class);
    }

    public function sites(){
        return $this->hasMany(Site::class);
    }

    public function patrolhistory(){
        return $this->hasMany(PatrolHistory::class);
    }

}
