<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    
    protected $fillable = [
        "type", "token", "user_id", 'is_revoked', 'user_agent'
    ];

}
