<?php
/**
 * Created by lvntayn
 * Date: 04/06/2017
 * Time: 17:23
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PostLike extends Model
{

    protected $table = 'post_likes';

    public $incrementing = false;

    protected $primaryKey = ['post_id', 'like_user_id'];

    protected $dates = [
        'created_at',
        'updated_at'
    ];


    public function post(){
        return $this->belongsTo('App\Models\Post', 'post_id');
    }


    public function user(){
        return $this->belongsTo('App\Models\User', 'like_user_id');
    }

}