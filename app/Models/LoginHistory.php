<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginHistory extends Model
{

    const STATE_SUCCESS = 1;

    const STATE_FAILED = 2;

    const TYPE_WEB = 1;

    const TYPE_API = 2;

    protected $table = "login_history";

    protected $fillable = [
        'user_id',
        'user_ip',
        'user_agent',
        'failure_reason',
        'type_id',
        'state_id',
        'email',
        'link'
    ];

    public static function getStateOptions()
    {
        return [
            self::STATE_SUCCESS => "Success",
            self::STATE_FAILED => "Failed"
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
        return $this->belongsTo('App\models\User', 'user_id');
    }

    public static function add($request, $type, $state, $data)
    {
        $history = new LoginHistory();
        $history->user_ip = $request->ip();
        $history->user_agent = $request->server('HTTP_USER_AGENT');
        $history->state_id = $state;
        $history->type_id = $type;
        $history->link = $request->fullUrl();
        $history->email = $request->input('email');
        if ($state == self::STATE_FAILED) {
            $history->failure_reason = $data;
        } else {
            $history->user_id = $data;
        }
        if ($history->save()) {
            return true;
        }
        return false;
    }
}
