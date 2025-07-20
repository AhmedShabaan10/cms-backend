<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Permission;
use App\Models\Status;

class GeneralController extends Controller
{
    public function get_orders_status()
    {
        $status = Status::get(['id', 'name'])->sortBy('id');

        return response()->json(['data' => $status]);
    }

    public function get_products_categories()
    {
        $categories = Category::get(['id', 'name'])->sortBy('id');
        return response()->json(['data' => $categories]);
    }

    public function get_permissions()
    {
        $permissions = Permission::get(['id','name'])->groupBy(function ($permission) {
            return explode('-', $permission->name)[0];
        });
        
        return response()->json(['data' => $permissions]);
    }
}
