<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use view;

class AutoReportController extends Controller
{
    function sendMail(){
    	
    	return view('email.send')->with(['title' => 'sample', 'content' => 'content']);
    }
}
