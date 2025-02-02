<?php

namespace App\Http\Controllers\Admin;

use App\Facades\Utils;
use App\Models\Mailing;
use App\Models\Photo;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MailingController extends AdminController
{
    public function actionGetPreviewContent()
    {
        $projectId = intval(request()->get('projectId'));
        $project = App(Project::class)->findOrFail($projectId);
        $text = request()->get('text');
        
        $user = Auth::user();
        $response['content'] = App(Mailing::class)->generateContent($project, $user, $text);
        return $this->successResponseJSON($response);
    }

    public function actionSend()
    {
        $projectId = intval(request()->get('projectId'));
        $project = App(Project::class)->findOrFail($projectId);
        $text = request()->get('text');
        $userIds = request()->get('userIds');
        
        foreach($userIds as $userId){
            $user = App(User::class)->find(intval($userId));
            if($user)
                App(Mailing::class)->send($project, $user, $text);
        }
        return $this->successResponseJSON($response);
    }
}
