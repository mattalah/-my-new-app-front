<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\{IndexUserRequest, StoreUserRequest, UpdateUserRequest};
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
     * @OA\Get(
     *     path="/user/{id}",
     *     tags={"user"},
     *     summary="Get user by user name",
     *     operationId="getUserByName",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/UserResource"),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid id supplied"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     ),
     * )
     */
    public function indexByStatus(IndexUserRequest $request)
    {
        $input = $request->validated();
        return response()->json(UserResource::collection(User::where('status', $input['status'])->get()));
    }

    /**
     * @OA\Post(
     *     path="/user",
     *     tags={"user"},
     *     summary="Create user",
     *     description="This can only be done by the logged in user.",
     *     operationId="createUser",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     ),
     *     @OA\RequestBody(
     *         description="Create user object",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserResource")
     *     )
     * )
     */
    public function store(StoreUserRequest $request)
    {
        $input = $request->validated();
        $user = User::create([
            'name' => $input['name'],
            'status' => $input['status'],
            'photoUrls' => json_encode($input['photoUrls']),
        ]);
        $user->save();
        return response()->json(new UserResource($user));
    }

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
    public function update(UpdateUserRequest $request)
    {
        $input = $request->validated();
        if (!User::where('id', $input['id'])->exist()) {
            return  response()->json('User not found', 404);
        }
        $user = User::where('id', $input['id'])->first();
        $user->update([
            'name' => $input['name'],
            'status' => $input['status'],
            'photoUrls' => json_encode($input['photoUrls']),
        ]);
        $user->save();
        return  response()->json(new UserResource($user));
    }

    /**
     * @OA\Delete(
     *     path="/user/{id}",
     *     summary="Delete user",
     *     tags={"user"},
     *     description="This can only be done by the logged in user.",
     *     operationId="deleteUser",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The name that needs to be deleted",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid id supplied",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *     )
     * )
     */
    public function destroy(int $userId)
    {
        if (User::where('id', $userId)->doesntExist()) {
            return  response()->json('User not found', 404);
        }
        User::where('id', $userId)->delete();
        return response()->json('deleted done');
    }
}
