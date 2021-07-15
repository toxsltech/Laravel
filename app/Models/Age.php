<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Age extends Model
{
    use HasFactory;
    
    
    const STATE_ACTIVE = 1;
    
    const STATE_INACTIVE = 2;
    
    const STATE_DELETED = 3;
    
  
    
    protected $table = "age";
    
    protected $fillable = [
        'age',
        'created_by_id',
        'state_id'
    ];
    
    public static function getStateOptions()
    {
        return [
            self::STATE_ACTIVE => "Active",
            self::STATE_INACTIVE => "Inactive",
            self::STATE_DELETED => 'Deleted'
        ];
    }
    
    public function getState()
    {
        $list = self::getStateOptions();
        return isset($list[$this->state_id]) ? $list[$this->state_id] : 'Not Defined';
    }
    
    
    
    
}
