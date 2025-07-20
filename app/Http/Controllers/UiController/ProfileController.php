<?php

namespace App\Http\Controllers\UiController;

use App\Http\Controllers\Controller;
use App\Services\CallApiService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    private $call_api;

    public function __construct(CallApiService $call_api)
    {
        $this->call_api = $call_api;
    }

    public function listUsers()
    {
        $response = $this->call_api->callApi('GET', '/api/users?p=1');

        if (isset($response['error'])) {
            return redirect()->back()->withErrors(['error' => $response['error']]);
        }

        return view('users.index', ['users' => $response['data']]);
    }


    public function createUser()
    {
        $resource = $this->call_api->callApi('GET', '/api/roles?p=1');

        if (isset($resource['error'])) {
            return redirect()->back()->withErrors(['error' => $resource['error']]);
        }

        return view('users.create', ['roles' => $resource['data']]);
    }

    public function storeUser(Request $request)
    {
        $data = $request->only(['name', 'email', 'role', 'is_active', 'password', 'password_confirmation']);

        $resource = $this->call_api->callApi('POST', '/api/users', $data);

        if (isset($resource['error'])) {
            return redirect()->back()->withErrors(['error' => $resource['error']]);
        }

        return redirect()->route('users.list')->with('success', 'User created successfully.');
    }


    public function editUser($id)
    {
        $response = $this->call_api->callApi('GET', "/api/users/{$id}");

        if (isset($response['error'])) {
            return redirect()->back()->withErrors(['error' => $response['error']]);
        }

        $role_response = $this->call_api->callApi('GET', '/api/roles?p=1');

        if (isset($role_response['error'])) {
            return redirect()->back()->withErrors(['error' => $role_response['error']]);
        }

        return view('users.edit', ['user' => $response['data'], 'roles' => $role_response['data']]);
    }


    public function updateUser(Request $request, $id)
    {
        $data = $request->only(['name', 'email', 'role', 'is_active', 'password', 'password_confirmation']);

        if (empty($data['password'])) {
            unset($data['password'], $data['password_confirmation']);
        }

        $response = $this->call_api->callApi('PUT', "/api/users/{$id}", $data);

        if (isset($response['error'])) {
            return redirect()->back()->withErrors(['error' => $response['error']]);
        }

        return redirect()->route('users.list')->with('success', 'User updated successfully.');
    }


    public function destroyUser($id)
    {
        $response = $this->call_api->callApi('DELETE', "/api/users/{$id}");

        if (isset($response['error'])) {
            return redirect()->back()->withErrors(['error' => $response['error']]);
        }

        return redirect()->route('users.list')->with('success', 'User deleted successfully.');
    }

}
