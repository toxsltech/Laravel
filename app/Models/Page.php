<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    
    const STATE_ACTIVE = 1;
    
    const STATE_INACTIVE = 2;
    
    const STATE_DELETED = 3;
    
    const TYPE_TERMS = 1;
    
    const TYPE_POLICIES = 2;

    const TYPE_CONTACT = 3;
    
    const TYPE_MISSION = 4;
        
    
    protected $table = "pages";
    
    protected $fillable = [
        'title',
        'description',
        'created_by_id',
        'type_id',
        'state_id',
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
    
    public static function getTypeOptions()
    {
        return [
            self::TYPE_TERMS => "Terms and Condition",
            self::TYPE_POLICIES => "Privacy Policy",
            self::TYPE_CONTACT => 'Contact  Us',
            self::TYPE_MISSION => 'Our Mission',
        ];
    }
    
    public function getType()
    {
        $list = self::getTypeOptions();
        return isset($list[$this->type_id]) ? $list[$this->type_id] : 'Not Defined';
    }
       
}
