<?php
namespace App\Models;

use App\Models\BaseGameModel;

class Photo extends BaseGameModel
{
    protected  $table='photos';
    public $timestamps = false;
    protected $guarded = [];
}