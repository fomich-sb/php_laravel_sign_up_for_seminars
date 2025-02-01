<div class='projectContentSector'>
    <div class='projectCaption'>Сертификаты</div>
    <table class='adminTable certificateTable' cellspacing='0' cellpadding='0' style='width: 90%;table-layout: fixed;'>
        <thead>
            <tr>
                <th style='width: 3em;'>Ном</th>
                <th style='width: 5em;'>Сост</th>
                <th>Проект</th>
                <th>Участник</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($certificateItems as $certificate): ?>
                <tr class='certificateTr<?=$certificate->id?> <?=$certificate->certificate_active ? "" : "certificateTrDisactive"?>'>
                    <td class='certificateNum clickableDiv' onclick='getCertificate("<?=$certificate->url?>")'><?=$certificate->num?></td>
                    <td class='certificateStatus'><?=$certificate->certificate_active ? 'Действ' : 'Аннул'?></td>
                    <td class='certificateProject'><div><a href="/admin/project?project_id=<?=$certificate->project_id?>"><?=$certificate->project_caption?></a></div></td>
                    <td class='certificateUser clickableDiv' onclick='openModalWindowAndLoadContent("/user/getCardEditContent", {"userId": <?=$certificate->user_id?>, "projectId": <?=$certificate->project_id?>});' title="+<?=$certificate->phone . ' ' . $certificate->name1 . ' ' . $certificate->name2 . ' ' . $certificate->name3?>"><div><?=strlen($certificate->name1 . $certificate->name2 . $certificate->name3)>0 ? $certificate->name1 . ' ' . $certificate->name2 . ' ' . $certificate->name3 : '+'.$certificate->phone?></div></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class='button' onclick='addElement("/admin/certificate/add", null, null, 1, true, null)'>Добавить</div>
</div>

<style>
    .certificateTrDisactive{
        opacity: 0.7;
        background: #FBB;
    }
    .certificateStatus, .certificateNum{
        text-align: center;
    }
    .certificateProject div, .certificateUser div{
        overflow: hidden;
        white-space: nowrap;
        font-size: 0.8em;
    }
</style>