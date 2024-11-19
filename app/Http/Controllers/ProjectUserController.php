<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Facades\Utils;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;

class ProjectUserController extends Controller
{
    public function actionFindPhone()
    {
        $projectId = intval(request()->get('projectId'));
        $phone = Utils::isPhone(request()->get('phone', ''));
        if(!$phone)
            $this->errorResponseJSON("Проверьте номер телефона");

        $userItems = App(User::class)->where('phone', $phone)->get();
        $response = [];
        if(count($userItems) > 0) {
            $user = $userItems[0];
            $response['user'] = true;

            $projectUserItems = App(ProjectUser::class)->where('user_id', $user->id)->where('project_id', $projectId)->get();
            
            if(count($projectUserItems) > 0) {
                $response['projectUser'] = true;
            }
        }

        return $this->successResponseJSON($response);
    }

    public function actionRegister()
    {
        $projectId = intval(request()->get('projectId'));
        $phone = Utils::isPhone(request()->get('phone', ''));
        if(!$phone)
            $this->errorResponseJSON("Проверьте номер телефона");

        $project = App(Project::class)->find($projectId);
        if(!$project || $project->status != $project->getStatusId('registration'))
            $this->errorResponseJSON("Регистрация не доступна");

        $user = App(User::class)->firstOrCreate(['phone' => $phone]);
        $user->name1 = trim(request()->get('name1'));
        $user->name2 = trim(request()->get('name2'));
        $user->name3 = trim(request()->get('name3'));
        $user->nameEn1 = trim(request()->get('nameEn1'));
        $user->nameEn2 = trim(request()->get('nameEn2'));
        $user->gender = intval(request()->get('gender'));
        $user->save();

        $projectUser = App(ProjectUser::class)->firstOrCreate(['user_id' => $user->id, 'project_id' => $projectId]);
        $projectUser->autoApprove();
        $response['status'] = $projectUser->status;
        return $this->successResponseJSON($response);
    }
}
