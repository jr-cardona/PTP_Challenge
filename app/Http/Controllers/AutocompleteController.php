<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AutocompleteController extends Controller
{
    public function search(Request $request){
        if($request->get('query')) {
            $query = $request->get('query');
            $table = $request->get('table');
            $values = DB::table($table)
                ->where('name','like',"%{$query}%")
                ->limit('10')
                ->orderBy('name')
                ->get();
            ;
            $output = '<ul class="list-group">';
            foreach($values as $value) {
                $output .= '<li id="'.$value->id.'" class="list-group-item '.$table.'"><a href="#">'.$value->name.'</a></li>';
            }
            $output .= '</ul>';
            echo $output;
        }
    }
}
