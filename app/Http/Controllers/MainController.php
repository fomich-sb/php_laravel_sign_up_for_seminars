<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Facades\Utils;
use App\Models\Project;

class MainController extends Controller
{
    public function actionIndex()
    {
        $projectItems = App(Project::class)->getActual();
        $currentProjectId = intval(request()->get('id'));
        if(!$currentProjectId && count($projectItems)>0)
            $currentProjectId = $projectItems[0]->id;


        $dataRender = [
            'bodyClass' => 'bodyMain',
            'projectItems' => $projectItems,
            'currentProjectId' => $currentProjectId,
        ];
        if(!$currentProjectId)
            $dataRender['projectContent'] = view('main/noActiveProjects', []);
        else 
            $dataRender['projectContent'] = $this->getProjectContent($currentProjectId);

        $dataRender['blockContent'] = view('main/index', $dataRender);
        return view('/layouts/main', $dataRender);
    }
    
    public function actionGetProjectContent($projectId = null)
    {
        $projectId = intval(request()->get('projectId'));
        if(!$projectId){
            $response = [
                'content' => view('main/projectNotFound', [])->render(),
            ];
            return $this->successResponseJSON($response);
        }
        
        $project = App(Project::class)->find($projectId);
        if(!$project){
            $response = [
                'content' => view('main/projectNotFound', [])->render(),
            ];
            return $this->successResponseJSON($response);
        }

        $response = [
            'content' => $this->getProjectContent($projectId),
        ];
        return $this->successResponseJSON($response);
    }

    public function getProjectContent($projectId)
    {
        $project = App(Project::class)->find($projectId);
        if(!$project)
            return view('main/projectNotFound', [])->render();


        $res = view('/main/projectContent', [
            'project' => $project,
        ])->render();
        if($project->status == App(Project::class)->getStatusId('created') || $project->status == App(Project::class)->getStatusId('opened'))
            $res .= view('/main/projectRegisterNotOpened', [
                'project' => $project,
            ])->render();
        else if($project->status == App(Project::class)->getStatusId('registration'))
            $res .= view('/main/projectRegisterNoAuth', [
                'project' => $project,
            ])->render();
        else
            $res .= view('/main/projectRegisterClosed', [
                'project' => $project,
            ])->render();

        return $res;
    }
    
}
