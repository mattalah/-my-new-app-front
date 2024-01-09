<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateNewsParamRequest;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Http\Resources\UserResource;
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
    public function updateProfile(updateProfileRequest $request)
    {
        $input = $request->validated();
        if (!User::where('id', $input['id'])->exist()) {
            return  response()->json('User not found', 404);
        }
        $user = User::where('id', $input['id'])->first();
        $user->update([
            'name' => $input['name'],
        ]);
        $user->save();
        return  response()->json(new UserResource($user));
    }

    public function show(User $user)
    {
        return  response()->json(new UserResource($user));
    }


    /**
     * Update the specified resource in storage.
     */
    public function updateNewsParam(UpdateNewsParamRequest $request)
    {
        dd($request);
        return null;
    }
}
