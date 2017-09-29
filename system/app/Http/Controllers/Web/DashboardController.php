<?php
namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Model\report_posts;
use App\Model\report_status;
use App\Model\mobile_user;
use App\Model\approve_handler;
use App\Model\report_types;
use App\Model\report_handler;
use App\User;
use App\Http\Controllers\Helper\helper;
use App\Http\Controllers\Web\EmailController;
use Mapper;
use Lava;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller{

	private $helper;

	public function __construct()
    {
        $this->helper = new helper();
    }

	function index(){

		$locations = report_posts::with('location')->get();

		$charts = $this->create_data_table();

		if(session()->has('latitude')){
			Mapper::map(session('latitude'), session('longitude'), 
				['zoom' => 15, 'fullscreenControl' => false, 'center' => true, 'marker' => false, 
				'cluster' => true, 'clusters' => ['center' => false, 'zoom' => 15, 'size'=> 4], 
				'language' => 'en', 'locate' => true]);
		} else {
			// Mapper::map(1.464945, 110.426859, ['zoom' => 15, 'fullscreenControl' => false, 'center' => true, 'marker' => false, 'cluster' => true, 'clusters' => ['center' => false, 'zoom' => 15, 'size'=> 4], 'language' => 'en', 'eventBeforeLoad' => 'addMapEventListener(map);']);
			Mapper::map(0, 0, ['zoom' => 15, 'fullscreenControl' => false, 'center' => true, 'marker' => false, 'cluster' => true, 'clusters' => ['center' => false, 'zoom' => 15, 'size'=> 4], 'language' => 'en', 'locate' => true, 
				'markers.animation' => 'DROP']);
		}

		$lat = session()->get('latitude');
		
		foreach ($locations as $value) {
				Mapper::informationWindow(
			    $value->location->lat, 
			    $value->location->lon, 
			    '<div class="infowin"><h3>'.$value->title.'</h3><p>'.$value->description.'</p></div>',
			    [
			        'title' => $value->location->name,
			        'animation' => 'NONE'
			    ]
			);
		}

		$unapprove = report_posts::where('status_id', 2)->count();
		$users = User::where('role_id', '!=', 1)->count();
		$types = report_types::all();
		$isAutoReport = report_types::all();

		$item = report_posts::groupBy('type_id')
						->orderBy('count', 'description')
				    	->get(['type_id', DB::raw('count(type_id) as count')]);

		if(count($item) > 0)
			$trend = report_types::find($item[0]->type_id);
		else 
			$trend = 0;

		// return compact('lat');
		// echo $lat;
		return view('dashboard.index', compact('unapprove', 'users', 'trend', 'types', 'isAutoReport', 'charts'));
		// return compact('unapprove', 'users', 'trend', 'types', 'isAutoReport', 'lat');
	}

	public function dummy(){

		// $locations = report_posts::with('location')->get();

		$charts = $this->create_data_table();

		if(session()->has('latitude')){
			Mapper::map(session('latitude'), session('longitude'), 
				['zoom' => 15, 'fullscreenControl' => false, 'center' => true, 'marker' => false, 
				'cluster' => true, 'clusters' => ['center' => false, 'zoom' => 15, 'size'=> 4], 
				'language' => 'en', 'locate' => true]);
		} else {
			// Mapper::map(1.464945, 110.426859, ['zoom' => 15, 'fullscreenControl' => false, 'center' => true, 'marker' => false, 'cluster' => true, 'clusters' => ['center' => false, 'zoom' => 15, 'size'=> 4], 'language' => 'en', 'eventBeforeLoad' => 'addMapEventListener(map);']);
			Mapper::map(2.7037456, 113.0017507, ['zoom' => 7, 'fullscreenControl' => false, 'center' => true, 'marker' => false, 'cluster' => true, 'clusters' => ['center' => false, 'zoom' => 5, 'size'=> 4], 'language' => 'en',
				'markers.animation' => 'DROP']);
		}

		$lat = session()->get('latitude');

		/* 2.7037456,113.0017507
			KIA - 1.4868481,110.3395795
		   Tebedu - 0.9892652,110.3518681
		   Tedungan - 4.7379461,114.8089351
		   Sungai Tujuh - 4.5845848,114.0720212
		   Miri Airport - 4.3241015,113.9831286
		   Sibu Airport - 2.2537463,111.9841501
		   Bintulu Airport - 3.1238156,113.0218306
		*/

		$locations[0] = array("lat" => 1.4868481, "lon" => 110.3395795, "title" => "Kuching International Airport", 
								"visitor" => 120, "surveyed" => 80);
		$locations[1] = array("lat" => 0.9892652, "lon" => 110.3518681, "title" => "Tebedu", 
								"visitor" => 120, "surveyed" => 80);
		$locations[2] = array("lat" => 4.7379461, "lon" => 114.8089351, "title" => "Tedungan", 
								"visitor" => 120, "surveyed" => 80);
		$locations[3] = array("lat" => 4.5845848, "lon" => 114.0720212, "title" => "Sungai Tujuh", 
								"visitor" => 120, "surveyed" => 80);
		$locations[4] = array("lat" => 4.3241015, "lon" => 113.9831286, "title" => "Miri Airport", 
								"visitor" => 120, "surveyed" => 80);
		$locations[5] = array("lat" => 2.2537463, "lon" => 111.9841501, "title" => "Sibu Airport", 
								"visitor" => 120, "surveyed" => 80);
		$locations[6] = array("lat" => 3.1238156, "lon" => 113.0218306, "title" => "Bintulu Airport", 
								"visitor" => 120, "surveyed" => 80);

		// return print_r($locations);

		foreach ($locations as $key => $value) {
				Mapper::informationWindow(
			    $value['lat'], 
			    $value['lon'], 
			    '<div class="infowin"><h5>Check Point: '.$value['title'].'</h5><h6>Total Visitor: '.$value['visitor'].'</h6><h6>Total Surveyed: '.$value['surveyed'].'</h6></div>',
			    [
			        'title' => $value['title'],
			        'animation' => 'NONE'
			    ]
			);
		}
		
		
		// foreach ($locations as $value) {
		// 		Mapper::informationWindow(
		// 	    $value->location->lat, 
		// 	    $value->location->lon, 
		// 	    '<div class="infowin"><h3>'.$value->title.'</h3><p>'.$value->description.'</p></div>',
		// 	    [
		// 	        'title' => $value->location->name,
		// 	        'animation' => 'NONE'
		// 	    ]
		// 	);
		// }

		$unapprove = report_posts::where('status_id', 2)->count();
		$users = User::where('role_id', '!=', 1)->count();
		$types = report_types::all();
		$isAutoReport = report_types::all();

		$item = report_posts::groupBy('type_id')
						->orderBy('count', 'description')
				    	->get(['type_id', DB::raw('count(type_id) as count')]);

		if(count($item) > 0)
			$trend = report_types::find($item[0]->type_id);
		else 
			$trend = 0;

		return view('dashboard.index', compact('unapprove', 'users', 'trend', 'types', 'isAutoReport', 'charts'));

	}

	public function create_data_table(){

		$chart = new \Lava();
		$table = $chart::DataTable();
		$table->addStringColumn('Month')->addNumberColumn('Total Complaint');

		$visitorTraffic = DB::table('kuchingi_report')
                ->select(DB::raw("CONCAT_WS('-',MONTH(created_at),YEAR(created_at)) as monthyear"), DB::raw('count(id) as total'))
                ->groupBy('monthyear')
                ->limit(12)
                ->get();

        foreach ($visitorTraffic as $key => $value) {
        	$table->addRow(array($value->monthyear, $value->total));
        }

        $chart::ColumnChart('Total Complaint', $table, [
				    'title' => 'Total Complaint',
				    'titleTextStyle' => [
				        'color'    => '#eb6b2c',
				        'fontSize' => 14
				    ],
				    'hAxis' => ['title' => 'Month', 'ticks' => [07, 08, 09, 10, 11]],
				]);

        return $chart;

	}

	function filter(Request $request){

		$unapprove = report_posts::where('status_id', 2)->count();
		$users = User::all()->count();
		$types = report_types::all();
		$isAutoReport = report_types::all();

		// $isAutoReport = report_handler::select('report_type.typeName', 'report_type.isAutoReport', 
		// 	DB::raw('count(report_handler.type_id) as count'))
		// 	->join('report_type', 'report_type.id', 'report_handler.type_id')
		// 	->groupBy('report_type.typeName', 'report_type.isAutoReport')
		// 	->orderBy('count', 'desc')
		// 	->where('report_handler.reported', 0)
		// 	->where('report_type.isAutoReport', '!=', 0)
		// 	->distinct()
		// 	->get();

		$item = report_posts::groupBy('type_id')
						->orderBy('count', 'desc')
						->limit(1)
				    	->get(['type_id', DB::raw('count(type_id) as count')]);

		$trend = report_types::find($item[0]->type_id);

		if($request->input('filter') != 0)
			$locations = report_posts::where('type_id', $request->input('filter'))->with('location')->get();
		else 
			$locations = report_posts::with('location')->get();

		Mapper::map(1.464945, 110.426859, ['zoom' => 9, 'fullscreenControl' => false, 'center' => true, 'marker' => false, 'cluster' => true, 'clusters' => ['center' => false, 'zoom' => 9, 'size'=> 4], 'language' => 'en']);

		foreach ($locations as $value) {
				Mapper::informationWindow(
			    $value->location->lat, 
			    $value->location->lon, 
			    '<div class="infowin"><h3>'.$value->title.'</h3><p>'.$value->description.'</p></div>',
			    [
			        'title' => $value->location->name,
			        'animation' => 'NONE'
			    ]
			);
		}

		$charts = $this->create_data_table();

		return view('dashboard.index', compact('unapprove', 'users', 'trend', 'types', 'item', 'isAutoReport', 'charts'));


	}

	function report(){

		$toReport = report_handler::where('reported', 0)->with('report', 'type')->get();

		return view('email.select', compact('toReport'));
		// Mail::to('to@example.com')->send(new EmailController());
		// return redirect()->route('dashboard.index');

	}

	function send(Request $request){
		
		$report = $request->input('report');
		$ids = $request->input('id');
		$selected = array();

		foreach ($report as $key => $value) {
			
			if($value == 1)
				array_push($selected, $ids[$key]);
		}

		$select = report_handler::whereIn('report_handler.report_id', $selected)->with('report', 'report.location', 'type')->get();

		Mail::to('to@example.com')->send(new EmailController($select));
		$this->helper->mark_report($selected);
		return redirect()->route('dashboard.index');

		// var_dump($select);
	}
}