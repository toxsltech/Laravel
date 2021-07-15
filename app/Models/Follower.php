<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    use HasFactory;
    
    const MODEL_NAME = 'Follow';
    
    const TITLE = 'User follow';
    
    const DESC = 'User follow description';
     
    protected $table = 'followers';

    protected $fillable = [        
        'follower_id',
        'following_id',
        'status'
    ];
    
    public function getFollowerUser()
    {
        return $this->hasOne("App\Models\User", "id", "follower_id");
    }
    
    public function getProfileImage()
    {
        return $this->hasOne("App\Models\User", "id", "follower_id");
    }
    
}
