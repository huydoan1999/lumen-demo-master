<?php

namespace App\Api\Entities;

use App\Api\Transformers\UserTransformer;
use Gma\Acl\Traits\GmaUserTrait;
use Dingo\Api\Http\Request;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Moloquent\Eloquent\Model as Moloquent;
use Moloquent\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Api\Entities\Organization;
use Illuminate\Support\Facades\Auth;
use App\Api\Entities\Shop;

class User extends Moloquent implements AuthenticatableContract, JWTSubject
{
    use Authenticatable, GmaUserTrait, SoftDeletes;
    protected $collection = 'users';

    /**
     * To make all fields fillable.
     */
    protected $guarded = array();

    protected $hidden = ['services', 'actived_date', 'register_ip', 'visited_date', 'visited_ip'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'visited_date',
        'birthday',
        'labour_end_date',
        'working_date',
        'identify_date',
        'passport_date',
        'passport_expiry_date',
        'finish_date',
        'from_date',
        'to_date',
        'health_last_date',
        '_updatedAt',
    ];

    public static function getPublicField(){
        //return $this->fillable;
    }
    // jwt implementation
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    // jwt implementation
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function transform($type = '')
    {
        $transformer = new UserTransformer();

        return $transformer->transform($this, $type);
    }

    public function shop() {
        $shop = null;
        if(!empty($this->shop_id)) {
            $shop = Shop::where(['_id' => mongo_id($this->shop_id)])->first();
        }
        return $shop;
    }
}
