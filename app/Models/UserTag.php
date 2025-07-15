<?php

namespace App\Models;

class UserTag extends BaseGameModel
{
    protected  $table='user_tags';
    public $timestamps = false;
    protected $guarded = [];
}
