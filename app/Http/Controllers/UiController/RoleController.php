<?php
// app/Http/Controllers/RoleController.php

namespace App\Http\Controllers\UiController;

use App\Http\Controllers\Controller;
use App\Services\CallApiService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private $call_api;

    public function __construct(CallApiService $call_api)
    {
        $this->call_api = $call_api;
    }

    public function index()
    {
        $response = $this->call_api->callApi('GET', '/api/roles?p=1');

        if (isset($response['error'])) {
            return redirect()->back()->withErrors(['error' => $response['error']]);
        }

        return view('roles.index', ['roles' => $response['data']]);
    }

    public function create()
    {
        $permissions_response = $this->call_api->callApi('GET', '/api/permissions');
        if (isset($permissions_response['error'])) {
            return redirect()->back()->withErrors(['error' => $permissions_response['error']]);
        }

        return view('roles.create', ['permissions' => $permissions_response['data']]);
    }


    public function store(Request $request)
    {
        $data = $request->only(['name', 'display_name', 'description', 'permissions']);

        $response = $this->call_api->callApi('POST', '/api/roles', $data);

        if (isset($response['error'])) {
            return redirect()->back()->withErrors(['error' => $response['error']]);
        }

        return redirect()->route('roles.list');
    }


    public function edit($id)
    {
        $response = $this->call_api->callApi('GET', "/api/roles/{$id}");

        if (isset($response['error'])) {
            return redirect()->back()->withErrors(['error' => $response['error']]);
        }

        $permissions_response = $this->call_api->callApi('GET', '/api/permissions');
        if (isset($permissions_response['error'])) {
            return redirect()->back()->withErrors(['error' => $permissions_response['error']]);
        }

        return view('roles.edit', ['role' => $response['data'], 'permissions' => $permissions_response['data']]);
    }


    public function update(Request $request, $id)
    {
        $data = $request->only(['name', 'display_name', 'description', 'permissions']);

        $resourse = $this->call_api->callApi('PUT', "/api/roles/{$id}", $data);

        if (isset($resourse['error'])) {
            return redirect()->back()->withErrors(['error' => $resourse['error']]);
        }

        return redirect()->route('roles.list');
    }


    public function destroy($id)
    {
        $response = $this->call_api->callApi('DELETE', "/api/roles/{$id}");

        if (isset($response['error'])) {
            return redirect()->back()->withErrors(['error' => $response['error']]);
        }

        return redirect()->route('roles.list');
    }

}
