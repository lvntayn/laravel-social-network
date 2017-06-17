<?php
/**
 * Created by lvntayn
 * Date: 03/06/2017
 * Time: 22:45
 */

namespace App\Models;


use DB;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{

    protected $table = 'groups';

    public $timestamps = false;

    public function hobby(){
        return $this->belongsTo('App\Models\Hobby', 'hobby_id');
    }


    public function countPeople($id = 0, $country = false){

        if ($id == 0){
            $s = Group::leftJoin('user_hobbies', 'user_hobbies.hobby_id', '=', 'groups.hobby_id')
                ->where('groups.hobby_id', $this->hobby_id)
                ->select(DB::raw('count(user_hobbies.user_id) as count'))->get()->first();
        }else if ($country){

            $s = Group::leftJoin('user_hobbies', 'user_hobbies.hobby_id', '=', 'groups.hobby_id')
                ->leftJoin('user_locations', 'user_locations.user_id', '=', 'user_hobbies.user_id')
                ->leftJoin('cities', 'cities.id', '=', 'user_locations.city_id')
                ->where('groups.hobby_id', $this->hobby_id)->where('cities.country_id', $country)
                ->select(DB::raw('count(user_hobbies.user_id) as count'))->get()->first();

        }else{

            $s = Group::leftJoin('user_hobbies', 'user_hobbies.hobby_id', '=', 'groups.hobby_id')
                ->leftJoin('user_locations', 'user_locations.user_id', '=', 'user_hobbies.user_id')
                ->where('groups.hobby_id', $this->hobby_id)->where('user_locations.city_id', $id)
                ->select(DB::raw('count(user_hobbies.user_id) as count'))->get()->first();
        }


        if ($s) {
            return $s->count;
        }

        return 0;

    }

    public function countAllCountries(){

        $s = Group::leftJoin('user_hobbies', 'user_hobbies.hobby_id', '=', 'groups.hobby_id')
            ->leftJoin('user_locations', 'user_locations.user_id', '=', 'user_hobbies.user_id')
            ->leftJoin('cities', 'cities.id', '=', 'user_locations.city_id')
            ->leftJoin('countries', 'countries.id', '=', 'cities.country_id')
            ->where('groups.hobby_id', $this->hobby_id)
            ->select(DB::raw('count(*) as count, countries.*'))->groupBy('countries.id')->get();

        return $s;
    }
}