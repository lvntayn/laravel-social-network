<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Group;
use App\Models\Hobby;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{

    public $group;

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function secure($id){
        $group = Group::find($id);

        if ($group){
            $this->group = $group;

            if (!Auth::user()->hasHobby($this->group->hobby_id)) return false;

            return true;
        }
        return false;
    }

    public function index()
    {

        $user = Auth::user();


        $groups = Group::join('user_hobbies', 'user_hobbies.hobby_id', '=', 'groups.hobby_id')
            ->where('user_hobbies.user_id', $user->id)->select('groups.*');

        $city = $user->location->city;


        return view('groups.index', compact('user', 'groups', 'city'));
    }



    public function group($id){

        if (!$this->secure($id)) return redirect('/404');

        $user = Auth::user();

        $group = $this->group;

        $wall = [
            'new_post_group_id' => $group->id
        ];

        $city = $user->location->city;

        return view('groups.group', compact('user', 'group', 'wall', 'city'));
    }



    public function stats($id){


        if (!$this->secure($id)) return redirect('/404');

        $user = Auth::user();

        $group = $this->group;

        $country = $user->location->city->country;
        $city = $user->location->city;

        $all_countries = $group->countAllCountries();

        return view('groups.stats', compact('user', 'group', 'country', 'city', 'all_countries'));
    }



}
