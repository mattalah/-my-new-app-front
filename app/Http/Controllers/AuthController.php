<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\{AuthLoginRequest, AuthRegisterRequest};
use App\Http\Resources\UserResource;

use Illuminate\{Http\Request, Support\Facades\Auth};

/**
 * Class AuthController.
 *
 * @author  Mattalah saifeddinne<mattalahsaifeddinne@gmail.com>
 */

class AuthController extends AppBaseController
{

    /**
     * AuthController constructor.
     * 
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('logout');
    }

    /**
     * @OA\POST(
     *     path="/user/login",
     *     tags={"user"},
     *     summary="Logs user into system",
     *     operationId="loginUser",
     *     @OA\Parameter(
     *         name="username",
     *         in="query",
     *         description="The user name for login",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\Header(
     *             header="X-Rate-Limit",
     *             description="calls per hour allowed by the user",
     *             @OA\Schema(
     *                 type="integer",
     *                 format="int32"
     *             )
     *         ),
     *         @OA\Header(
     *             header="X-Expires-After",
     *             description="date in UTC when token expires",
     *             @OA\Schema(
     *                 type="string",
     *                 format="datetime"
     *             )
     *         ),
     *         @OA\JsonContent(
     *             type="string"
     *         ),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid username/password supplied"
     *     )
     * )
     */
    public function login(AuthLoginRequest $request)
    {
        $credentials = ['password' => $request->password, 'email' => $request->email];
        if (!Auth::attempt($credentials)) {
            return $this->sendError([
                __('auth.failed')
            ], 401);
        }

        if (Auth::attempt($credentials)) {
            $user = User::where('email', $request->email)->first();
        }
        $user = $request->user();

        return $this->sendTokenResponse($user);
    }


    /**
     * @OA\Post(
     *      path="/auth/register",
     *      operationId="register",
     *      tags={"auth"},
     *      description="register new user",
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *              @OA\Property(
     *                 property="email",
     *                 type="string",
     *              ),
     *              @OA\Property(
     *                 property="password",
     *                 type="string",
     *              ),
     *              @OA\Property(
     *                 property="name",
     *                 type="string",
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="result",
     *                  type="object",
     *                      @OA\Schema(
     *                          schema="UserResource",
     *                          type="object",
     *                          title="UserResource",
     *                          @OA\Items(ref="#/components/schemas/UserResource") 
     *                      ),
     *                      @OA\Property(
     *                          property="message",
     *                          type="string",
     *                      ),
     *              ),
     *          )
     *       )
     *     )
     *
     */
    public function register(AuthRegisterRequest $request)
    {
        // $input = $request->validated();
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password'])
        ]);

        return $this->sendResponse(new UserResource($user), __('auth.verification.registered_account'));
    }

    /**
     * @OA\Get(
     *     path="/auth/logout",
     *     tags={"auth"},
     *     summary="Logs out current logged in user session",
     *     operationId="logoutUser",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return $this->sendSuccess(__('auth.logout_success'));
    }


    /**
     * @param $user
     * @return mixed
     */
    private function sendTokenResponse($user)
    {
        $tokenResult = $user->createToken('Personal Access Token');
        return $this->sendResponse([
            'token' => [
                'access_token' => $tokenResult->plainTextToken,
                'token_type' => 'Bearer',
            ],
            'user' => new UserResource($user),
        ], __('auth.login_success'));
    }
}