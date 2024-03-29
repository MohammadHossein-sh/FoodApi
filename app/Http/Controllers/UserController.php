<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @Route("/users/list?paginate=10", name="api_users_list", methods={"GET"})
     */

    public function index(Request $request)
    {
        $paginate =  $request->input('paginate', 0);
        if ($paginate !== 0) {
            $users = User::paginate($paginate);
            $links = UserResource::collection($users)->response()->getData()->links;
            $meta = UserResource::collection($users)->response()->getData()->meta;

            return  $this->successPagintaeResponse("users", UserResource::collection($users), $links, $meta, $paginate, 200, "List of users " . $paginate . " to " . $paginate . ":");
        } else {
            $users = User::all();
            return $this->successResponse(UserResource::collection($users), 200, "List all of users:");
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->successResponse(new UserResource($user), 200, "the show of user : " . $user->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        DB::beginTransaction();
        $user->delete();
        DB::commit();
        return $this->successResponse(new UserResource($user), 200, "delete of id: " . $user->id);
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'cellphone' => 'regex:/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/',
            'profile' => 'image'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->messages(), 422);
        }
        if ($request->hasFile('profile')) {
            $fileName =  "users/profile/" .  time() .  "." . $request->profile->extension();
            $request->profile->move(public_path('users/profile'), $fileName);
            DB::beginTransaction();
            $user->update([
                'cellphone' => $request->cellphone,
                'profile' => $fileName
            ]);
            DB::commit();
        } else {
            DB::beginTransaction();
            $user->update([
                'cellphone' => $request->cellphone,
                'profile' => $user->profile
            ]);
            DB::commit();
        }
        return $this->successResponse(new UserResource($user), 200, "update of id: " . $user->id);
    }


    public function deletes()
    {
        $users = User::onlyTrashed()->get();

        return  $this->successResponse(UserResource::collection($users), 200, "list of deletes user: ");
    }
    public function  restore(User $user)
    {
        DB::beginTransaction();
        $user->restore();
        DB::commit();
        return  $this->successResponse(new UserResource($user), 200, "change off delete successfully");
    }
    public function change(User $user)
    {
        DB::beginTransaction();
        if ($user->permission == 'admin') {
            $user->update([
                'permission' => 'user'
            ]);
        } else {
            $user->update([
                'permission' => 'admin'
            ]);
        }
        DB::commit();
        return  $this->successResponse(new UserResource($user), 200, "changed permissions");
    }
}
