<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function authorize(string $permission )
    {
        $user = auth()->user();
        if (!($user->hasPermission($permission)) && !($user->is_super_admin)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return null;
    }
}
