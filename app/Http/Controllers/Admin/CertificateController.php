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
        $certificateItems = DB::select('SELECT c.id, c.num, c.url, pu.user_id, pu.project_id, pu.certificate_active, p.caption project_caption, u.phone, u.name1, u.name2, u.name3 
        FROM certificates c
            LEFT JOIN project_users pu ON pu.id=c.project_user_id
            LEFT JOIN projects p ON p.id=pu.project_id
            LEFT JOIN users u ON u.id=pu.user_id
        WHERE c.deleted_at IS NULL');


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
        $certificateOrientation = request()->get('certificate_orientation');
        
        
        $user = Auth::user();
        $response['content'] = App(Certificate::class)->generateContent($project, $user, null, [
            'certificateBg' => $certificateBg,
            'certificateHtml' => $certificateHtml,
            'certificateOrientation' => $certificateOrientation,
        ]);
        return $this->successResponseJSON($response);
    }

    public function actionSetActive()
    {
        $projectUserId = intval(request()->get('projectUserId'));
        $projectUser = App(ProjectUser::class)->findOrFail($projectUserId);
        $active = intval(request()->get('active'));
        $projectUser->certificate_active = $active;
        $certificate = null;
        if($projectUser->certificate_id)
            $certificate = App(Certificate::class)->find($projectUser->certificate_id);

        if($active)
        {

            if(!$certificate)
            {
                $certificate = App(Certificate::class)->create($projectUser);
                $response['num'] = $certificate->num;
            } 
        }
        if($certificate)
            $projectUser->save(); 

        $certificate->generate();
        $response['active'] = $active;
        return $this->successResponseJSON($response);
    }

    public function actionRecreate()
    {
        $projectId = intval(request()->get('projectId'));
        $projectUserItems = App(ProjectUser::class)->where('project_id', $projectId)->get();
        $certificateItems = App(Certificate::class)->whereIn('id', $projectUserItems->pluck('certificate_id'))->get();
        foreach($certificateItems as $cert)
            $cert->recreate();
            
        return $this->successResponseJSON();
    }
    

    public function getModelClass()
    {
        return Certificate::class;
    }
   
}
