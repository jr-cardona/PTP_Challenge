<?php

namespace App\Http\Controllers;

use App\Client;
use App\Seller;
use App\Product;
use Illuminate\Http\Request;

class AutocompleteController extends Controller
{
    public function client(Request $request){
        if($request->get('query'))
        {
            $query = $request->get('query');
            $clients = Client::select(['id','name'])->where('name','like',"%{$query}%")->get();
            $output = '<ul class="list-group">';
            foreach($clients as $client)
            {
                $output .= '<li id="'.$client->id.'" class="list-group-item client"><a href="#">'.$client->name.'</a></li>';
            }
            $output .= '</ul>';
            echo $output;
        }
    }

    public function seller(Request $request){
        if($request->get('query'))
        {
            $query = $request->get('query');
            $sellers = Seller::select(['id','name'])->where('name','like',"%{$query}%")->get();
            $output = '<ul class="list-group">';
            foreach($sellers as $seller)
            {
                $output .= '<li id="'.$seller->id.'" class="list-group-item seller"><a href="#">'.$seller->name.'</a></li>';
            }
            $output .= '</ul>';
            echo $output;
        }
    }

    public function product(Request $request){
        if($request->get('query'))
        {
            $query = $request->get('query');
            $products = Product::select(['id','name'])->where('name','like',"%{$query}%")->get();
            $output = '<ul class="list-group">';
            foreach($products as $product)
            {
                $output .= '<li id="'.$product->id.'" class="list-group-item product"><a href="#">'.$product->name.'</a></li>';
            }
            $output .= '</ul>';
            echo $output;
        }
    }
}
