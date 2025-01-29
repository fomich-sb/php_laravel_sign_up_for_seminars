<div class='projectMaterialsRoot projectContentSector' id='materials'>
    <div class='projectContentMaterialsCaption'>Материалы</div>
    <div class='projectContentMaterialsRoot'>
        <div class='projectContentMaterialsTextForAccepted'>
            <?=$project->text_for_accepted?>
        </div>
        <div class='formFieldRoot'>
            <div class='formFieldCaption'>Группа Telegram</div>
            <div class='formFieldInput'><a href='<?=$project->telegram_group?>' target='_blank'><?=$project->telegram_group?></a></div>
        </div>
        <div class='formFieldRoot'>
            <div class='formFieldCaption'>Ссылка на видеоконференцию</div>
            <div class='formFieldInput'><a href='<?=$project->zoom_url?>' target='_blank'><?=$project->zoom_url?></a></div>
        </div>
    </div>
</div>