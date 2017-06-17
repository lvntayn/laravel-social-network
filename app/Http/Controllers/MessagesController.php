<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDirectMessage;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;
use View;

class MessagesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = null)
    {

        $user = Auth::user();

        $user_list = $user->messagePeopleList();

        $show = false;
        if ($id != null){
            $friend = User::find($id);
            if ($friend){
                $show = true;
            }
        }

        return view('messages.index', compact('user', 'user_list', 'show', 'id'));
    }


    public function chat(Request $request){

        $response = array();
        $response['code'] = 400;

        $friend = User::find($request->input('id'));

        $user = Auth::user();



        if ($friend){
            $response['code'] = 200;
            $message_list = UserDirectMessage::where(function ($q) use($friend, $user){
                $q->where(function ($q) use($friend, $user){
                    $q->where('sender_user_id', $user->id)->where('receiver_user_id', $friend->id)->where('sender_delete', 0);
                })->orWhere(function ($q) use($friend, $user){
                    $q->where('receiver_user_id', $user->id)->where('sender_user_id', $friend->id)->where('receiver_delete', 0);
                });
            })->orderBy('id', 'DESC')->limit(50);

            $update_all = UserDirectMessage::where('receiver_delete', 0)
                ->where('receiver_user_id', $user->id)->where('sender_user_id', $friend->id)->where('seen', 0)->update(['seen' => 1]);


            $can_send_message = true;
            if ($user->messagePeopleList()->where('follower_user_id', $friend->id)->count() == 0){
                $can_send_message = false;
            }

            $html = View::make('messages.widgets.chat', compact('user', 'friend', 'message_list', 'can_send_message'));
            $response['html'] = $html->render();
        }

        return Response::json($response);
    }

    public function peopleList(Request $request){

        $response = array();
        $response['code'] = 200;

        $user = Auth::user();

        $active_user_id = $request->input('active_user_id');

        $user_list = [];


        $message_list = DB::select( DB::raw("select * from (select * from `user_direct_messages` where ((`sender_user_id` = '".$user->id."' and `sender_delete` = '0') or (`receiver_user_id` = '".$user->id."' and `receiver_delete` = '0')) order by `id` desc limit 200000) as group_table group by receiver_user_id, receiver_user_id order by id desc") );

        $new_list = [];
        foreach(array_reverse($message_list) as $list){
            $msg = new UserDirectMessage();
            $msg->dataImport($list);
            $new_list[] = $msg;
        }


        foreach (array_reverse($new_list) as $message){
            if ($message->sender_user_id == $user->id){
                if (array_key_exists($message->receiver_user_id, $user_list)) continue;
                $user_list[$message->receiver_user_id] = [
                    'new' => false,
                    'message' => $message,
                    'user' => $message->receiver
                ];
            }else{
                if (array_key_exists($message->sender_user_id, $user_list)) continue;
                $user_list[$message->sender_user_id] = [
                    'new' => ($message->seen == 0)?true:false,
                    'message' => $message,
                    'user' => $message->sender
                ];
            }
        }


        $html = View::make('messages.widgets.people_list', compact('user', 'active_user_id', 'user_list'));
        $response['html'] = $html->render();

        return Response::json($response);

    }

    public function notifications(Request $request){
        $response = array();
        $response['code'] = 200;

        $user = Auth::user();


        $user_list = [];


        $message_list = DB::select( DB::raw("select * from (select * from `user_direct_messages` where `receiver_user_id` = '".$user->id."' and `receiver_delete` = '0'  and `seen` = '0' order by `id` desc limit 200000) as group_table group by sender_user_id order by id desc") );

        $new_list = [];
        foreach(array_reverse($message_list) as $list){
            $msg = new UserDirectMessage();
            $msg->dataImport($list);
            $new_list[] = $msg;
        }



        foreach (array_reverse($new_list) as $message){
            $user_list[$message->sender_user_id] = [
                'new' => ($message->seen == 0)?true:false,
                'message' => $message,
                'user' => $message->sender
            ];
        }


        $html = View::make('messages.widgets.notifications', compact('user', 'user_list'));
        $response['html'] = $html->render();

        return Response::json($response);
    }

    public function deleteChat(Request $request){
        $response = array();
        $response['code'] = 400;

        $friend = User::find($request->input('id'));

        $user = Auth::user();



        if ($friend){
            $response['code'] = 200;

            $update_all = UserDirectMessage::where('receiver_delete', 0)
                ->where('receiver_user_id', $user->id)->where('sender_user_id', $friend->id)->update(['receiver_delete' => 1]);
            $update_all = UserDirectMessage::where('sender_delete', 0)
                ->where('sender_user_id', $user->id)->where('receiver_user_id', $friend->id)->update(['sender_delete' => 1]);


        }

        return Response::json($response);
    }


    public function deleteMessage(Request $request){
        $response = array();
        $response['code'] = 400;

        $message = UserDirectMessage::find($request->input('id'));

        $user = Auth::user();



        if ($message){
            $response['code'] = 200;

            if ($message->sender_user_id == $user->id){
                $message->sender_delete = 1;
            }else{
                $message->receiver_delete = 1;
            }

            if ($message->save()){
                $response['code'] = 200;
            }


        }

        return Response::json($response);
    }


    public function newMessages(Request $request){

        $response = array();
        $response['code'] = 400;

        $friend = User::find($request->input('id'));

        $user = Auth::user();

        if ($friend){
            $response['code'] = 200;

            $message_list = UserDirectMessage::where('receiver_delete', 0)
                ->where('receiver_user_id', $user->id)->where('sender_user_id', $friend->id)->where('seen', '0')->orderBy('id', 'DESC')->limit(20);



            if ($message_list->count() > 0) {



                $response['find'] = 1;
                $html = View::make('messages.widgets.new_messages', compact('user', 'friend', 'message_list'));
                $response['html'] = $html->render();

                $update_all = UserDirectMessage::where('receiver_delete', 0)
                    ->where('receiver_user_id', $user->id)->where('sender_user_id', $friend->id)->where('seen', 0)->update(['seen' => 1]);
            }else{
                $response['find'] = 0;
            }
        }

        return Response::json($response);
    }

    public function send(Request $request){

        $response = array();
        $response['code'] = 400;

        $friend = User::find($request->input('id'));

        $user = Auth::user();

        if ($friend){
            $message = new UserDirectMessage();
            $message->sender_user_id = $user->id;
            $message->receiver_user_id = $friend->id;
            $message->message = $request->input('message');
            if ($message->save()){
                $response['code'] = 200;
                $html = View::make('messages.widgets.single_message', compact('user', 'message'));
                $response['html'] = $html->render();
                $response['message_id'] = $message->id;
            }
        }

        return Response::json($response);
    }

}
