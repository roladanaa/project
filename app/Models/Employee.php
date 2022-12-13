<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Authenticatable
{
    use HasFactory,HasRoles,Notifiable;

    public function city(){
        return $this->belongsTo(City::class);
    }
    public function PayPoint(){
        return $this->belongsTo(PayPoint::class);
    }

    // This Morph Relations , Sender two type {PayPoint , Users}
    public function senderWalletUsers(){
        return $this->morphMany(HistoryWallet::class,'object','object_type','object_id','id');
    }
}
