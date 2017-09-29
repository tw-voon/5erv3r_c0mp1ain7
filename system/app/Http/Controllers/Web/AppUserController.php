<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\mobile_user;
use App\User;

class AppUserController extends Controller
{

    function index(){

    	$users = mobile_user::with('role')->paginate(10);
    	return view('apps_user.index', compact('users'));

    }

    function show($id){

    	$user = mobile_user::find($id);
    	return view('apps_user.show', compact('user'));

    }

    function create(){

    }

    function edit(){

    }

    function store(){

    }

    function update(){

    }

    function destroy($id){

    	$user = mobile_user::find($id);

    	if($user->delete())
    		 return redirect()->route('apps_user.index')->with('success','Data Has been Deleted!');
        else 
            return redirect()->route('apps_user.index')->with('fail','Fail to delete data!');

    }

}
