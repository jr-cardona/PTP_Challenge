<?php

namespace App\Http\Controllers;

use App\User;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SearchController extends Controller
{
    /**
     * Display the specified resource filtering by name.
     * @param Request $request
     * @return
     */
    public function clients(Request $request)
    {
        return DB::table('users as u')
            ->selectRaw('c.id, concat(u.name, " ", u.surname) as fullname')
            ->join('clients as c', 'c.user_id', '=', 'u.id')
            ->whereRaw('concat(u.name, " ", u.surname) like "%' . $request->name . '%"')
            ->orderBy('fullname')
            ->limit('100')
            ->get();
    }

    /**
     * Display the specified resource filtering by name.
     * @param Request $request
     * @return
     */
    public function creators(Request $request)
    {
        return DB::table('users as u')
            ->selectRaw('u.id, concat(u.name, " ", u.surname) as fullname')
            ->leftJoin('clients as c', 'c.user_id', '=', 'u.id')
            ->whereNull('c.id')
            ->whereRaw('concat(name, " ", surname) like "%' . $request->name . '%"')
            ->orderBy('fullname')
            ->limit('100')
            ->get();
    }

    /**
     * Display the specified resource filtering by name.
     * @param Request $request
     * @return
     */
    public function products(Request $request)
    {
        return Product::where('name', 'like', '%'. $request->name .'%')
            ->orderBy('name')
            ->limit('100')
            ->get();
    }

    /**
     * Display the specified resource filtering by rol.
     * @param Request $request
     * @return
     */
    public function permissions(Request $request)
    {
        $permissions = DB::table('role_has_permissions as rp')
            ->select('rp.permission_id as id')
            ->where('role_id', $request->role_id)
            ->get();

        return response()->json([
            'permissions' => $permissions,
        ]);
    }
}
