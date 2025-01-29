<div class='projectCertificateRoot projectContentSector' id='certificate'>
    <div class='projectContentCertificateCaption'>Сертификат участника</div>
    <div class='projectContentCertificateRoot'>
        <img class='projectContentCertificateImg' onclick='getCertificate("<?=$cert->url?>")' src='<?=
            file_exists(public_path("certificates") . '/thumbs/' . $cert->url . ".png") ?
                public_path("certificates") . '/thumbs/' . $cert->url . ".png" :
                '/themes/default/no_certificate.png'
            ?>'>
    </div>
</div>
