<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    protected $table = 'tweet';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;
    
    public function sentiment()
    {
        return $this->belongsTo('App\Models\Sentiment', 'sentiment_id');
    }
}
