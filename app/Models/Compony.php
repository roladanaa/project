<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Compony extends Authenticatable
{
    use HasFactory,HasRoles,Notifiable;

    protected $fillable = ['*'];

    public function city(){
        return $this->belongsTo(City::class);
    }
    public function payPoints(){
        return $this->hasMany(PayPoint::class);
    }

    public function category(){
        return $this->hasMany(Category::class);
    }
}
