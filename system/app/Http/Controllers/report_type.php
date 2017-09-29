<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\report_types;

class report_type extends Controller
{
    function getReportType()
    {
    	return response()->json(report_types::all());
    }
}
