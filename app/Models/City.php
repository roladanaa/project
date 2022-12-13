<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class City extends Model
{


    protected $fillable = ['name_en','name_ar'];
    use HasFactory;

    public function componies(){
        return $this->hasMany(Compony::class);
    }

    public function employees(){
        return $this->hasMany(Employee::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }

    public function subCategores(){
        return $this->hasMany(SubCategory::class);
    }

    public function name() : Attribute {
        return Attribute::make(
            get: fn() => App::isLocale('ar') ? $this->name_ar : $this->name_en,
        ); 
    }

    public function state() : Attribute {
        return Attribute::make(
            get:fn() => $this->status == 'active' ? __('dash.available') : __('dash.block'),
        ); 
    }

}
