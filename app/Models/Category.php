<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Category extends Model
{
    use HasFactory;

    public function subCategory(){
        return $this->hasMany(SubCategory::class);
    }

    public function compony(){
        return $this->belongsTo(Compony::class);
    }

    public function name() : Attribute {
        return Attribute::make(
            get: fn() => App::isLocale('ar') ? $this->name_ar : $this->name_en,
        ); 
    }

    public function state() : Attribute {
        return Attribute::make(
            get : fn() => $this->status == 'active' ? __('dash.available') : __('dash.block'),
        ); 
    }
}
