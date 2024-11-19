
<div class='projectContentDescriptionRoot'>
    <div class='projectCaption'><?= $project->caption ?></div>
    <div class='projectDate'><?= $project->date_start ?> - <?= $project->date_end ?></div>
    <div class='projectSectionCaption projectSectionCaptionPlace'>Место</div>
    <section class='projectPlace'><?= $project->place ?></section>
    <div class='projectSectionCaption projectSectionCaptionTime'>Время</div>
    <section class='projectTime'><?= $project->time ?></section>
    <div class='projectSectionCaption projectSectionCaptionDescr'>Описание</div>
    <section class='projectDescr'><?= $project->descr ?></section>
</div>

