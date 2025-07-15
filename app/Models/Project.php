<?php
namespace App\Models;

use App\Models\BaseGameModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function getAllProjectList() 
    {
        return DB::select('SELECT * 
            FROM projects p 
                LEFT JOIN (SELECT project_id, SUM(IF(status=1, 1, 0) ) users_1, SUM(IF(status=0, 1, 0) ) users_0 FROM project_users GROUP BY project_id) pu ON p.id=pu.project_id
            WHERE p.deleted_at is NULL
            ORDER BY p.date_start', []);
    }

    public function save(array $options = [])
    {
        if(!$this->creator_id)
            $this->creator_id = Auth::user()->id;
        return parent::save($options);
    }
}