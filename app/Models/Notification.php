<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    const UN_READ = 0;
    
    const READ = 1;

    protected $table = 'notifications';

    protected $fillable = [        
        'user_id',
        'to_user_id',
        'model_id',
        'model_type',
        'title',
        'description',
        'is_read',
        'status'
    ];
    
    public function getUser() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
