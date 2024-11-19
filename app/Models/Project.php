<?php
namespace App\Models;

use App\Models\BaseGameModel;

class Project extends BaseGameModel
{
    protected  $table='projects';
    public $timestamps = false;
    protected $guarded = [];

    public function getActual()
    {
        return App(Project::class)->where('status', '<>', $this->getStatusId('created'))->where('status', '<>', $this->getStatusId('closed'))->orderBy('date_start')->get();
    }

    public function getStatuses()
    {
        return [
            "created" => ['id' => 0],
            "opened" => ['id' => 10],
            "registration" => ['id' => 20],
            "fixed" => ['id' => 30],
            "closed" => ['id' => 100],
        ];
    }

    public function getStatusId($code)
    {
        if(isset($this->getStatuses()[$code]))
            return $this->getStatuses()[$code]['id'];
        return null;
    }

    public function getStatusById($statusId)
    {
        foreach($this->getStatuses() as $status)
            if($status['id'] == $statusId)
                return $status;
        return null;
    }
}