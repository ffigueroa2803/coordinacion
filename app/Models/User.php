<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Tools\Bearer;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function tokens() {
        return $this->hasMany(Token::class);
    }


    public function session() {
        return $this->hasOne(Token::class);
    }


    public function scopeAuth($query) {
        return $query->with([
            'session' => function($tok) {
                $tok->where("token", Bearer::getToken())
                    ->where("is_revoked", 0);
            }
        ])->whereHas('tokens', function($tok) {
            $tok->where("token", Bearer::getToken())
                ->where("is_revoked", 0);
        });
    }

    
}
