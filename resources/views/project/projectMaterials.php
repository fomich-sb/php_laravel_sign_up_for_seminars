<div class='projectMaterialsRoot projectContentSector' id='materials'>
    <div class='projectContentMaterialsCaption'>Материалы</div>
    <div class='projectContentMaterialsRoot'>
        <?php foreach($materialItems as $material): ?>
            <div class='projectContentMaterialDiv'>
                <a href='<?=$material->type==1 ? config('app.uploadMaterialFolder').'/'.$material->id.'/' : ''?><?=$material->url?>' target='_blank'>
                    <?=$material->caption?>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>