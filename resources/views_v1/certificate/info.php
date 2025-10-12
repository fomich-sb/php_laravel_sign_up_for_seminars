<div class='certificateRoot certificateContentSector'>
    <div class='formFieldRoot'>
        <div class='formFieldCaption'>Номер сертификата:</div>
        <div class='formFieldInput'>
            <?=$certificate->num?>
        </div>
    </div>
    <div class='formFieldRoot'>
        <div class='formFieldCaption'>Состояние:</div>
        <div class='formFieldInput'>
            <?=($projectUser->status == 1 && $projectUser->certificate_active) ? 'Действующий' : '<span style="color:red; font-weight:bold;">Аннулирован</span>' ?>
        </div>
    </div>
    <div class='formFieldRoot'>
        <div class='formFieldCaption'>Участник:</div>
        <div class='formFieldInput'>
            <?=$certificateUser->name1?> <?=$certificateUser->name2?> <?=$certificateUser->name3?>
        </div>
    </div>
    <div class='formFieldRoot'>
        <div class='formFieldCaption'>Проект:</div>
        <div class='formFieldInput'>
            <a href='/?id=<?=$projectUser->project_id?>'><?=$certificateProject->caption?></a>
        </div>
    </div>
    <div class="projectContentCertificateRoot">
    <img class='projectContentCertificateImg' onclick='getCertificate("<?=$certificate->url?>")' src='<?=
            file_exists(public_path("certificates") . '/thumbs/' . $certificate->url . ".png") ?
                '/certificates/thumbs/' . $certificate->url . ".png" :
                ($certificateProject->certificate_bg && file_exists(public_path(config('app.uploadImageFolder')).'/certificates/thumbs/' . $certificateProject->certificate_bg) ?
                    config('app.uploadImageFolder'). '/certificates/thumbs/' . $certificateProject->certificate_bg :
                    '/themes/default/no_certificate.png')
            ?>'>
    </div>
</div>