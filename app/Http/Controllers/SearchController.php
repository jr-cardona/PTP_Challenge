<?php

namespace App\Http\Controllers;

use App\Client;
use App\Product;
use App\Seller;
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
        return Client::select('id', DB::raw('concat(name, " ", surname) as fullname'))
            ->where(DB::raw('concat(name, " ", surname)'), 'like', '%'. $request->name .'%')
            ->orderBy('name')
            ->limit('100')
            ->get();
    }

    /**
     * Display the specified resource filtering by name.
     * @param Request $request
     * @return
     */
    public function sellers(Request $request)
    {
        return Seller::select('id', DB::raw('concat(name, " ", surname) as fullname'))
            ->where(DB::raw('concat(name, " ", surname)'), 'like', '%'. $request->name .'%')
            ->orderBy('name')
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
