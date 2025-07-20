<?php

namespace App\Http\Controllers\UiController;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Role;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    // public function edit(Request $request): View
    // {
    //     return view('profile.edit', [
    //         'user' => $request->user(),
    //     ]);
    // }

    // /**
    //  * Update the user's profile information.
    //  */
    // public function update(Request $request): RedirectResponse
    // {
    //     $request->user()->fill($request->validated());

    //     // if ($request->user()->isDirty('email')) {
    //     //     $request->user()->email_verified_at = null;
    //     // }

    //     $request->user()->save();

    //     return Redirect::route('profile.edit')->with('status', 'profile-updated');
    // }

    /**
     * Delete the user's account.
     */

    public function listUsers(Request $request)
    {
        $token = session('api_token');
        $users = [];

        if ($token) {
            $apiRequest = Request::create('/api/users', 'GET', [], [], [], [
                'HTTP_Authorization' => 'Bearer ' . $token,
                'HTTP_ACCEPT' => 'application/json'
            ]);

            $response = app()->handle($apiRequest);

            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getContent(), true);
                $users = $data['data'] ?? $data;
            }
            if ($response->getStatusCode() !== 200) {
                $responseData = json_decode($response->getContent(), true);
                $errorMessage = $responseData['message'] ?? 'Failed to get users.';
                return redirect()->back()->withErrors(['error' => $errorMessage]);
            }
        }

        return view('users.index', compact('users'));
    }


    public function createUser()
    {
        $rolesRequest = Request::create('/api/roles', 'GET', [], [], [], [
            'HTTP_Authorization' => 'Bearer ' . session('api_token'),
            'HTTP_ACCEPT' => 'application/json'
        ]);

        $rolesResponse = app()->handle($rolesRequest);

        if ($rolesResponse->getStatusCode() === 200) {
            $rolesData = json_decode($rolesResponse->getContent(), true);
            $roles = $rolesData['data'] ?? $rolesData;
        }

        if ($rolesResponse->getStatusCode() !== 200) {
            $responseData = json_decode($rolesResponse->getContent(), true);
            $errorMessage = $responseData['message'] ?? 'Failed to create user.';
            return redirect()->back()->withErrors(['error' => $errorMessage]);
        }
        return view('users.create', compact('roles'));
    }

    public function storeUser(Request $request)
    {
        $data = $request->only(['name', 'email', 'role', 'is_active', 'password', 'password_confirmation']);
        $apiRequest = Request::create(
            "/api/users",
            'POST',
            $data,
            [],
            [],
            [
                'HTTP_Authorization' => 'Bearer ' . session('api_token'),
                'HTTP_ACCEPT' => 'application/json'
            ]
        );

        $response = app()->handle($apiRequest);

        if ($response->getStatusCode() !== 201 && $response->getStatusCode() !== 200) {
            $responseData = json_decode($response->getContent(), true);
            $errorMessage = $responseData['message'] ?? 'Failed to create user.';
            return redirect()->back()->withErrors(['error' => $errorMessage]);
        }

        return redirect()->route('users.list')->with('success', 'User created successfully.');
    }

    public function editUser($id)
    {
        if (session('api_token')) {
            $apiRequest = Request::create("/api/users/{$id}", 'GET', [], [], [], [
                'HTTP_Authorization' => 'Bearer ' . session('api_token'),
                'HTTP_ACCEPT' => 'application/json'
                ,
            ]);

            $response = app()->handle($apiRequest);

            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getContent(), true);
                $user = $data['data'] ?? $data;
            }

            if ($response->getStatusCode() !== 200) {
                $responseData = json_decode($response->getContent(), true);
                $errorMessage = $responseData['message'] ?? 'Failed to update user.';
                return redirect()->back()->withErrors(['error' => $errorMessage]);
            }
            $roles = Role::all();
        }

        return view('users.edit', compact('user', 'roles'));
    }

    public function updateUser(Request $request, $id)
    {
        $data = $request->only(['name', 'email', 'role', 'is_active', 'password', 'password_confirmation']);

        if (empty($data['password'])) {
            unset($data['password'], $data['password_confirmation']);
        }
        $apiRequest = Request::create(
            "/api/users/{$id}",
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
            $errorMessage = $responseData['message'] ?? 'Failed to update user.';
            return redirect()->back()->withErrors(['error' => $errorMessage]);
        }


        return redirect()->route('users.list')->with('success', 'User updated successfully.');
    }


    public function destroyUser($id)
    {
        $apiRequest = Request::create(
            "/api/users/{$id}",
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
            return redirect()->back()->withErrors(['error' => 'Failed to delete user.']);
        }

        if ($response->getStatusCode() !== 200 && $response->getStatusCode() !== 204) {
            $responseData = json_decode($response->getContent(), true);
            $errorMessage = $responseData['message'] ?? 'Failed to get users.';
            return redirect()->back()->withErrors(['error' => $errorMessage]);
        }

        return redirect()->route('users.list')->with('success', 'User deleted successfully.');
    }


    // public function showResetPasswordForm()
    // {
    //     return view('users.reset-password');
    // }

    // public function showProfile()
    // {
    //     $user = Auth::user();
    //     return view('profile.showProfile', compact('user'));
    // }
}
