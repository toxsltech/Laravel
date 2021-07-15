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

class PostImage extends Authenticatable
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

    const STATE_ACTIVE = 1;

    const STATE_INACTIVE = 2;

    const STATE_DELETED = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'post_images';
    
    protected $fillable = [
        'location_image',
        'post_location_id',
        'model_type',
        'model_id',
        'created_by_id'
    ];

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
   

    public function isActive()
    {
        return ($this->state_id == User::STATE_ACTIVE);
    }
}

