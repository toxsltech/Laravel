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
use App\Models\PostImage;
use App\Models\User;
use App\Models\Post;
use App\Models\SaveCounters;

class PostLocation extends Authenticatable
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

    const STATE_ACTIVE = 0;

    const STATE_INACTIVE = 1;
    
    const STATE_DELETED = 2;
    
    const COUNTRY_COUNT = 0;
    
    const STATIC_LNG = 0;
    
    const MAP_ZOOM = 0;
    
    const LATITUDE = 36.737232;
    
    const LONGITUDE = 3.086472;
        
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */    
    protected $fillable = [
        'title',
        'post_id',
        'description',
        'location',
        'latitude',
        'longitude',
        'country',
        'state',
        'city',
        'zipcode',
        'state_id',
        'type_id',
        'created_by_id'
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
            return url('/') . '/public/uploads/card_image' . $value;
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
   

    public function isActive()
    {
        return ($this->state_id == User::STATE_ACTIVE);
    }
    
    public function getPost() {
        return $this->belongsTo('App\Models\Post', 'id');
    } 
    public function getCardImage() {
        return $this->belongsTo('App\Models\Post', 'post_id');
    } 
   
    public function getUser() {
        return $this->belongsTo('App\Models\User', 'created_by_id');
    }

    public function getCounter() {
        return $this->hasMany('App\Models\SaveCounters', 'location_id', 'id');
    }
    
    
    public function getLocationImage() {
        return $this->hasMany('App\Models\PostImage', 'post_location_id', 'id');
    }

    
}

