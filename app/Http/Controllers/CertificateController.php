<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Facades\Utils;
use App\Models\Certificate;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{

    public function actionIndex()
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
