<?php
namespace App\Models;

use App\Models\BaseGameModel;

class ProjectUser extends BaseGameModel
{
    protected  $table='project_users';
    public $timestamps = false;
    protected $guarded = [];

    function autoApprove()
    {
        return;
    }
}