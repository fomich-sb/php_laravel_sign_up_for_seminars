<?php
namespace App\Models;

use App\Models\BaseGameModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

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
            "fixed" => ['id' => 30, 'caption' => 'Регистрация закрыта'],
            "ended" => ['id' => 40, 'caption' => 'После семинара / доступен сертификат'],
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

    public function save(array $options = [])
    {
        if(!$this->creator_id)
            $this->creator_id = Auth::user()->id;
        return parent::save($options);
    }
}