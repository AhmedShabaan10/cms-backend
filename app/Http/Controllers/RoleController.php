<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\CreateRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Http\Resources\Role\RoleResource;
use App\Models\Role;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{

    public function index()
    {
        if ($unauthorized = $this->authorize('roles-list')) {
            return $unauthorized;
        }
        if (request()->boolean('p')) {
            $roles = Role::with('permissions')->get();
            return RoleResource::collection($roles);
        }

        $roles = Role::with('permissions')->paginate(30);
        return RoleResource::collection($roles);
    }

    public function store(CreateRoleRequest $request)
    {
        if ($unauthorized = $this->authorize('roles-create')) {
            return $unauthorized;
        }

        $data = $request->all();

        $role = DB::transaction(function () use ($data) {
            $role = Role::create($data);

            if (isset($data['permissions'])) {
                $role->permissions()->sync($data['permissions']);
            }

            return $role;
        });

        return new RoleResource($role);
    }

    public function show($id)
    {
        if ($unauthorized = $this->authorize('roles-view')) {
            return $unauthorized;
        }
        try {
            $role = Role::with('permissions')->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Role not found.'
            ], 404);
        }
        return new RoleResource($role);
    }

    public function update(UpdateRoleRequest $request, $id)
    {
        if ($unauthorized = $this->authorize('roles-update')) {
            return $unauthorized;
        }

        $data = $request->all();

        try {
            $role = Role::findOrFail($id);
            $role->update($data);
            if (isset($data['permissions'])) {
                $role->permissions()->sync($data['permissions']);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Role not found.'
            ], 404);
        }

        return new RoleResource($role);
    }

    public function destroy($id)
    {
        if ($unauthorized = $this->authorize('roles-delete')) {
            return $unauthorized;
        }

        try {
            $role = Role::findOrFail($id);
            if ($role->users()->count() > 0) {
                return response()->json([
                    'message' => 'Cannot delete role assigned to users.'
                ], 403);
            }
            $role->delete();
            $role->permissions()->detach();
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Role not found.'
            ], 404);
        }

        return response()->json([
            'message' => 'Role deleted successfully.'
        ]);
    }
}
