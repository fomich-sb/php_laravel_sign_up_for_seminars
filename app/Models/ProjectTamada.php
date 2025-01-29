<?php
namespace App\Models;

use App\Facades\Utils;
use App\Models\BaseGameModel;
use Illuminate\Support\Facades\Request;

class ProjectTamada extends BaseGameModel
{
    protected  $table='project_tamadas';
    public $timestamps = false;
    protected $guarded = [];
}