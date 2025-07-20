<?php
// app/Http/Controllers/RoleController.php

namespace App\Http\Controllers\UiController;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $rolesRequest = Request::create('/api/roles', 'GET', [], [], [], [
            'HTTP_Authorization' => 'Bearer ' . session('api_token'),
            'HTTP_ACCEPT' => 'application/json'
        ]);
        $response = app()->handle($rolesRequest);

        if ($response->getStatusCode() === 200) {
            $rolesData = json_decode($response->getContent(), true);
            $roles = $rolesData['data'] ?? $rolesData;
        }

        if ($response->getStatusCode() !== 200) {
            $responseData = json_decode($response->getContent(), true);
            $errorMessage = $responseData['message'] ?? 'Failed to get roles.';
            return redirect()->back()->withErrors(['error' => $errorMessage]);
        }

        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('-', $permission->name)[0];
        });
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $data = $request->only(['name', 'display_name', 'description', 'permissions']);
        if (session('api_token')) {
            $apiRequest = Request::create(
                "/api/roles",
                'POST',
                $data,
                [],
                [],
                [
                    'HTTP_Authorization' => 'Bearer ' . session('api_token'),
                    'HTTP_ACCEPT' => 'application/json',
                ]
            );
            $response = app()->handle($apiRequest);

            if ($response->getStatusCode() !== 201) {
                $responseData = json_decode($response->getContent(), true);
                $errorMessage = $responseData['message'] ?? 'Failed to create role.';
                return redirect()->back()->withErrors(['error' => $errorMessage]);
            }
        }

        return redirect()->route('roles.list');
    }

    public function edit($id)
    {
        if (session('api_token')) {
            $apiRequest = Request::create("/api/roles/{$id}", 'GET', [], [], [], [
                'HTTP_Authorization' => 'Bearer ' . session('api_token'),
                'HTTP_ACCEPT' => 'application/json'
                ,
            ]);

            $response = app()->handle($apiRequest);

            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getContent(), true);
                $role = $data['data'] ?? $data;
            }

            if ($response->getStatusCode() !== 200) {
                $responseData = json_decode($response->getContent(), true);
                $errorMessage = $responseData['message'] ?? 'Failed to get role.';
                return redirect()->back()->withErrors(['error' => $errorMessage]);
            }
            $permissions = Permission::all()->groupBy(function ($permission) {
                return explode('-', $permission->name)[0];
            });


        }
        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->only(['name', 'display_name', 'description', 'permissions']);

        $apiRequest = Request::create(
            "/api/roles/{$id}",
            'PUT',
            $data,
            [],
            [],
            [
                'HTTP_Authorization' => 'Bearer ' . session('api_token'),
                'HTTP_ACCEPT' => 'application/json'
            ]
        );

        $response = app()->handle($apiRequest);

        if ($response->getStatusCode() !== 200) {
            $responseData = json_decode($response->getContent(), true);
            $errorMessage = $responseData['message'] ?? 'Failed to update role.';
            return redirect()->back()->withErrors(['error' => $errorMessage]);
        }


        return redirect()->route('roles.list');

    }


    public function destroy($id)
    {
        $apiRequest = Request::create(
            "/api/roles/{$id}",
            'DELETE',
            [],
            [],
            [],
            [
                'HTTP_Authorization' => 'Bearer ' . session('api_token'),
                'HTTP_ACCEPT' => 'application/json'
            ]
        );

        $response = app()->handle($apiRequest);

        if ($response->getStatusCode() !== 200) {
            $responseData = json_decode($response->getContent(), true);
            $errorMessage = $responseData['message'] ?? 'Failed to delete role.';
            return redirect()->back()->withErrors(['error' => $errorMessage]);
        }
        return redirect()->route('roles.list');

    }
}
