<?php
/**
 * Created by lvntayn
 * Date: 03/06/2017
 * Time: 22:45
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class UserLocation extends Model
{

    protected $table = 'user_locations';

    protected $primaryKey = 'user_id';

    public $incrementing = false;

    public $timestamps = false;


    public function city(){
        return $this->belongsTo('App\Models\City', 'city_id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}