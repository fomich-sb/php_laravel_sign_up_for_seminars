<?php
namespace App\Models;

use App\Models\BaseGameModel;

class ProjectTamada extends BaseGameModel
{
    protected  $table='project_tamadas';
    public $timestamps = false;
    protected $guarded = [];
}