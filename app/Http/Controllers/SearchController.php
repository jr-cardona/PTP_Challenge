<?php

namespace App\Http\Controllers;

use App\User;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        return User::selectRaw('id, concat(name, " ", surname) as fullname')
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
}
