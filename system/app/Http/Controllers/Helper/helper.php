<?php

namespace App\Http\Controllers\Helper;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Model\message;
use App\Model\mobile_user;
use App\Model\chat_rooms;
use App\Model\chat_handler;
use App\Model\report_posts;
use App\Model\report_handler;
use App\Model\locations;
use App\Model\report_media;
use App\Model\action;
use App\Model\response;
use App\Model\notifications;
use App\Http\Controllers\GCM;
use App\Http\Controllers\Push;
use App\Model\activity_handler;
use Validator;
use DB, OneSignal;
use File;
use Carbon\Carbon;

class helper extends Controller
{

    function generate_report_id()
    {
        $date = date_format(date_create(), 'ymd');
        $report_no = report_posts::all()->count();
        
        if($report_no > 0)
            $starting_id = 1000000 + $report_no;
        else 
            $starting_id = 1000000;

        $uniqid = $date.$starting_id.'PPB';
        return $uniqid;
    }

	/* Helper function that keep all the user activity*/
    function keep_activity($user_done, $on_user, $action_name, $report_id)
    {
    	$newNotification = new notifications();

        // echo notifications::where('action_user', $user_done)->where('user_id', $on_user)->where('action_type', $action_name)->exists();

        $check = notifications::where('action_user', $user_done)
                                ->where('user_id', $on_user)
                                ->where('action_type', $action_name)
                                ->where('report_id', $report_id);

        if($check->exists()){
            $row = notifications::find($check->value('id'));
            $row->touch();
            return;
        }

    	switch ($action_name) {

            case 'new':
                $done_by = User::find($user_done);
                $report = report_posts::find($report_id);
                $newNotification->action_user = $user_done;
                $newNotification->user_id = $on_user;
                $newNotification->report_id = $report_id;
                $newNotification->action_type = $action_name;
                $newNotification->content = "<b>".$done_by->name . "</b> has report a new complaint: <b>". $report->title . "'s</b>.";
                $message = $done_by->name . " has report a new complaint: ". $report->title . "'s.";
                if($newNotification->save())
                    $this->send_to_all($message, $report_id);
                break;

    		case 'comment':
    			$done_by = User::find($user_done);
    			$report = report_posts::find($report_id);
    			$newNotification->action_user = $user_done;
    			$newNotification->user_id = $on_user;
    			$newNotification->report_id = $report_id;
                $newNotification->action_type = $action_name;
    			$newNotification->content = "<b>".$done_by->name . "</b> has commented on your <b>". $report->title . "'s</b> post.";
                $message = $done_by->name . " has commented on your ". $report->title . "'s post.";
    			if($newNotification->save())
                    $this->send_to_user($message, $report_id, $on_user);
    			break;

            case 'solved':
                $report = report_posts::find($report_id);
                $newNotification->action_user = $user_done;
                $newNotification->user_id = $on_user;
                $newNotification->report_id = $report_id;
                $newNotification->action_type = $action_name;
                $newNotification->content = "Your <b>" . $report->title . "</b> had been solved.";
                $message = "Your " . $report->title . " had been solved.";
                if($newNotification->save())
                    $this->send_to_user($message, $report_id, $on_user);
                break;

            case 'support':
                $done_by = User::find($user_done);
                $report = report_posts::find($report_id);
                $newNotification->action_user = $user_done;
                $newNotification->user_id = $on_user;
                $newNotification->report_id = $report_id;
                $newNotification->action_type = $action_name;
                $newNotification->content = "<b>".$done_by->name . "</b> supported your <b>". $report->title . "'s</b> post.";
                $message = $done_by->name . " supported your ". $report->title . "'s post.";
                if($newNotification->save())
                    $this->send_to_user($message, $report_id, $on_user);
                break;

            case 'affected':
                $done_by = User::find($user_done);
                $report = report_posts::find($report_id);
                $newNotification->action_user = $user_done;
                $newNotification->user_id = $on_user;
                $newNotification->report_id = $report_id;
                $newNotification->action_type = $action_name;
                $newNotification->content = "<b>".$done_by->name . "</b> also affected of your <b>". $report->title . "'s</b> post.";
                $message = $done_by->name . " also affected of your ". $report->title . "'s post.";
                if($newNotification->save())
                    $this->send_to_user($message, $report_id, $on_user);
                break;

            case 'assigned':
                $done_by = User::find($user_done);
                $report = report_posts::find($report_id);
                $newNotification->action_user = $user_done;
                $newNotification->user_id = $on_user;
                $newNotification->report_id = $report_id;
                $newNotification->action_type = $action_name;
                $newNotification->content = "<b>".$done_by->name . "</b> have assigned <b>". $report->title . "'s</b> post to you.";
                $message = $done_by->name . " have assigned ". $report->title . " post to you.";
                if($newNotification->save())
                    $this->send_to_user($message, $report_id, $on_user);
                break;

    		default:
    			break;
    	}
    }


    function send_to_all($message, $report_id)
    {
        OneSignal::sendNotificationToAll($message, $url = null, $data = ['report_id' => $report_id], $buttons = null, $schedule = null);
    }

    function send_to_user($message, $report_id, $user_id)
    {
        OneSignal::sendNotificationUsingTags($message, array(array("key" => "user_id", "relation" => "=", "value" => $user_id)), $report_id, $url = null, $data = ['report_id' => $report_id], $buttons = null, $schedule = null);
    }

    function mark_report($ids)
    {

        foreach ($ids as $id) 
        {
            $handler = report_handler::find($id);
            $handler->reported = 1;
            $handler->save();
        }
    }

    function sendToOthers($id, $report)
    {

        $tokens = mobile_user::select('firebaseID', 'id')->get();
        $group_id = array();

        if(count($tokens) > 1)
        {
            foreach ($tokens as $token) 
            {
                if($token->id !== $id)
                    array_push($group_id, $token->firebaseID);
            }
        }  else if (count($tokens) == 1){

        }

        

        $info = array();
        $info['message'] = "Report ". $report->report_Title . " has been Published";
        $info['report_id'] = $report->id;
        $info['created_at'] = date('Y-m-d G:i:s');

        $push = new Push();
        $gcm = new GCM();
        
        $push->setTitle("New Report Published");
        $push->setIsBackground(FALSE);
        $push->setFlag(3);
        $push->setData($info);

        $gcm->sendMultiple($group_id, $push->getPush());

        // return $group_id;
    }

    function store_location($location_name, $latitute, $longitute)
    {
        $newLocation = new locations();
        $newLocation->name = $location_name;
        $newLocation->lat = $latitute;
        $newLocation->lon = $longitute;
        $status = $newLocation->save();

        if($status)
            return $newLocation->id;
        else return false;
    }

    function generate_report_media($id, $link)
    {
        $newReportMedia = new report_media();
        $newReportMedia->media_type = 1;
        $newReportMedia->report_id = $id;
        $newReportMedia->link = $link;
        $status = $newReportMedia->save();

        if($status)
            return true;
        else return false;
    }

    function generate_initial_action($id, $status_id)
    {
        $initialAction = new action();
        $initialAction->report_id = $id;
        $initialAction->action_taken = "Assigned with ID: ". $id ." and waiting for assigned to an officer";
        $initialAction->current_status_id = $status_id;
        $status = $initialAction->save();

        if($status)
            return true;
        else return false;
    }

    function assign_officer_action($id, $name)
    {
        $initialAction = new action();
        $initialAction->report_id = $id;
        $initialAction->action_taken = "Assigned to officer : ". $name;
        $initialAction->current_status_id = 2;
        $status = $initialAction->save();

        if($status)
            return true;
        else return false;
    }

    function update_report_response($report_id, $type, $value)
    {
        
        $report = report_posts::find($report_id);
        $affected = response::where('report_id', $report_id)->where('affected', 1)->count();
        $support = response::where('report_id', $report_id)->where('support', 1)->count();
        
        $report->support = $support;
        $report->affected = $affected;

        $report->update();
    }

    function officer_assigned($report_id)
    {
        $report = report_posts::find($report_id);
        if(is_null($report->officer_id)){
            return 0;
        } else return $report->officer_id;
    }

    function upload_status_media($report_id, $images, $image_name)
    {
        $myDate = date("Y-m-d");
        $myTime = date("h-i-sa");

        $image = base64_decode($images);
        // $image_name= $report_id. "-" . $myDate . $myTime . '.png';
        $path = public_path() . "/action/". $report_id ."/".$image_name;
        $dir = public_path() . "/action/". $report_id ."/";
    
        if(!File::exists($dir)) {
            $result = File::makeDirectory(public_path() . "/action/". $report_id ."/", 0777, true);
        }

        // $result2 = file_put_contents($path, $image);
        // move_uploaded_file ( $image , $path );
        $images->move($dir, $image_name);

        return true;
    }

    function update_report_status($report_id, $status)
    {

        $report = report_posts::find($report_id);
        $report->status_id = $status;
        if($report->update())
            return true;
        else 
            return false;
    }
}
