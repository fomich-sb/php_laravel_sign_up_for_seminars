<div class='projectContentSector'>
    <div class='projectCaption'>Все проекты</div>
    <table class='adminTable' cellspacing='0' cellpadding='0'>
        <thead>
            <tr>
                <th rowspan='2'>Название</th>
                <th rowspan='2'>Статус</th>
                <th colspan='2'>Даты</th>
                <th colspan='2'>Кол-во участников</th>
                <th rowspan='2'></th>
            </tr>
            <tr>
                <th>с</th>
                <th>по</th>
                <th>подтверждено</th>
                <th>на рассмотрении</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($projectItems as $project): ?>
                <tr>
                    <td style='cursor:pointer;' onclick='document.location.href = "/admin/project?project_id=<?=$project->id?>"'><a href='/admin/project?project_id=<?=$project->id?>'><?=$project->caption?></a></td>
                    <td style='text-align: center;'><?=App(App\Models\Project::class)->getStatusById($project->status)['caption']?></td>
                    <td style='text-align: center;'><?=$project->date_start?></td>
                    <td style='text-align: center;'><?=$project->date_end?></td>
                    <td style='text-align: center;'><?=$project->users_1?></td>
                    <td style='text-align: center;'><?=$project->users_0?></td>
                    <td>
                        <div class='button buttonDelete buttonSmall' onclick='deleteElement("/admin/project/delete", <?=$project->id?>, 1)'>
                            <div class='buttonDeleteIcon'></div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class='button' onclick='addElement("/admin/project/add", null, null, 1, true, null)'>Добавить</div>
</div>