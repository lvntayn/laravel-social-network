<?php
namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Library\sHelper;
use App\Models\User;
use App\Models\UserFollowing;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Response;
use Session;
use View;


class FollowController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function follow(Request $request){




        $response = array();
        $response['code'] = 400;

        $following_user_id = $request->input('following');
        $follower_user_id = $request->input('follower');
        $element = $request->input('element');
        $size = $request->input('size');



        $following = User::find($following_user_id);
        $follower = User::find($follower_user_id);



        if ($following && $follower && ($following_user_id == Auth::id() || $follower_user_id == Auth::id())){



            $relation = UserFollowing::where('following_user_id', $following_user_id)->where('follower_user_id', $follower_user_id)->get()->first();

            if ($relation){
                if ($relation->delete()){
                    $response['code'] = 200;
                    if ($following->isPrivate()) {
                        $response['refresh'] = 1;
                    }
                }
            }else{
                $relation = new UserFollowing();
                $relation->following_user_id = $following_user_id;
                $relation->follower_user_id = $follower_user_id;
                if ($following->isPrivate()){
                    $relation->allow = 0;
                }else{
                    $relation->allow = 1;
                }
                if ($relation->save()){
                    $response['code'] = 200;
                    $response['refresh'] = 0;
                }
            }

            if ($response['code'] == 200){
                $response['button'] = sHelper::followButton($following_user_id, $follower_user_id, $element, $size);
            }
        }


        return Response::json($response);

    }

    public function followerRequest(Request $request){


        $response = array();
        $response['code'] = 400;

        $type = $request->input('type');
        $id = $request->input('id');



        $following = UserFollowing::find($id);



        if ($following){

            if ($following->following_user_id = Auth::id()){

                if ($type == 2){
                    if ($following->delete()){
                        $response['code'] = 200;
                    }
                }else{
                    $following->allow = 1;
                    if ($following->save()){
                        $response['code'] = 200;
                    }
                }


            }


        }


        return Response::json($response);

    }

    public function followDenied(Request $request){


        $response = array();
        $response['code'] = 400;

        $me = $request->input('me');
        $follower = $request->input('follower');



        $relation = UserFollowing::where('following_user_id', $me)->where('follower_user_id', $follower)->get()->first();



        if ($relation){


            if ($relation->delete()){
                $response['code'] = 200;
            }


        }


        return Response::json($response);

    }


    public function pending(Request $request){


        $user = Auth::user();

        $list = $user->follower()->where('allow', 0)->with('follower')->get();


        return view('followers_pending', compact('user', 'list'));
    }

}