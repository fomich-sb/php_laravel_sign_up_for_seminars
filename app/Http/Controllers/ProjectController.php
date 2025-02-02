<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Facades\Utils;
use App\Models\Certificate;
use App\Models\Material;
use App\Models\Photo;
use App\Models\Place;
use App\Models\Project;
use App\Models\ProjectTamada;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function actionIndex()
    {
        $user = Auth::user();
        $projectItems = App(Project::class)->getActual();
        $currentProjectId = intval(request()->get('id'));
        if(!$currentProjectId && count($projectItems)>0)
            $currentProjectId = $projectItems[0]->id;


        $dataRender = [
            'bodyClass' => 'bodyMain',
            'projectItems' => $projectItems,
            'currentProjectId' => $currentProjectId,
            'user' => $user,
        ];
        if(!$currentProjectId)
            $dataRender['projectContent'] = view('project/noActiveProjects', []);
        else 
            $dataRender['projectContent'] = $this->getContent($currentProjectId);

        $dataRender['blockContent'] = view('main/index', $dataRender);
        return view('/layouts/main', $dataRender);
    }
    
    public function actionGetContent($projectId = null)
    {
        $projectId = intval(request()->get('projectId'));
        if(!$projectId){
            $response = [
                'content' => view('project/projectNotFound', [])->render(),
            ];
            return $this->successResponseJSON($response);
        }
        
        $project = App(Project::class)->find($projectId);
        if(!$project){
            $response = [
                'content' => view('project/projectNotFound', [])->render(),
            ];
            return $this->successResponseJSON($response);
        }

        $response = [
            'content' => $this->getContent($projectId),
        ];
        return $this->successResponseJSON($response);
    }
    
    public function actionGetProjectRegisterSectorContent()
    {
        $response['content']='';
        $user = Auth::user();
        $projectId = intval(request()->get('projectId'));
        $project = App(Project::class)->find($projectId);
        $projectUser = null;
        if($project && $user){
            $projectUser = App(ProjectUser::class)->where('user_id', $user->id)->where('project_id', $projectId)->first();
        }
        $response['content'] = $this->getContentRegister($project, $user, $projectUser);

        return $this->successResponseJSON($response);
    }

    public function getContent($projectId)
    {
        $user = Auth::user();
        $project = App(Project::class)->find($projectId);
        if(!$project)
            return view('project/projectNotFound', [])->render();

        if($user)
            $projectUser = App(ProjectUser::class)->where('user_id', $user->id)->where('project_id', $projectId)->first();

        $res = view('/project/projectContent', [
            'project' => $project,
            'place' => App(Place::class)->find($project->place_id),
            'tamadaItems' => App(User::class)->whereIn('id', App(ProjectTamada::class)->where('project_id', $project->id)->get()->pluck('user_id'))->get(),
        ])->render();

        if($user && $projectUser && $projectUser->status == 1){
            $res .= view('/project/projectContentForAccept', [
                'project' => $project,
            ])->render();
        }

        if($user && $projectUser && $projectUser->status == 1)
            $materialItems = App(Material::class)->where('project_id', $project->id)->whereNotNull('caption')->where('caption', '<>', '')->whereNotNull('url')->where('url', '<>', '')->orderBy('num')->orderBy('id')->get();
        else
            $materialItems = App(Material::class)->where('project_id', $project->id)->whereNotNull('caption')->where('caption', '<>', '')->whereNotNull('url')->where('url', '<>', '')->where('for_accepted', 0)->orderBy('num')->orderBy('id')->get();
        if(count($materialItems)>0){
            $res .= view('/project/projectMaterials', [
                'project' => $project,
                'materialItems' => $materialItems,
            ])->render();
        }

        if($project->status >= App(Project::class)->getStatusId('ended') && $user && $projectUser && $projectUser->status == 1){
            if($projectUser->certificate_active && $projectUser->certificate_id){
                $cert = App(Certificate::class)->find($projectUser->certificate_id);
                if($cert){
                    $res .= view('/project/projectCertificate', [
                        'cert' => $cert,
                        'project' => $project,
                    ])->render();
                }
            }
        }

        $res .= $this->getContentRegister($project, $user, $projectUser);

        if($user && $projectUser && $projectUser->status == 1){
            $photoItems = App(Photo::class)->where('project_id', $project->id)->orderBy('num')->orderBy('id')->get();
            if($project->photo_user_upload_allow || count($photoItems)>0)
                $res .= view('/project/projectPhotos', [
                    'project' => $project,
                    'photoItems' => $photoItems,
                ])->render();
        }

        return $res;
    }
    
    public function getContentRegister(&$project, &$user, &$projectUser)
    {
        if(isset($projectUser) && $projectUser){
            if($project->status < App(Project::class)->getStatusId('closed'))
                return view('/project/projectRegisterMyRequest', [
                    'project' => $project,
                    'user' => $user,
                    'projectUser' => $projectUser,
                ])->render();
        }
        else
        {

            if($project->status == App(Project::class)->getStatusId('created') || $project->status == App(Project::class)->getStatusId('opened')){
                return view('/project/projectRegisterNotOpened', [
                    'project' => $project,
                ])->render();
            }
            if($project->status == App(Project::class)->getStatusId('registration')){
                if($user)
                    return view('/project/projectRegisterFormAuth', [
                        'project' => $project,
                        'user' => $user,
                    ])->render();
                else
                    return view('/project/projectRegisterFormNoAuth', [
                        'project' => $project,
                    ])->render();
            }
            if($project->status == App(Project::class)->getStatusId('fixed')){
                if($user)
                    return view('/project/projectRegisterClosedAuth', [
                        'project' => $project,
                    ])->render();
                else
                    return view('/project/projectRegisterClosedNoAuth', [
                        'project' => $project,
                    ])->render();
            }
        }
        return '';
    }
}
