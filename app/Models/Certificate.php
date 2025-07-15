<?php
namespace App\Models;

use App\Facades\Utils;
use App\Models\BaseGameModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\DB;

class Certificate extends BaseGameModel
{
    protected  $table='certificates';
    public $timestamps = false;
    protected $guarded = [];
    use SoftDeletes;

    public function generateContent(&$project, &$user, $projectUser=null, $params=null) {
        $certificateBg = isset($params['certificateBg']) ? $params['certificateBg'] : $project->certificate_bg;
        $certificateHtml = isset($params['certificateHtml']) ? $params['certificateHtml'] : $project->certificate_html;
        $certificateOrientation = isset($params['certificateOrientation']) ? $params['certificateOrientation'] : $project->certificate_orientation;
        if(isset($this->id))
            $certificate = $this;
        else {
            $certificate = new Certificate();
            $certificate->num = '###';
        }
        $certificateHtml = Utils::prepareText($certificateHtml, ['certificate' => $certificate, 'project' => $project, 'user' => $user, ]);

        return view('certificateContent', [
            'project' => $project, 
            'user' => $user, 
            'certificateBg' => $certificateBg, 
            'certificateHtml' => $certificateHtml,
            'certificateOrientation' => $certificateOrientation,
            'active' => !$projectUser || $projectUser->status == 1 && $projectUser->certificate_active==1 ? 1 : 0,
        ])->render();
    }

    public function create(&$projectUser)
    {
        $cert = new Certificate();
        $cert->project_user_id = $projectUser->id;
        $cert->url = \Illuminate\Support\Str::uuid();
        $cert->num = App(Certificate::class)->selectRaw('IFNULL(MAX(num),0) as num')->first()->num + 1;
        $cert->save();
        $cert->fresh();
        return $cert;
    }
    
    public function generate()
    {
        $projectUser = App(ProjectUser::class)->findOrFail($this->project_user_id);
        $project = App(Project::class)->findOrFail($projectUser->project_id);
        $user = App(User::class)->findOrFail($projectUser->user_id);

        $options = new Options();
        $options->set('defaultFont', 'Courier');
        $options->set('isRemoteEnabled', TRUE);
        $options->set('chroot', public_path());
        
        $options->set('dpi', 300);
        $dompdf = new Dompdf($options);

        $dompdf->setBasePath(public_path());
        $content = view('certificate', [
            'project' => $project,
            'content' => $this->generateContent($project, $user, $projectUser)
        ])->render();
        $dompdf->loadHtml($content);
        
        $dompdf->setPaper('A4', $project->certificate_orientation ? 'portrait' : 'landscape');

        ini_set('memory_limit', '8192M');

        $dompdf->render();
        file_put_contents(public_path("certificates") . '/' . $this->url . ".pdf", $dompdf->output());

        $this->generateThumb();

        return;
    }

    public function generateThumb()
    {
        try{     
             $imagick = new \Imagick();
             $imagick->readImage(public_path("certificates") . '/' . $this->url . ".pdf");
             $imagick->writeImages(public_path("certificates") . '/thumbs/' . $this->url . ".png", false);
        }
        catch(\Exception $e)
        {}

        return;
    }

    public function getAllCertificateList() 
    {
        return DB::select('SELECT c.id, c.num, c.url, pu.user_id, pu.project_id, pu.status, pu.certificate_active, p.caption project_caption, u.phone, u.name1, u.name2, u.name3 
        FROM certificates c
            LEFT JOIN project_users pu ON pu.id=c.project_user_id
            LEFT JOIN projects p ON p.id=pu.project_id
            LEFT JOIN users u ON u.id=pu.user_id
        WHERE c.deleted_at IS NULL');
    }

    public function recreate()
    {
        if(file_exists(public_path('certificates') . '/' . $this->url . ".pdf"))
            unlink(public_path('certificates') . '/' . $this->url . ".pdf");
        if(file_exists(public_path('certificates') . '/thumbs/' . $this->url . ".png"))
            unlink(public_path('certificates') . '/thumbs/' . $this->url . ".png");
    }
}