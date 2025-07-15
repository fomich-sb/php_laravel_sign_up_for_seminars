<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Facades\Utils;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ProjectUserController extends Controller
{
    public function actionRegister()
    {
        $projectId = intval(request()->get('projectId'));
        $phone = Utils::isPhone(request()->get('phone', ''));
        if(!$phone)
            $this->errorResponseJSON("Проверьте номер телефона");

        $project = App(Project::class)->find($projectId);
        if(!$project || $project->status != $project->getStatusId('registration'))
            $this->errorResponseJSON("Регистрация не доступна");
            
        if(!Auth::user())
            $user = App(User::class)->firstOrCreate(['phone' => $phone]);
        else
            $user = App(User::class)->where('phone', $phone)->first();

        if(!$user || Auth::user() && Auth::user()->id != $user->id)
            $this->errorResponseJSON("Проверьте номер телефона");

        $user->name1 = trim(request()->get('name1'));
        $user->name2 = trim(request()->get('name2'));
        $user->name3 = trim(request()->get('name3'));
        $user->name_en1 = trim(request()->get('nameEn1'));
        $user->name_en2 = trim(request()->get('nameEn2'));
        $user->gender = intval(request()->get('gender'));
        $user->messager_type = intval(request()->get('messagerType'));
        $user->save();

        $projectUser = App(ProjectUser::class)->firstOrCreate(['user_id' => $user->id, 'project_id' => $projectId]);
        $projectUser->participation_type = intval(request()->get('participationType'));
        $projectUser->autoApprove($user);
        $projectUser->save();

        if($project->creator_id){
            $creator = App(User::class)->find($project->creator_id);
            if($creator){
                Utils::sendMessage($creator, 'Новая заявка в проект "' . $project->caption . '" от '.$user->name1.' '.$user->name2.' '.$user->name3.'. '. Request::root().'/admin/project/user?project_id='.$project->id);
            }
        }
        $response['status'] = $projectUser->status;
        return $this->successResponseJSON($response);
    }

    public function actionDelete()
    {
        if(!Auth::user()) 
            $this->errorResponseJSON("Вы не авторизованы");

        $projectId = intval(request()->get('projectId'));
        $project = App(Project::class)->find($projectId);
        if(!$project || $project->status >= $project->getStatusId('fixed'))
            $this->errorResponseJSON("Действие запрещено");

        App(ProjectUser::class)->where('user_id', Auth::user()->id)->where('project_id', $project->id)->delete();
        return $this->successResponseJSON();
    }
    
}
