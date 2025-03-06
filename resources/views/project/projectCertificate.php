<div class='projectCertificateRoot projectContentSector' id='certificate'>
    <div class='projectContentCaption projectContentCertificateCaption'>Сертификат участника</div>
    <div class='projectContentCertificateRoot'>
        <img class='projectContentCertificateImg' onclick='getCertificate("<?=$cert->url?>")' src='<?=
            file_exists(public_path("certificates") . '/thumbs/' . $cert->url . ".png") ?
                '/certificates/thumbs/' . $cert->url . ".png" :
                ($project->certificate_bg && file_exists(public_path(config('app.uploadImageFolder')).'/certificates/thumbs/' . $project->certificate_bg) ?
                    config('app.uploadImageFolder'). '/certificates/thumbs/' . $project->certificate_bg :
                    '/themes/default/no_certificate.png')

            ?>'>
    </div>
</div>
