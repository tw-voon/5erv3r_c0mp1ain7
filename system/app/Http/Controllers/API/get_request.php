<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Model\hotline;
use App\Model\tip_categories;
use App\Model\detail_tip;
use App\Http\Controllers\Controller;

class get_request extends Controller
{
    function get_hotline(){

    	return response()->json(hotline::where('status', 1)->get());

    }

    function get_info_category(){

    	return response()->json(tip_categories::where('status', 1)->get());

    }

    function get_details(Request $request){

    	return response()->json(detail_tip::where('category_id', $request->input('category_id'))->where('status', 1)->get());
    }

}
