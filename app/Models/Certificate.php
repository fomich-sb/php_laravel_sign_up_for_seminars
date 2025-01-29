<?php
namespace App\Models;

use App\Models\BaseGameModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dompdf\Dompdf;
use Dompdf\Options;

class Certificate extends BaseGameModel
{
    protected  $table='certificates';
    public $timestamps = false;
    protected $guarded = [];
    use SoftDeletes;

    public function generateContent($project, $user, $params=null) {
        $res = '';
        $certificateBg = isset($params['certificateBg']) ? $params['certificateBg'] : $project->certificate_bg;
        $certificateHtml = isset($params['certificateHtml']) ? $params['certificateHtml'] : $project->certificate_html;

        $pattern = '/{{[^}]*}}/';
        preg_match_all($pattern, $certificateHtml, $matches);
        foreach($matches[0] as $var){
            $prop = trim(str_replace('}}', '', str_replace('{{', '', $var)));

            if(in_array($var, ['password']))
                continue;
    
            /*if($prop == 'login_url'){    
                $url = $rootURL . '/cabinet/project?code=' . $project->code . '&login_url=' . $user->login_url;
                $url = '<a href="' . $url . '"> ' . $url . '</a>';
                $certificateHtml = str_replace($var, $url, $certificateHtml);
            }
            else*/if(str_contains($prop, 'user_')){
                $prop2 = substr($prop, 5);
                $certificateHtml = str_replace($var, $user->$prop2 ? $user->$prop2 : '', $certificateHtml);
            }
            elseif(str_contains($prop, 'project_')){
                $prop2 = substr($prop, 8);
                $certificateHtml = str_replace($var, $project->$prop2 ? $project->$prop2 : '', $certificateHtml);
            }
            else
                $certificateHtml = str_replace($var, '', $certificateHtml);
        }

        return view('certificateContent', [
            'project' => $project, 
            'user' => $user, 
            'certificateBg' => $certificateBg, 
            'certificateHtml' => $certificateHtml,
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
        $projectUser->certificate_id = $cert->id;
        $projectUser->save();
        return $cert;
    }
    
    public function generate()
    {
        $projectUser = App(ProjectUser::class)->findOrFail($this->project_user_id);
        $project = App(Project::class)->findOrFail($projectUser->project_id);
        $user = App(User::class)->findOrFail($projectUser->user_id);

        $rootURL = route('root');

        $options = new Options();
        $options->set('defaultFont', 'Courier');
        $options->set('isRemoteEnabled', TRUE);
        $options->set('chroot', public_path());
        
        $options->set('dpi', 300);
        $dompdf = new Dompdf($options);

        $dompdf->setBasePath(public_path());
        $content = view('certificate', [
            'project' => $project,
            'content' => $this->generateContent($project, $user)
        ])->render();
        $dompdf->loadHtml($content);
        
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', $project->certificate_orientation ? 'portrait' : 'landscape');

        ini_set('memory_limit', '8192M');

        // Render the HTML as PDF
        $dompdf->render();
        file_put_contents(public_path("certificates") . '/' . $this->url . ".pdf", $dompdf->output());

        $this->generateThumb();

        return;
    }

    public function generateThumb()
    {
        try{
        //sudo apt install php-imagick
        /*     $pdfPath = $request->file('pdf')->path();
     
             $imagick = new Imagick();
             $imagick->readImage($pdfPath . '[0]'); // Convert the first page of the PDF
     
             $imagick->setImageFormat('png'); // Set the output format, you can change it as needed
     
             $imagePath = public_path('images/') . 'converted_image.png'; // Define the output image path
             $imagick->writeImage($imagePath);
             $imagick->clear();*/
     
             $imagick = new Imagick();
             $imagick->readImage(public_path("certificates") . '/' . $this->url . ".pdf");
             $imagick->writeImages(public_path("certificates") . '/thumbs/' . $this->url . ".png", false);
        }
        catch(\Exception $e)
        {}

        return;
    }
}