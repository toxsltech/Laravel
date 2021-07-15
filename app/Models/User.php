<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    use Notifiable;
    
    const ROLE_ADMIN = 1;
    
    const ROLE_USER = 2;    
  
    const STATE_ACTIVE = 1;
    
    const STATE_INACTIVE = 2;
    
    const STATE_DELETED = 3;
    
    const TERM_CONDITION = 1;
    
    const RESET_KEY = 16;  
    
    const SOCIAL_GOOGLE = 1;
    
    const SOCIAL_FACEBOOK = 2; 
    
    const EMAIL_NOT_VERIFIED = 0;
    
    const EMAIL_VERIFIED = 1;

    const MODEL_NAME = 'User';
    
    const TYPE_BLOCK = 2;
    
    const TYPE_UNBLOCK = 1;   
    
    const TITLE = 'Profile Update';
 
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',        
        'role_id',
        'state_id',
        'type_id',
        'social_id ',
        'social_type'
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];
    
    
    public function getResetUrl()
    {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));
        
        for ($i = 0; $i < USER::RESET_KEY; $i ++) {
            $key .= $keys[array_rand($keys)];
        }
        
        $this->password_reset_token = $key;
        if ($this->save()) {
            return true;
        } else {
            return false;
        }
    }
    
    public function getProfileFileAttribute($value)
    {
        if ($value != '') {
            return url('/') . '/public/uploads/' . $value;
        }
        return $value;
    }
    
    public static function getStatus($id = null)
    {
        $list = array(
            self::STATE_ACTIVE => "Active",
            self::STATE_INACTIVE => "Inactive",
            self::STATE_DELETED => "Deleted"
        );
        if ($id === null)
            return $list;
    }
    
    public static function getRole($id = null)
    {
        $list = array(
            self::ROLE_ADMIN => "Admin",
            self::ROLE_USER => "User",          
        );
        if ($id === null)
            return $list;
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
    }
    
    public static function getType($id = null)
    {
        $list = array(
            self::TYPE_BLOCK => "Block",
            self::TYPE_UNBLOCK => "Un-Block",
        );
        if ($id === null)
            return $list;
       return isset($list[$id]) ? $list[$id] : 'Not Defined';
    }
    
    public function getVerified()
    {
        return url("/user/confirm-email/{$this->activation_key}");
    }
    
    public static function isAdmin()
    {
        $user = Auth::user();
        if ($user == null)
            return false;            
    }
    
    public static function isUser()
    {
        $user = Auth::user();
        if ($user == null)
            return false;
    }
    
    public function isActive()
    {
        return ($this->state_id == User::STATE_ACTIVE);
    } 
    
    public function generateAuthKey()
    {
        $this->activation_key = Str::random(32);
    }
    
    public function generateAccessToken()
    {
        $this->access_token = Str::random(32);
    }

    public static function allRelatedDelete($id,$model)
    {
        $user = $model::where('created_by_id','=', $id)->get();        
        foreach($user as $value){
            $value->delete();   
        }
        return true;
    }

    public function getfollower() {
        return $this->hasMany('App\Models\Follower', 'following_id', 'id');
    }
}