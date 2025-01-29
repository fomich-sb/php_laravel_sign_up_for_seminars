<?php

namespace App\Http\Controllers\Admin;

use App\Facades\Utils;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MainController extends AdminController
{


    public function actionIndex()
    {
        return App(ProjectController::class)->actionIndexProjectList();
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
}
