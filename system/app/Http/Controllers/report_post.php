<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Model\report_posts;
use App\Model\locations;
use App\Model\comments;
use App\Model\approve_handler;
use App\Model\notification;
use App\Model\mobile_user;
use App\Model\report_handler;
use App\Model\report_types;
use App\Model\report_status;
use App\Model\report_media;
use App\Model\action;
use App\Model\response;
use App\User;
use App\Http\Controllers\GCM;
use App\Http\Controllers\Push;
use App\Http\Controllers\Helper\helper;
use File;
use Carbon\Carbon;
use DB;

class report_post extends Controller
{

    private $helper;

    public function __construct()
    {
        $this->helper = new helper();
    }

    public function index(Request $request)
    {
        /*
        id is random generate string, date-number of report-PPB
        */
    	$title = $request->input('title');
    	$desc = $request->input('desc');
    	$images = $request->input('image');
    	$userID = $request->input('user_id');
    	$typeID = $request->input('category_id');
        $location_name = $request->input('location_name');
        $latitute = $request->input('latitude');
        $longitute = $request->input('longitude');

    	$myDate = date("Y-m-d");
        $myTime = date("h-i-sa");
    	$serverPath = "http://192.168.1.101/BetterPepperBoard/pepperboard.net/images";

    	$image = base64_decode($images);
		$image_name= $userID. "-" . $myDate . $myTime . '.png';
		$path = public_path() . "/images/". $userID ."/".$image_name;
		$dir = public_path() . "/images/". $userID ."/";
		

		if(!File::exists($dir)) {
    		$result = File::makeDirectory(public_path() . "/images/". $userID ."/", 0777, true);
		}

		// $result2 = file_put_contents($path, $image);
        move_uploaded_file ( $_FILES["image"]["tmp_name"] , $path );

        $location_id = $this->helper->store_location($location_name, $latitute, $longitute);
        
    	$newPost = new report_posts();
        $newPost->id = $this->helper->generate_report_id();
    	$newPost->user_id = $userID;
    	$newPost->type_id = $typeID;
        $newPost->location_id = $location_id;
        $newPost->status_id = 2;
    	$newPost->title = $title;
    	$newPost->description = $desc;
    	$status_1 = $newPost->save();

        $status_2 = $this->helper->generate_report_media($newPost->id, $serverPath."/".$userID."/".$image_name);
        $status_3 = $this->helper->generate_initial_action($newPost->id, 2);
        // $status_4 = $this->helper->keep_activity($userID, $userID, 'Report', $newPost->id);

    	if($status_1 && $status_2 && $status_3)
    		return "Success";
    	else
    		return "Fail";

    }

    function unsolved_complaint(Request $request){

        $user_id = $request->input('user_id');
        $report = report_posts::with('status', 'location', 'media', 'user', 'category', 'officer', 'action')
                                ->where('status_id', 2)->paginate(2);
        // $response = response::where('user_id', $user_id)->get();
        return compact('report');

    }


    function getReport(Request $request){

        $user_id = $request->input('user_id');
        $report = report_posts::with('status', 'location', 'media', 'user', 'category', 'officer', 'action')->get();
        $response = response::where('user_id', $user_id)->get();
        return compact('report', 'response');

    }

    function getSingleReport(Request $request){

        $report_id = $request->input('report_id');

        $report = report_posts::with('status', 'location', 'media', 'user', 'category', 'officer', 'action')->get();
        $comment = comments::where('report_id', $report_id)->get();

        return compact('report', 'response', 'comment');

    }

    function get_free_officer(Request $request){
        $report_id = $request->input('report_id');
        $assign = $this->helper->officer_assigned($report_id);
        // $on_duty_officer = report_posts::where('officer_id', '!=', NULL)->where('status_id', 2)->pluck('officer_id');
        $free_officer = User::where('role_id', 2)->get();
        if($assign != 0){
            $officer_assigned = User::find($assign);
            return compact('officer_assigned', 'free_officer');
        } else return compact('free_officer');
    }

    function assign_officer(Request $request){
        $admin_id = $request->input('admin_id');
        $report_id = $request->input('report_id');
        $officer_id = $request->input('officer_id');

        $report = report_posts::find($report_id);
        $report->officer_id = $officer_id;
        $officer = User::find($officer_id);

        if($report->update()){
            $this->helper->keep_activity($admin_id, $officer_id, "assigned", $report_id);
            $this->helper->assign_officer_action($report_id, $officer->name);
            return 'success';
        }
        else return 'fail';
    }

    function addComment(Request $request){

        $report_id = $request->input('report_id');
        $user_id = $request->input('user_id');
        $comment = $request->input('comment');

        $newComment = new comments();
        $newComment->report_id = $report_id;
        $newComment->user_id = $user_id;
        $newComment->message = $comment;
        $status = $newComment->save();

        $reports = report_posts::find($report_id);

        if($reports->user_id != $user_id)
            $this->helper->keep_activity($user_id, $reports->user_id, 'comment', $report_id);

        if($status){
            return $newComment;
        }

        // if($status = $newComment->save()){
        //     $user = report_posts::where('id', '=', $report_id)
        //             ->select('user_id')->get();

        //     while($i < count($user)){
        //         if($user_id != $user[$i]->user_id){
        //             $userFIrebaseID = mobile_user::find($user[$i]->user_id);
        //             $info = array();
        //             $info['message'] = $currentUser->name." has commented on your report";
        //             $info['report_id'] = $request['report_id'];
        //             $info['created_at'] = date('Y-m-d G:i:s');

        //             $push = new Push();
        //             $push->setTitle("New Comment");
        //             $push->setIsBackground(FALSE);
        //             $push->setFlag(3);
        //             $push->setData($info);

        //             $gcm = new GCM();
        //             $status = $gcm->send($userFIrebaseID['firebaseID'], $push->getPush());
        //             $this->helper->keep_activity($user_id, $user[$i]->user_id, "Comment", $report_id);
        //         }
        //         $i++;            
        //     }

        //     $comments = DB::table('comments')
        //     ->select('comments.*', 'mobile_user.name', 'mobile_user.id as user_id', 'mobile_user.avatar_link')
        //     ->join('mobile_user', 'comments.user_id', '=', 'mobile_user.id')
        //     ->where('comments.report_id', $report_id)
        //     ->where('comments.id', $newComment->id)
        //     ->get();

        //     return response()->json($comments);
        // }
        // else {
        //     return "Fail";
        // }

    }

    function getComment(Request $request){

        $report_id = $request->input('report_id');
        $comment = comments::with('user')->where('report_id', $report_id)->orderby('created_at', 'asc')->get();

        // $comments = DB::table('comments')
        //     ->select('comments.*', 'mobile_user.name', 'mobile_user.id as user_id', 'mobile_user.avatar_link')
        //     ->join('mobile_user', 'comments.user_id', '=', 'mobile_user.id')
        //     ->where('comments.report_id', $report_id)
        //     ->orderby('comments.created_at', 'asc')
        //     ->get();

        return $comment;
    }

    function getAction(Request $request){
        $report_id = $request->input('report_id');
        $action = action::where('report_id', $report_id)->orderby('created_at', 'desc')->get();
        return $action;
    }

    function updateResponse(Request $request){
        /* get user id and report id and the response */
        $user_id = $request->input('user_id');
        $report_id = $request->input('report_id');
        $type = $request->input('type');
        $value = $request->input('value');

        $response = response::where('user_id', $user_id)->where('report_id', $report_id);
        $report = report_posts::find($report_id);

        if($response->exists()){

            $data = response::findOrFail($response->value('id'));
            // print_r($data);

            switch ($type) {
                case "support":
                    $data->support = $value;
                    $status = $data->update();
                    if($status && $user_id != $report->user_id && $value == 1)
                        $this->helper->keep_activity($user_id, $report->user_id, "support", $report_id);
                    break;
                
                case 'affected':
                    $data->affected = $value;
                    $status = $data->update();
                    if($status && $user_id != $report->user_id && $value == 1)
                        $this->helper->keep_activity($user_id, $report->user_id, "affected", $report_id);
                    break;
                default:
                    break;
            }

        } else {

            $data = new response();
            $data->user_id = $user_id;
            $data->report_id = $report_id;

            switch ($type) {
                case 'support':
                    $data->support = $value;
                    $data->affected = 0;
                    $status = $data->save();
                    $this->helper->keep_activity($user_id, $report->user_id, "support", $report_id);
                    break;
                
                case 'affected':
                    $data->support = 0;
                    $data->affected = $value;
                    $status = $data->save();
                    $this->helper->keep_activity($user_id, $report->user_id, "affected", $report_id);
                    break;
                default:
                    break;
            }

        }

        $this->helper->update_report_response($report_id, $type, $value);

        if($status)
            return "success";
        else return "fail";
        /* when report and user exists [update their response] */
        // $data = response::where('user_id', $user_id)->where('report_id', $report_id);
        // if($data->e)
    }

    function update_action(Request $request)
    {

        $report_id = $request->input('report_id');
        $action = $request->input('action');
        $status = $request->input('status_id');
        $image = $request->file('image');

        $serverPath = "http://192.168.1.101/BetterPepperBoard/pepperboard.net/action";
        $myDate = date("Y-m-d");
        $myTime = date("h-i-sa");
        $image_name= $report_id. "-" . $myDate . $myTime . '.png';

        // return $request->file('image');

        if(!is_null($request->file('image')))
        {

            if(!$this->helper->upload_status_media($report_id, $image, $image_name))
            {
                return false;
            }
            else 
            {
                $actions = new action();
                $actions->report_id = $report_id;
                $actions->action_taken = $action;
                $actions->media_type = 1;
                $actions->link = $serverPath."/".$report_id."/".$image_name;
                $actions->current_status_id = $status;

                if($status == 1)
                    $this->helper->update_report_status($report_id, $status);

                if($actions->save())
                {
                    return "success";
                } else return "fail";
            }

        }
        else 
        {
            $actions = new action();
            $actions->report_id = $report_id;
            $actions->action_taken = $action;
            $actions->media_type = 0;
            $actions->link = NULL;
            $actions->current_status_id = $status;

            if($status == 1)
                $this->helper->update_report_status($report_id, $status);

            if($actions->save())
            {
                return "success";
            } else 
                return "fail";
        }
    }
}
