<?php

namespace App\Http\Controllers\Admin;

use App\Facades\Utils;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;

class ProjectUserController extends AdminController
{
    public function actionSetStatus()
    {
        $projectUserId = intval(request()->get('projectUserId'));
        $projectUser = App(ProjectUser::class)->findOrFail($projectUserId);
        $projectUser->status = intval(request()->get('status'));
        $projectUser->save();
        
        return $this->successResponseJSON();
    }

    public function actionGetAddCardContent()
    {
        $projectId = intval(request()->get('projectId'));
        $project = App(Project::class)->findOrFail($projectId);

        $dataRender = [
            'project' => $project,
        ];

        $response['blockContent'] = view('admin/project/projectAddUser', $dataRender)->render();
        return $this->successResponseJSON($response);
    }
    

    public function actionAdd($dopSetItems=[])
    {
        $projectId = intval(request()->get('projectId'));
        $project = App(Project::class)->findOrFail($projectId);
        $phoneList = preg_split('/\r\n|\r|\n/', request()->get('userList'));
        $create = intval(request()->get('create'));
        $response=['badPhones' => [], 'addedUsers' => [], 'existProjectUsers' => [], 'newUsers' => [], 'notExistPhones' => []];

        foreach($phoneList as $phoneStr)
        {
            if(strlen(trim($phoneStr))<2)
                continue;
            $phone = Utils::isPhone($phoneStr);
            if(!$phone){
                $response['badPhones'][] = $phoneStr;
                continue;
            }

            $user = App(User::class)->where('phone', $phone)->first();
            if(!$user) {
                if($create){
                    $user = new User();
                    $user->phone = $phone;
                    $user->save();
                    $user->fresh();
                    $response['newUsers'][] = $phone;
                }
                else
                {
                    $response['notExistPhones'][] = $phoneStr;
                    continue;
                }
            }  
            $projectUser = App(ProjectUser::class)->where('project_id', $project->id)->where('user_id', $user->id)->first();
            if($projectUser)
            {
                $response['existProjectUsers'][] = $phone;
                if($projectUser->status<1){
                    $projectUser->status=1;
                    $projectUser->save();
                }
            }
            else {
                $projectUser = new ProjectUser();
                $projectUser->project_id = $project->id;
                $projectUser->user_id = $user->id;
                $projectUser->status=1;
                $projectUser->save();
                $response['addedUsers'][] = $phone;
            }

        }
        
        return $this->successResponseJSON($response);
    }
}
