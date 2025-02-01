<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Facades\Utils;
use App\Models\Certificate;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function actionIndex()
    {        
        $user = Auth::user();
        $projectItems = App(Project::class)->getActual();
        $currentProjectId = $projectItems[0]->id;


        $dataRender = [
            'bodyClass' => 'bodyMain',
            'projectItems' => $projectItems,
            'currentProjectId' => $currentProjectId,
            'user' => $user,
        ];
        $url = request()->get('uuid');
        $certificate = App(Certificate::class)->where('url', $url)->first();
        if(!$certificate){
            $dataRender['projectContent'] = view('certificate/notFound', []);
            $dataRender['blockContent'] = view('main/index', $dataRender);
            return view('/layouts/main', $dataRender);
        }
        $projectUser = App(ProjectUser::class)->where('id', $certificate->project_user_id)->first();
        if(!$projectUser){
            $dataRender['projectContent'] = view('certificate/notFound', []);
            $dataRender['blockContent'] = view('main/index', $dataRender);
            return view('/layouts/main', $dataRender);
        }
        
        $project = App(Project::class)->where('id', $projectUser->project_id)->first();
        $user = App(User::class)->where('id', $projectUser->user_id)->first();

        $dataRender['certificate'] = $certificate;
        $dataRender['projectUser'] = $projectUser;
        $dataRender['certificateProject'] = $project;
        $dataRender['certificateUser'] = $project;

        $dataRender['projectContent'] = view('certificate/info', $dataRender);
        $dataRender['blockContent'] = view('main/index', $dataRender);
        return view('/layouts/main', $dataRender);

    }

    public function actionFile()
    {
        $url = intval(request()->get('uuid'));
        $certificate = App(Certificate::class)->where('url', $url)->first();
        if(!$certificate)
            return $this->errorResponseJSON('Документ не найден');

        $certPath = public_path("certificates") . '/' . $certificate->url . ".pdf";
        if(!file_exists($certPath))
            $cert = $certificate->generate();
        else {
            $certPathThumb = public_path("certificates") . '/thumbs/' . $certificate->url . ".pdf";
            if(!file_exists($certPathThumb))
                $certificate->generateThumb();
        }

        if(file_exists($certPath)){
            header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
            header("Cache-Control: public"); // needed for internet explorer
            header("Content-Type: application/octet-stream");
            //header("Content-Transfer-Encoding: Binary");
            header("Content-Length:".filesize($certPath));
            header("Content-Disposition: attachment; filename=". urlencode("Сертификат") . ' ' . $certificate->num . ".pdf");
            readfile($certPath);
            die();
        }

        return $this->errorResponseJSON('Ошибка формирования документа');
    }
    
}
