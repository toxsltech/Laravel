<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaveCounters extends Model
{
    use HasFactory;
    
    const MODEL_NAME = 'Bookmark';
    
    const TITLE = 'Bookmark title';
    
    const DESC = 'Bokmark description';
    
    protected $table = "save_counter";

    protected $fillable = [        
        'user_id',
        'post_id',
        'status'
    ];

    public function getSaveCounterLocation()
{   
    return $this->hasMany('App\Models\PostLocation','post_id','post_id');
}

 public function getSaveCounterCardImg()
{
    return $this->hasOne("App\Models\Post", "id", "post_id");
}
}
