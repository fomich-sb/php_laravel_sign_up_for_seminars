<?php

namespace App\Http\Controllers\Admin;

use App\Facades\Utils;
use App\Models\Photo;
use App\Models\Certificate;
use App\Models\Project;
use App\Models\ProjectUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CertificateController extends AdminController
{

    public function actionIndex()
    {
        if (request()->get('certificate_id')) {
       /*     $certificate_id = intval(request()->get('certificate_id'));
            $certificate = App(Certificate::class)->findOrFail($certificate_id);
            return $this->actionIndexCertificate($certificate);*/
        } else {
            return $this->actionIndexCertificateList();
        }
    }

    public function actionIndexCertificateList($dataRender = [])
    {
        $certificateItems = App(Certificate::class)->all();

        $dataRender['blockContent'] = view('/admin/certificate/certificateList', [
            'certificateItems' => $certificateItems,
        ]);
        return $this->renderAdmin($dataRender);
    }

    public function actionGetPreviewContent()
    {
        $projectId = intval(request()->get('projectId'));
        $project = App(Project::class)->findOrFail($projectId);
        $certificateBg = request()->get('certificate_bg');
        $certificateHtml = request()->get('certificate_html');
        

        $response['content'] = App(Certificate::class)->generateContent($project, Auth::user(), [
            'certificateBg' => $certificateBg,
            'certificateHtml' => $certificateHtml,
        ]);
        return $this->successResponseJSON($response);
    }

    public function actionSetActive()
    {
        $projectUserId = intval(request()->get('projectUserId'));
        $projectUser = App(ProjectUser::class)->findOrFail($projectUserId);
        $active = intval(request()->get('active'));
        $projectUser->certificate_active = $active;
        if($active && !$projectUser->certificate_id){
            $cert = App(Certificate::class)->create($projectUser);
            $response['num'] = $cert->num;
        }
        $projectUser->save();   
        $response['active'] = $active;
        return $this->successResponseJSON($response);
    }

    public function get()
    {

    }
    

    public function getModelClass()
    {
        return Certificate::class;
    }
   
}
