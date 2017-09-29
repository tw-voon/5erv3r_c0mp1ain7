<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;


class safety_tip extends Controller
{
    function getAllCategory(){

    	$category = DB::table('tips_category')->get();
    	return response()->json($category);

    }

    function getDetailsTips(Request $request){

    	$category_id = $request->input('category_id');

    	$tips = DB::table('safetytips')
    			->where('category_id', '=', $category_id)
                ->where('status', 1)
    			->get();

    			return response()->json($tips);

    }	
}
