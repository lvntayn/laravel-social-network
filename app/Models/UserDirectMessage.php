<?php
/**
 * Created by lvntayn
 * Date: 03/06/2017
 * Time: 22:45
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class UserDirectMessage extends Model
{

    protected $table = 'user_direct_messages';

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function dataImport($data = [])
    {

        foreach($data as $key => $value) {
            $this->$key = $value;
        }

    }


    public function sender(){
        return $this->belongsTo('App\Models\User', 'sender_user_id');
    }

    public function receiver(){
        return $this->belongsTo('App\Models\User', 'receiver_user_id');
    }



}