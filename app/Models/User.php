<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function city(){
        return $this->belongsTo(City::class);
    }

    public function walletSubCategores(){
        return $this->hasMany(WalletSubCategory::class);
    }

    public function wallet(){
        return $this->hasOne(wallet::class);
    }

    // This Morph Relations , Sender two type {PayPoint , Users}
    public function senderWalletUsers(){
        return $this->morphMany(HistoryWallet::class,'object','object_type','object_id','id');
    }

    // Resever this table only {users}
    public function reseverWalletUsers(){
        return $this->hasMany(HistoryWallet::class,'user_id','id');
    }

    public function state() : Attribute {
        return Attribute::make(
            get : fn() => $this->status == 'active' ? __('dash.available') : __('dash.block'),
        ); 
    }


    public function findForPassport($username){
        return $this->where('email',$username)->orWhere('mobile',$username)->orWhere('national_id',$username)->first();
    }
    
}
