<?php

namespace App\Http\Controllers\Api\V1;

use App\Api\Repositories\Contracts\RoleRepository;
use App\Api\Repositories\Contracts\UserRepository;
use App\Api\Repositories\Contracts\ShopRepository;

use App\Http\Controllers\Controller;
use Dingo\Api\Facade\API;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Api\Entities\Role;
use App\Api\Entities\User;
/**
 * AuthController.
 */
class AuthController extends Controller
{
    /**
    * UserRepository
    **/
    protected $userRepository;

    /**
    * RoleRepository
    **/
    protected $roleRepository;

    /**
    * ShopRepository
    **/
    protected $shopRepository;

    protected $request;

    protected $auth;

    public function __construct(UserRepository $userRepository, 
                                RoleRepository $roleRepository, 
                                ShopRepository $shopRepository,
                                Request $request,
                                AuthManager $auth)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->shopRepository = $shopRepository;
        $this->request = $request;
        $this->auth = $auth;

        parent::__construct();
    }
    /**
     * @api {post} /auth/login 1.Login
     * @apiDescription (login)
     * @apiGroup Auth
     * @apiPermission none
     * @apiParam {Email} email
     * @apiParam {String} password
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *         token: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6XC9cL21vYmlsZS5kZWZhcmEuY29tXC9hdXRoXC90b2tlbiIsImlhdCI6IjE0NDU0MjY0MTAiLCJleHAiOiIxNDQ1NjQyNDIxIiwibmJmIjoiMTQ0NTQyNjQyMSIsImp0aSI6Ijk3OTRjMTljYTk1NTdkNDQyYzBiMzk0ZjI2N2QzMTMxIn0.9UPMTxo3_PudxTWldsf4ag0PHq1rK8yO9e5vqdwRZLY
     *     }
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": "UserNotFound"
     *     }
     */
    public function login()
    {
        // Validate Data import.
        $validator = \Validator::make($this->request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|min:8',
        ]);
        if ($validator->fails()) {
            return $this->errorBadRequest($validator->messages()->toArray());
        }

        $credentials = $this->request->only('email', 'password');

        $credentials['email'] = strtolower($credentials['email']);
        if (!$token = $this->auth->attempt($credentials)) {
            return $this->errorUnauthorized([trans('auth.incorrect')]);
        }

        $data = array('token' => $token);

        $this->auth->setToken($token);
        $user = $this->auth->user();

        return $this->successRequest($data);
    }
}
