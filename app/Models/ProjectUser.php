<?php
namespace App\Models;

use App\Facades\Utils;
use App\Models\BaseGameModel;
use Illuminate\Support\Facades\Request;

class ProjectUser extends BaseGameModel
{
    protected  $table='project_users';
    public $timestamps = false;
    protected $guarded = [];
    function autoApprove(&$user)
    {
        if($user->auto_approve)
            $this->status=1;
        return;
    }


    public function save(array $options = [])
    {
        $sendStatusMessage = false;
        if($this->isDirty('status')) 
            $sendStatusMessage = true;
            
        $res = parent::save($options);

        if($sendStatusMessage && $this->status != 0){
            $user = App(User::class)->find($this->user_id);
            $project = App(Project::class)->find($this->project_id);
            if($this->status == 1) 
                Utils::sendMessage($user, 'Ваша заявка на семинар "'.$project->caption.'" одобрена.
Дополнительная информация: ' . Request::root().'/?id='.$project->id.'#materials');
            if($this->status == -1) 
                Utils::sendMessage($user, 'Ваша заявка на семинар "'.$project->caption.'" отклонена.
Страница семинара: ' . Request::root().'/?id='.$project->id);
        }
        return $res; 
    }
}