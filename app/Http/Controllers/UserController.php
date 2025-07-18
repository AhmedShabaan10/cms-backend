<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        if ($unauthorized = $this->authorize('users-list')) {
            return $unauthorized;
        }

        $users = User::with('roles')->where('is_super_admin', false)
            ->where('id', '!=', auth()->user()->id)
            ->paginate(30);

        return UserResource::collection($users);
    }


    public function show($id)
    {
        if ($unauthorized = $this->authorize('users-view')) {
            return $unauthorized;
        }
        try {
            $user = User::with('roles')->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'User not found.'
            ], 404);
        }
        
        return new UserResource($user);
    }


    public function store(CreateUserRequest $request)
    {
        if ($unauthorized = $this->authorize('users-create')) {
            return $unauthorized;
        }

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);

        DB::transaction(function () use ($data, &$user) {
            $user = User::create($data);
            $user->roles()->sync($data['role']);
        });

        return response()->json([
            'message' => 'User Created successfully.',
            'user' => new UserResource($user)
        ]);
    }


    public function update(UpdateUserRequest $request, $id)
    {
        if ($unauthorized = $this->authorize('users-update')) {
            return $unauthorized;
        }
        $data = $request->all();

        try {
            $user = User::findOrFail($id);
            $user->update($data);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'User not found.'
            ], 404);
        }
        return response()->json([
            'message' => 'User updated successfully.',
            'user' => new UserResource($user)
        ]);
    }

    public function destroy($id)
    {
        if ($unauthorized = $this->authorize('users-delete')) {
            return $unauthorized;
        }

        try {
            $user = User::findOrFail($id);
            $user->delete();
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'User not found.'
            ], 404);
        }

        return response()->json([
            'message' => 'User deleted successfully.',
        ]);
    }

}
