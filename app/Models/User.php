<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
      'username','email', 'password', 'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Relationships
     */
    public function battleplans() {
      return $this->hasMany('App\Models\Battleplan', 'user_id');
    }

    public function room() {
      return $this->hasMany('App\Models\Room', 'owner');
    }

    /**
     * Public Methods
     */
    public function isAdmin(){
      return $this->id == 1;
    }
}
