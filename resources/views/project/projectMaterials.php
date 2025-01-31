<div class='projectMaterialsRoot projectContentSector' id='materials'>
    <div class='projectContentMaterialsCaption'>Материалы</div>
    <div class='projectContentMaterialsRoot'>
        <div class='projectContentMaterialsTextForAccepted'>
            <?=$project->text_for_accepted?>
        </div>
        <?php if($project->telegram_group && strlen($project->telegram_group)>0): ?>
            <div class='formFieldRoot'>
                <div class='formFieldCaption'>Группа Telegram</div>
                <div class='formFieldInput'><a href='<?=$project->telegram_group?>' target='_blank'><?=$project->telegram_group?></a></div>
            </div>
        <?php endif; ?>
        <?php if($project->zoom_url && strlen($project->zoom_url)>0): ?>
            <div class='formFieldRoot'>
                <div class='formFieldCaption'>Ссылка на видеоконференцию</div>
                <div class='formFieldInput'><a href='<?=$project->zoom_url?>' target='_blank'><?=$project->zoom_url?></a></div>
            </div>
        <?php endif; ?>
    </div>
</div>