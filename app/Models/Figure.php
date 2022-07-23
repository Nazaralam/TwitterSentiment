<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Figure extends Model
{
    protected $table = 'figure';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;
    
    public function sentiment()
    {
        return $this->hasMany('App\Models\Sentiment', 'figure_id');
    }
}
