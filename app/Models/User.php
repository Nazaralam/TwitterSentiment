<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;
    
    public function sentiment()
    {
        return $this->hasMany('App\Models\Sentiment', 'user_id');
    }
}
