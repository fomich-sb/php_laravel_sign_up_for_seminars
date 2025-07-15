<?php
namespace App\Models;

use App\Models\BaseGameModel;

class Material extends BaseGameModel
{
    protected  $table='materials';
    public $timestamps = false;
    protected $guarded = [];
}