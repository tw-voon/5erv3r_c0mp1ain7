<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\mobile_user;
use App\Model\message;
use App\Model\chat_rooms;
use App\Model\chat_handler;
use App\Model\activity_handler;
use App\Model\deleted_message;
use App\Model\report_posts;
use App\Model\response;
use App\User;
use App\Model\notifications;
use App\Http\Controllers\GCM;
use App\Http\Controllers\Push;
use App\Http\Controllers\Helper\helper;
use Validator, DB, File, Hash, Auth, OneSignal;
use Carbon\Carbon;

class users extends Controller
{

    private $helper;

    public function __construct()
    {
        $this->helper = new helper();
    }

    function login(Request $request)
    {

        // return json_encode($request);

        $name = $request->input('name');
        $password = $request->input('pass');

        if (Auth::attempt(['email' => $name, 'password' => $password])) {
            return json_encode(["status" => "success", "data" => Auth::user()]);
        }
    }

    function test_send(){

        OneSignal::sendNotificationUsingTags("Some Message", array(array("key" => "user_id", "relation" => "=", "value" => 5)), $url = null, $data = ['data' => 'ok'], $buttons = null, $schedule = null);

    }

    function query(Request $request){
        $query = $request->input('query');
        $result = report_posts::where('title', 'LIKE', '%'.$query.'%')->orWhere('description', 'LIKE', '%'.$query.'%')
                    ->orderBy('created_at', 'desc')->get();
        return $result;
    }

    function get_complaint_detail(Request $request){
        $user_id = $request->input('user_id');
        $user_role = User::find($user_id);

        if($user_role->role_id == 1){
            $total_report = report_posts::count();
            $solved_report = report_posts::where('status_id', 1)->count();
            $followed_report = report_posts::where('status_id', 2)->count();
        } else if ($user_role->role_id == 2) {
            $total_report = report_posts::where('officer_id', $user_id)->count();
            $solved_report = report_posts::where('officer_id', $user_id)->where('status_id', 1)->count();
            $followed_report = report_posts::where('officer_id', $user_id)->where('status_id', 2)->count();
        } else {
            $total_report = report_posts::where('user_id', $user_id)->count();
            $solved_report = report_posts::where('user_id', $user_id)->where('status_id', 1)->count();
            $own_id = report_posts::where('user_id', $user_id)->pluck('id');
            $followed_report = response::where('user_id', $user_id)->whereNotIn('report_id', $own_id)->where('affected', 1)->count();
        }

        return compact('total_report', 'solved_report', 'followed_report');
    }

    function get_own_report(Request $request){
        $user_id = $request->input('user_id');
        $user_role = User::find($user_id);

        if($user_role->role_id == 1){
            $report = report_posts::with('media', 'user')->where('status_id', 2)->get();
        } else if ($user_role->role_id == 2){
            $report = report_posts::with('media', 'user')->where('officer_id', $user_id)->where('status_id', 2)->get();
        } else
            $report = report_posts::with('media', 'user')->where('user_id', $user_id)->get();

        if($report->count() > 0)
            return compact('report');
        else return "empty";
    }

    function get_followed_report(Request $request){
        $user_id = $request->input('user_id');
        $user_role = User::find($user_id);

        if($user_role->role_id == 1){
            $affected_report = report_posts::with('media', 'user')->where('status_id', 1)->get();
        } else if ($user_role->role_id == 2){
            $affected_report = report_posts::with('media', 'user')->where('officer_id', $user_id)->where('status_id', 1)->get();
        } else {
            $affected_id = response::where('user_id', $user_id)->where('affected', 1)->pluck('report_id');
            $affected_report = report_posts::with('media', 'user')->where('user_id', '!=', $user_id)->whereIn('id', $affected_id)->get();
        }

        if($affected_report->count() > 0)
            return compact('affected_report');
        else return "empty";
    }


    function addAvatar(Request $request){

        $images = $request->input('image');
        $userID = $request->input('user_id');

        $myDate = date("Y-m-d");
        $myTime = date("h-i-sa");
        $serverPath = "http://" . $_SERVER['SERVER_ADDR'] ."/uocs-safe/public/profile";
        // $serverPath = "http://" . $_SERVER['SERVER_NAME'] ."/uocs/profile";

        $image = base64_decode($images);
        $image_name= $userID. "-" . $myDate . $myTime . '.png';
        $path = public_path() . "/profile/". $userID ."/".$image_name;
        $dir = public_path() . "/profile/". $userID ."/";

        if(!File::exists($dir)) {
            $result = File::makeDirectory(public_path() . "/profile/". $userID ."/", 0777, true);
        }

        $result2 = file_put_contents($path, $image);
        $user = mobile_user::find((int)$userID);
        $user->avatar_link = $serverPath."/".$userID."/".$image_name;
        $user->update();

        return json_encode(["status" => "success", "avatar" => $user->avatar_link]);

    }

    function register_user(Request $request)
    {
        $data = $request->all();

        if (!preg_match('[^6]', $data['phone'])) {
            if($data['phone'][0] != 0)
                $data['phone'] = '60'.$data['phone'];
            else 
                $data['phone'] = '6'.$data['phone'];
        }

        $v = Validator::make($data, [
            'name' => 'required|unique:kuchingi_users,name',
            'pass' => 'required|min:6',
            'email' => 'required|email|unique:kuchingi_users,email',
            'phone' => 'required|numeric|unique:kuchingi_users,phone'
        ]);

        if ($v->fails()) {
            return $v->messages()->first();
        }

        $users = new User();
        $users->name = $data['name'];
        $users->password = Hash::make($data['pass']);
        $users->email = $data['email'];
        $users->phone = $data['phone'];
        $users->role_id = 3;
        $status = $users->save();

        if($status)
            return ["status" => "success", "data" => mobile_user::find($users->id)];
        else
            return ["status" => "Something went wrong"];
    }

    function register_key(Request $request)    
    {
        $data = $request->all();
        $user = mobile_user::find($data['userID']);
        $user->firebaseID = $data['token'];
        return json_encode(["status" => $status = $user->update()]);
    }

    function search_user(Request $request){

        $data = $request->all();
        $response = array();

        if(isset($request['name']))
        {
            $users = User::where('name', 'LIKE', '%'.$request['name'].'%')
                    ->where('id', '!=', $request['user_id'])->get();
            if(count($users) > 0)
                return $users;
            else return "empty";
        }
    }


    function fetchChatRoom(Request $request){

        $user_id = $request->input('user_id');

        $chat_room = chat_handler::with('chatroom', 'chatroom.last_message')->where('user_id', $user_id)->get();

        if(count($chat_room) > 0)
            return $chat_room;
        else return "empty";
    }

    function touch_chat_room($user_id, $room_id){

        $id = chat_handler::where('user_id', $user_id)->where('room_id', $room_id);
        $touch = chat_handler::find($id->value('id'));
        $touch->touch();
    }

    function validate_room(){

    }

    function addUser(Request $request){

        $target_user_id = $request->input('target_user_id');
        $user_id = $request->input('user_id');
        $found = false;

        $process_1 = trim($target_user_id,'[]');
        $process_2 = preg_replace('/\s+/', '', $process_1);
        $result = explode(',',$process_2);

        $room_id = chat_handler::where('user_id', $user_id)->pluck('room_id');
        $filter_1 = chat_rooms::whereIn('id', $room_id)->where('member_count', count($result) + 1)->pluck('id');
        array_push($result, $user_id);

        foreach ($filter_1 as $key) {
            $room = chat_handler::where('room_id', $key)->pluck('user_id');

            $ids = array();

            foreach ($room as $value) {
                array_push($ids, $value);
            }

            if(array_diff($result, $ids))
                $found = false;
            else {
                $found = true;
                return json_encode(["status" => "room_found", "chat_room" => chat_rooms::find($key)]);
            }
        }

        if(!$found){

            /*Create the room first*/
            $chat_rooms = new chat_rooms();
            $chat_rooms->name = "Chat Room (" . count($result) . ")";
            $chat_rooms->member_count = count($result);
            $chat_rooms->save();

            foreach ($result as $id) {

                $chat_handler = new chat_handler();
                $chat_handler->user_id = $id;
                $chat_handler->room_id = $chat_rooms->id;
                $chat_handler->save();

            }

            return json_encode(["status" => "success", "chat_room" => chat_rooms::find($chat_rooms->id)]);

        }        
    }

    function fetchSingleChatRoom(Request $request)
    {
        $chat_room_id = $request->input('chat_room_id');
        $user_id = $request->input('user_id');
        $deleted_msg = deleted_message::where('user_id', $user_id)->pluck('msg_id');

        if(chat_handler::where('user_id', $user_id)->where('room_id', $chat_room_id)->exists())
            $message = message::with('user')->where('chat_room_id', $chat_room_id)->whereNotIn('id', $deleted_msg)->get();
        else $message = null;

        $this->touch_chat_room($user_id, $chat_room_id);

        if(count($message) > 0)
            return $message;
        else return 'empty';
    }

    function editPlayer(Request $request){

    }

    function addMessage(Request $request){

        $user_id = $request->input('user_id');
        $room_id = $request->input('room_id');
        $message = $request->input('message');

        $newMessage = new message();
        $newMessage->chat_room_id = $room_id;
        $newMessage->user_id = $user_id;
        $newMessage->message = $message;
        $newMessage->save();

        $info = array();
        $info['chat_room'] = chat_handler::with('chatroom', 'chatroom.last_message')->where('user_id', $user_id)->get();
        $info['message'] = message::with('user', 'room')->where('chat_room_id', $room_id)->orderBy('created_at', 'desc')->first();
        $info['state'] = 'chat';

        $user_ids = chat_handler::where('room_id', $room_id)->get();

        foreach ($user_ids as $data) {

            if($data['user_id'] != $user_id){
                OneSignal::sendNotificationUsingTags($message, array(array("key" => "user_id", "relation" => "=", "value" => $data['user_id'])), $room_id, $url = null, $data = $info, $buttons = null, $schedule = null);
            }

        }

        $this->touch_chat_room($user_id, $room_id);
        return compact('info');

    }

    function testMessage(Request $request){
        // $data = $request->all();
        // $newMessage = new message();
        // $newMessage->chat_room_id = $data['chat_room_id'];
        // $newMessage->user_id = $data['user_id'];
        // $newMessage->message = $data['message'];
        // $newMessage->save();

        // $userID = (int)$data['user_id'];

        // $user = mobile_user::where('id', '=', $request['user_id'])->select('id')->get();
        // // return $user[0]->id;

        // $userData = mobile_user::find($user[0]->id);

        // $info = array();
        // $info['user'] = $userData;
        // $info['message'] = $newMessage;
        // $info['chat_room_id'] = $request['chat_room_id'];
        // $info['created_at'] = date('Y-m-d G:i:s');

        // $push = new Push();
        // $push->setTitle("Google Cloud Messaging");
        // $push->setIsBackground(FALSE);
        // $push->setFlag(1);
        // $push->setData($info);

        // $gcm = new GCM();
        // $gcm->send($userData['firebaseID'], $push->getPush());

        // echo json_encode(['message' => $push->getPush(),"user" =>$userData,  "error" => false]);
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else{
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
    }

    function getOwnReport(Request $request){

        $own_id = $request->input('user_id');
        $report = DB::table('approve_handler')
                ->join('status_table', 'status_table.id', 'approve_handler.status_id')
                ->join('report', 'report.id', 'approve_handler.report_id')
                ->where('report.user_ID', $own_id)
                ->get();

        return json_encode($report);
    }

    function get_Activity(Request $request){

        $data = $request->all();

        $activity = activity_handler::where('action_done_on', $data['user_id'])
                    ->select('mobile_user.id', 
                        'mobile_user.avatar_link',
                        'activity_handler.report_id', 
                        'activity_handler.action_name',
                        'activity_handler.created_at',
                        'activity_handler.action_done_by')
                    ->join('mobile_user', 'mobile_user.id', 'activity_handler.action_done_by')
                    ->orderBy('activity_handler.created_at', 'desc')
                    ->get();
        return json_encode($activity);

        /*$activity = DB::table('activity_handler')
                    ->where('action_done_on', $data['user_id'])
                    ->pluck('action_done_on', 'action_done_by');

        foreach ($activity as $key => $value) {
            array_push($user_id, $key);
            array_push($user_id, $value);
        }

        foreach ($user_id as $value) {
            $data = users::find($value);

        }
        return json_encode($user_id);*/
    }

    function get_notification(Request $request){
        $user_id = $request->input('user_id');
        $noti = notifications::where('user_id', $user_id)->orderBy('updated_at', 'desc')->get();
        if(count($noti) > 0)
            return compact('noti');
        else return "empty";
    }
}
