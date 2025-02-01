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
        $statusDirty = false;
        if($this->isDirty('status')) 
            $statusDirty = true;
            
        $res = parent::save($options);

        if($statusDirty){
            $user = App(User::class)->find($this->user_id);
            $project = App(Project::class)->find($this->project_id);
            if($this->status == 1) {
                $message = App(Setting::class)->get('project_register_status1');
                if(strlen(trim($message))>0)
                    Utils::sendMessage($user, Utils::prepareText($message, ['project' => $project]));
            }
            if($this->status == 0) {
                $message = App(Setting::class)->get('project_register_status0');
                if(strlen(trim($message))>0)
                    Utils::sendMessage($user, Utils::prepareText($message, ['project' => $project]));
            }
            if($this->status == -1) {
                $message = App(Setting::class)->get('project_register_status-1');
                if(strlen(trim($message))>0)
                    Utils::sendMessage($user, Utils::prepareText($message, ['project' => $project]));
            }

            if($this->certificate_id)
            {
                $certificate = App(Certificate::class)->find($this->certificate_id);
                if($certificate)
                    $certificate->recreate();
            }
        }
        return $res; 
    }
}