<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\report_types;
use App\Model\report_posts;
use Validator, Redirect, view;

class ReportTypeController extends Controller
{

    function index(){
    	$types = report_types::all();
    	return view('report_types.index', compact('types'));
    }

    function create(){

        return view('report_types.add');

    }

    function edit($id){

        $type = report_types::find($id);
        return view('report_types.edit', compact('type'));

    }

    function store(Request $request){

        $validator = Validator::make($request->all(), [
            'typeName' => 'required|unique:kuchingi_report_type,name'
        ]);

        if($validator->fails()){
            // var_dump($validator->messages());
            return Redirect::to('report_types/create')->withErrors($validator);
        }

        $tips = new report_types();
        $tips->name = $request->input('typeName');
        $tips->is_auto_report = $request->input('isAutoReport');

        if($tips->save())
            return redirect()->route('report_types.index')->with('success','Data Has been Saved!');
        else 
            return redirect()->route('report_types.index')->with('fail','Fail to update data!');

    }

    function update(Request $request, $id){

        $tips = report_types::find($id);

        $validator = Validator::make($request->all(), [
            'typeName' => 'required|unique:kuchingi_report_type,name,'.$id,
            'isAutoReport' => 'required'
        ]);

        if($validator->fails()){
            // var_dump($validator->messages());
            return Redirect::to('report_types/edit')->withErrors($validator);
        }

        $tips->name = $request->input('typeName');
        $tips->is_auto_report = $request->input('isAutoReport');

        if($tips->update())
            return redirect()->route('report_types.index')->with('success','Data Has been Updated!');
        else 
            return redirect()->route('report_types.index')->with('fail','Fail to update Updated!');

    }

    function destroy($id){

        $valid = report_posts::where('type_ID', $id)->get();

        if(count($valid) != 0)
            return redirect()->route('report_types.index')->with('fail','This cateogry contain child. Please remove it first before delete.');

        $tips = report_types::find($id);

        if($tips->delete())
            return redirect()->route('report_types.index')->with('success','Data Has been Deleted!');
        else 
            return redirect()->route('report_types.index')->with('fail','Fail to delete data!');

    }

}
