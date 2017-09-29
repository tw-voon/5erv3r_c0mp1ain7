<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\tip_categories;
use App\Model\safety_tips;
use Validator, Redirect;

class SafetyTipsController extends Controller
{

    function index(){

    	$tips = tip_categories::paginate(10);
    	return view('safety_tip.index', compact('tips'));

    }

    function create(){

    	return view('safety_tip.add');
    }

    function edit($id){

    	$category = tip_categories::find($id);
    	return view('safety_tip.edit', compact('category'));

    }

    function update(Request $request, $id){

    	$tips = tip_categories::find($id);

    	$validator = Validator::make($request->all(), [
            'category_name' => 'required|unique:kuchingi_tips_category,name,'.$id
        ]);

        if($validator->fails()){
            // var_dump($validator->messages());
            return Redirect::back()->withErrors($validator);
        }

        $tips->name = $request->input('category_name');

        if($tips->update())
        	return redirect()->route('safety_tip.index')->with('success','Data Has been Updated!');
    	else 
    		return redirect()->route('safety_tip.index')->with('fail','Fail to update Updated!');
    }

    function store(Request $request){

    	$validator = Validator::make($request->all(), [
            'category_name' => 'required|unique:kuchingi_tips_category,name'
        ]);

        if($validator->fails()){
            // var_dump($validator->messages());
            return Redirect::to('safety_tip/create')->withErrors($validator);
        }

        $tips = new tip_categories();
        $tips->name = $request->input('category_name');
        $tips->status = 1;

        if($tips->save())
        	return redirect()->route('safety_tip.index')->with('success','Data Has been Saved!');
    	else 
    		return redirect()->route('safety_tip.index')->with('fail','Fail to update data!');
    }

    function destroy($id){

    	$tips = tip_categories::find($id);
    	$valid = safety_tips::where('category_id', $id)->get();

    	if(count($valid) != 0)
    		return redirect()->route('safety_tip.index')->with('fail','This cateogry contain child. Please remove it first before delete.');

        if($tips->delete())
        	return redirect()->route('safety_tip.index')->with('success','Data Has been Deleted!');
    	else 
    		return redirect()->route('safety_tip.index')->with('fail','Fail to delete data!');
    }

}
