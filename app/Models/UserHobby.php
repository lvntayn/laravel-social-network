<?php
/**
 * Created by lvntayn
 * Date: 03/06/2017
 * Time: 22:45
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class UserHobby extends Model
{

    protected $table = 'user_hobbies';


    protected $primaryKey = ['user_id', 'hobby_id'];


    public $incrementing = false;

    public $timestamps = false;


    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function hobby(){
        return $this->belongsTo('App\Models\Hobby', 'hobby_id');
    }
}