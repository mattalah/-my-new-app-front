<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\{UpdateProfileRequest, UpdateNewsParamRequest, ShowNewsParamRequest, ShowProfile};
use App\Http\Resources\{UserResource, UserParamResource};
use App\Models\User;

/**
 * Class UserController.
 *
 * @author  Mattalah saifeddinne<mattalahsaifeddinne@gmail.com>
 */

class UserController extends AppBaseController
{


    /**
     * @OA\Put(
     *     path="/user/{id}",
     *     tags={"user"},
     *     summary="Updated user",
     *     description="This can pnly be done by the logged in user.",
     *     operationId="updateUser",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="name that to be updated",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid user supplied"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     ),
     *     @OA\RequestBody(
     *         description="Updated user object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserResource")
     *     )
     * )
     */
    public function updateProfile(updateProfileRequest $request, User $user)
    {
        $user->update($request->only(['name']));
        $user->save();
        return $this->sendResponse(new UserResource($user), __('user.profile.updated_profile'));
    }

    public function showProfile(ShowProfile $request, User $user)
    {
        return $this->sendResponse(new UserResource($user), __('user.profile.show_profile'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function updateNewsParam(UpdateNewsParamRequest $request, User $user)
    {
        $user->update($request->only(['source','category','publishedAt']));
        $user->save();
        return $this->sendResponse(new UserParamResource($user), __('user.news_param.update'));
    }
    /**
     * get the specified resource in storage.
     */
    public function showNewsParam(ShowNewsParamRequest $request, User $user)
    {
        return $this->sendResponse(new UserParamResource($user), __('user.news_param.show'));
    }
}
