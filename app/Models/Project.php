<?php
namespace App\Models;

use App\Models\BaseGameModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends BaseGameModel
{
    protected  $table='projects';
    public $timestamps = false;
    protected $guarded = [];
    use SoftDeletes;

    public function getActual()
    {
        return App(Project::class)->where('status', '<>', $this->getStatusId('created'))->where('status', '<>', $this->getStatusId('closed'))->orderBy('date_start')->get();
    }

    public function getStatuses()
    {
        return [
            "created" => ['id' => 0, 'caption' => 'Не открыт'],
            "opened" => ['id' => 10, 'caption' => 'До регистрации'],
            "registration" => ['id' => 20, 'caption' => 'Регистрация'],
            "fixed" => ['id' => 30, 'caption' => 'После регистрации'],
            "closed" => ['id' => 100, 'caption' => 'Закрыт'],
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