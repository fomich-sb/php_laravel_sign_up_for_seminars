<?php

namespace App\Http\Controllers\Admin;

use App\Facades\Utils;
use App\Models\Certificate;
use App\Models\MailingTemplate;
use App\Models\Material;
use App\Models\Photo;
use App\Models\Place;
use App\Models\Project;
use App\Models\ProjectTamada;
use App\Models\ProjectUser;
use App\Models\User;
use App\Models\UserTag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjectController extends AdminController
{


    public function actionIndex()
    {
        return $this->actionUser();
    }
    public function actionMain()
    {
        if (request()->get('project_id')) {
            $project_id = intval(request()->get('project_id'));
            $project = App(Project::class)->findOrFail($project_id);
            return $this->actionIndexProject($project);
        } else {
            return $this->actionIndexProjectList();
        }
    }

    public function actionIndexProjectList($dataRender = [])
    {
        $projectItems = DB::select('SELECT * 
            FROM projects p 
                LEFT JOIN (SELECT project_id, SUM(IF(status=1, 1, 0) ) users_1, SUM(IF(status=0, 1, 0) ) users_0 FROM project_users GROUP BY project_id) pu ON p.id=pu.project_id
            WHERE p.deleted_at is NULL
            ORDER BY p.date_start', []);
        $dataRender['blockContent'] = view('/admin/project/projectList', [
            'projectItems' => $projectItems,
        ]);

        return $this->renderAdmin($dataRender);
    }

    public function actionIndexProject($project, $dataRender = [])
    {
        $photoItems = App(Photo::class)->where('project_id', $project->id)->orderBy('num')->orderBy('id')->get();
        $projectTamadaItems = App(ProjectTamada::class)->where('project_id', $project->id)->get()->pluck('user_id');
        $tamadaItems = App(User::class)->where('tamada', 1)->orWhereIn('id', $projectTamadaItems)->get();
        $materialItems = App(Material::class)->where('project_id', $project->id)->orderBy('num')->orderBy('id')->get();

        $dataRender['blockContent'] = view(
            config('projectCode') . '/admin/project/projectCard',
            [
                'project' => $project,
                'placeItems' => App(Place::class)->all(),
                'projectTamadaItems' => $projectTamadaItems,
                'tamadaItems' => $tamadaItems,
                'photoItems' => $photoItems,
                'materialItems' => $materialItems,
            ],
        );
        $dataRender['project'] =  $project;
        
        return $this->renderAdmin($dataRender);
    }

    public function actionSave()
    {
        $projectId = intval(request()->get('projectId'));
        $project = App(Project::class)->findOrFail($projectId);
        if(request()->get('caption') !== null)
            $project->caption = request()->get('caption');
        if(request()->get('status') !== null)
            $project->status = intval(request()->get('status'));
        if(request()->get('date_start') !== null)
            $project->date_start = request()->get('date_start');
        if(request()->get('date_end') !== null)
            $project->date_end = request()->get('date_end');
        if(request()->get('dates') !== null)
            $project->dates = request()->get('dates');
        $project->place_id = intval(request()->get('place_id'));
        if(request()->get('user_requirements') !== null)
            $project->user_requirements = request()->get('user_requirements');
        if(request()->get('time') !== null)
            $project->time = request()->get('time');
        if(request()->get('price') !== null)
            $project->price = request()->get('price');
        if(request()->get('descr') !== null)
            $project->descr = request()->get('descr');
        if(request()->get('text_for_accepted') !== null)
            $project->text_for_accepted = request()->get('text_for_accepted');
    /*    $project->telegram_group = request()->get('telegram_group');
        $project->zoom_url = request()->get('zoom_url');*/
        if(request()->get('css') !== null)
            $project->css = request()->get('css');
        if(request()->get('photo_user_upload_allow') !== null)
            $project->photo_user_upload_allow = intval(request()->get('photo_user_upload_allow'));
        if(request()->get('certificate_enabled') !== null)
            $project->certificate_enabled = intval(request()->get('certificate_enabled'));
        if(request()->get('certificate_bg') !== null)
            $project->certificate_bg = request()->get('certificate_bg');
        if(request()->get('certificate_html') !== null)
            $project->certificate_html = request()->get('certificate_html');
        if(request()->get('certificate_orientation') !== null)
            $project->certificate_orientation = intval(request()->get('certificate_orientation'));
        
        $project->save();

        $tamadaItems = request()->get('tamada_items');
        App(ProjectTamada::class)->where('project_id', $project->id)->whereNotIn('user_id', $tamadaItems)->delete();
        foreach($tamadaItems as $tamadaId)
            App(ProjectTamada::class)->updateOrCreate(['project_id' => $project->id, 'user_id' => $tamadaId], []);


        $materialDeletes = request()->get('materialDeletes');
        foreach($materialDeletes as $materialId){
            $item = App(Material::class)->find($materialId);
            if($item)
                $item->delete();
        }

        $materials = request()->get('materials');
        foreach($materials as $key=>$data)
        {
            $item = App(Material::class)->find($key);
            if($item){
                $item->caption = $data['caption'];
                $item->for_accepted = $data['for_accepted'];
                $item->type = $data['type'];
                $item->url = $data['url'];
                $item->icon = $data['icon'];
                $item->save();
            }
        }

        return $this->successResponseJSON();
    }

    
    public function actionUser()
    {
        $project_id = intval(request()->get('project_id'));
        $project = App(Project::class)->findOrFail($project_id);
        $projectUserItems = App(ProjectUser::class)->where('project_id', $project->id)->orderBy('created_at')->get();
        $userItems = App(User::class)->whereIn('id', $projectUserItems->pluck('user_id'))->get()->keyBy('id');
        $userTagItems = App(UserTag::class)->whereIn('user_id', $userItems->pluck('id'))->orderBy('tag')->get();
        $certificateItems = App(Certificate::class)->whereIn('id', $projectUserItems->pluck('certificate_id'))->get()->keyBy('id');
        $dataRender['blockContent'] = view(
            config('projectCode') . '/admin/project/projectUsers',
            [
                'project' => $project,
                'projectUserItems' => $projectUserItems,
                'userItems' => $userItems,
                'userTagItems' => $userTagItems->groupBy('user_id'),
                'tagItems' => $userTagItems->unique('tag')->pluck('tag'),
                'certificateItems' => $certificateItems,
            ],
        );
        $dataRender['project'] =  $project;
        
        return $this->renderAdmin($dataRender);
    }

    public function actionMailing()
    {
        $project_id = intval(request()->get('project_id'));
        $project = App(Project::class)->findOrFail($project_id);
        $projectUserItems = App(ProjectUser::class)->where('project_id', $project->id)->orderBy('created_at')->get()->keyBy('user_id');
        $userItems = App(User::class)->all()->keyBy('id');
        $userTagItems = App(UserTag::class)->whereIn('user_id', $userItems->pluck('id'))->orderBy('tag')->get();
        $mailingTemplateItems = App(MailingTemplate::class)->whereNotNull('caption')->where('caption', '<>', '')->get();

        $dataRender['blockContent'] = view(
            config('projectCode') . '/admin/project/projectMailing',
            [
                'project' => $project,
                'projectUserItems' => $projectUserItems,
                'userItems' => $userItems,
                'userTagItems' => $userTagItems->groupBy('user_id'),
                'tagItems' => $userTagItems->unique('tag')->pluck('tag'),
                'mailingTemplateItems' => $mailingTemplateItems,
            ],
        );
        $dataRender['project'] =  $project;
        
        return $this->renderAdmin($dataRender);
    }

   /* public function actionCreateProject()
    {
        $projectClass = $this->getModelClass();
        $project = new $projectClass();
        $project->caption = request()->get('caption');
        if (request()->get('theme_id')) {
            $project->theme_id = intval(request()->get('theme_id'));
        }
        $project->creator_id = Auth::user()->id;
        $project->tamada_url = uniqid();
        $project->checker_url = uniqid();
        
        $project->code = config('projectCode');
        $project->save();

        App(ProjectLocale::class)->setEnabledByDefault($project);

        if (method_exists($project, 'fillFromTheme'))
            $project->fillFromTheme();

        return redirect(config('projectURL') . '/admin/project?project_id=' . $project->id);
    }


    public function actionSetStatus()
    {
        $project_id = intval(request()->get('id'));
        $status = intval(request()->get('status'));
        $project = App(Utils::getModelClass('Project'))->findOrFail($project_id);

        $errors = $project->setStatus($status);
        if($errors=='')
            return $this->successResponseJSON();
        else
            return $this->errorResponseJSON($errors);
    }

    public function actionSetProjectsStatus()
    {
        $projectIds = request()->get('projectIds');
        $status = intval(request()->get('status'));
        $errors = '';
        foreach($projectIds as $projectId){
            $project = App(Utils::getModelClass('Project'))->find($projectId);
            if($project)
                $errors .= $project->setStatus($status);
        }

        if($errors=='')
            return $this->successResponseJSON();
        else
            return $this->errorResponseJSON($errors);
    }

    public function actionUploadCommonFiles()
    {
        if (request()->get('targetFolder'))
            $targetFolder = public_path(request()->get('targetFolder'));
        else
            $targetFolder = public_path(config('imagesFolder'));
        $res = Utils::loadFiles($targetFolder, intval(request()->get('file_replace'), 0));

        return $this->successResponseJSON($res);
    }

    public function actionStartTimer()
    {
        $project_id = intval(request()->get('project_id'));

        $val = intval(request()->get('val'));
        if ($val <= 0) {
            return $this->errorResponseJSON("Таймер должен быть положительным");
        }

        $project = App(Utils::getModelClass('Project'))->findOrFail($project_id);

        $project->startTimer($val);

        return $this->successResponseJSON();
    }
    public function actionStopTimer()
    {
        $project_id = intval(request()->get('project_id'));
        $val = intval(request()->get('val'));

        $project = App(Utils::getModelClass('Project'))->findOrFail($project_id);

        $project->stopTimer($val);

        return $this->successResponseJSON();
    }

    public function actionCopy()
    {
        $old_project_id = intval(request()->get('id'));
        $old_project = App(Utils::getModelClass('Project'))->findOrFail($old_project_id);
        $new_project = $old_project->copyProject();
        //$new_project->creator_id = Auth::user()->id;
        $new_project->save();
        if ($new_project->id > 0) {
            //Копирование доступных локалей


            $response['project_id'] = $new_project->id;
            return $this->successResponseJSON($response);
        }

        return $this->errorResponseJSON("Ошибка копирования игры");
    }

    public function getModelClass()
    {
        return Utils::getModelClass('Project');
    }*/

    public function actionSetImage()
    {
        $curUser = Auth::user();
        $projectId = intval(request()->get('projectId'));

        $res = Utils::loadImage('certificates', 300, 4096);
        if(count($res['errors'])>0)
            return $this->errorResponseJSON($res['errors'][0]);
        
        if(count($res['files'])>0)
            $response = ['image' => $res['files'][0]['fileName']];
        return $this->successResponseJSON($response);
    }
    
    public function getModelClass()
    {
        return Project::class;
    }
}
