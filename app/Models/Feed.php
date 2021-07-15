<?php
namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{

    const STATE_INACTIVE = 0;
    
    const STATE_ACTIVE = 1;
    
    const STATE_DELETED = 2;

    const TYPE_WEB = 1;

    const TYPE_API = 2;
    
    const CONTENT_DATA = 'New Post Added';
    
    const CONTENT_USER = 'New User Added';

    protected $table = "feeds";

    protected $fillable = [
        'content',
        'user_ip',
        'user_agent',
        'failure_reason',
        'type_id',
        'state_id',
        'model_type',
        'model_id',
        'created_by_id'
    ];

    public static function getStatus($id = null)
    {
        $list = array(
            self::STATE_ACTIVE => "Active",
            self::STATE_INACTIVE => "Inactive",
            self::STATE_DELETED => "Deleted"
        );
        if ($id === null)
            return $list;
            return isset($list[$id]) ? $list[$id] : 'Not Defined';
    }        
    
    public static function getState($id = null)
    {
        $list = array(
            self::STATE_ACTIVE => "Active",
            self::STATE_INACTIVE => "Inactive",
            self::STATE_DELETED => "Deleted"
        );
        if ($id === null)
            return $list;
            return isset($list[$id]) ? $list[$id] : 'Not Defined';
    }    

    public static function getTypeOptions()
    {
        return [
            self::TYPE_WEB => "Web",
            self::TYPE_API => "Mobile"
        ];
    }

    public function getType()
    {
        $list = self::getTypeOptions();
        return isset($list[$this->type_id]) ? $list[$this->type_id] : 'Not Defined';
    }

    public function getUser()
    {
        return $this->belongsTo('App\models\User', 'created_by_id');
    }

    public static function add($request, $data, $url, $id,  $state, $type)
    {
        $feed = new Feed();
        $feed->content = $data;
        $feed->user_ip = $request->ip();
        $feed->user_agent = $request->server('HTTP_USER_AGENT');
        $feed->model_type=$url;
        $feed->model_id = $id;
        $feed->state_id = $state;
        $feed->type_id = $type;
        $feed->created_by_id = Auth::id();
        if ($feed->save()) {
            return true;
        }
        return false;
    }
}
