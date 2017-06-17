<?php
/**
 * Created by lvntayn
 * Date: 03/06/2017
 * Time: 22:45
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Hobby extends Model
{

    protected $table = 'hobbies';

    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

}