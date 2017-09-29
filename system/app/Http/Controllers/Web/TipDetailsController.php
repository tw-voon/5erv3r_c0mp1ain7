<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\detail_tip;
use App\Model\tip_categories;
use view, Validator, Redirect;

class TipDetailsController extends Controller
{
    function index($id){

    	$tips = detail_tip::where('category_id', $id)->paginate(10);
    	$name = tip_categories::find($id);
    	return view('tip_details.index', compact('tips', 'name'));

    }

    function create($id){

    	$name = tip_categories::find($id);
    	return view('tip_details.add', compact('name'));

    }

    function edit($id){

    	$name = detail_tip::find($id);
    	return view('tip_details.edit', compact('name'));

    }

    function store(Request $request, $id){

    	$validator = Validator::make($request->all(), [
            'tip_name' => 'required',
            'tip_desc' => 'required',
        ]);

        if($validator->fails()){
            // var_dump($validator->messages());
            return Redirect::to('tip_details/'.$id.'/create')->withErrors($validator);
        }

        $tips = new detail_tip();
        $tips->title = $request->input('tip_name');
        $tips->message = $request->input('tip_desc');
        $tips->category_id = $id;
        $tips->status = $request->input('status');

        if($tips->save())
        	return redirect()->route('tip_category.index', $id)->with('success','Data Has been Saved!');
    	else 
    		return redirect()->route('tip_category.index', $id)->with('fail','Fail to update data!');

    }

    function update(Request $request, $id){

    	$validator = Validator::make($request->all(), [
            'tip_name' => 'required',
            'tip_desc' => 'required',
        ]);

        if($validator->fails()){
            // var_dump($validator->messages());
            return Redirect::to('tip_details/'.$id.'/edit')->withErrors($validator);
        }

        $tips = detail_tip::find($id);
        $tips->title = $request->input('tip_name');
        $tips->message = $request->input('tip_desc');
        $tips->status = $request->input('status');

        if($tips->update())
        	return redirect()->route('tip_category.index', $tips->category_id)->with('success','Data Has been Saved!');
    	else 
    		return redirect()->route('tip_category.index', $tips->category_id)->with('fail','Fail to update data!');

    }

    function destroy($id){

    	$tips = detail_tip::find($id);
    	$category_id = $tips->category_id;

        if($tips->delete())
        	return redirect()->route('tip_category.index', $category_id)->with('success','Data Has been Deleted!');
    	else 
    		return redirect()->route('tip_category.index', $category_id)->with('fail','Fail to delete data!');

    }
}
