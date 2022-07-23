<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sentiment extends Model
{
    protected $table = 'sentiment';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    public function figure()
    {
        return $this->belongsTo('App\Models\Figure', 'figure_id');
    }
    public function tweet()
    {
        return $this->hasMany('App\Models\Tweet', 'sentiment_id');
    }
}
