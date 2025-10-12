<div class='projectMaterialsRoot projectContentSector' id='materials'>
    <div class='projectContentCaption projectContentMaterialsCaption'>Материалы</div>
    <div class='projectContentMaterialsRoot'>
        <?php foreach($materialItems as $material): ?>
            <div class='projectContentMaterialDiv' style=''>
                <a href='<?=$material->type==1 ? config('app.uploadMaterialFolder').'/'.$material->id.'/' : ''?><?=$material->url?>' target='_blank'>
                    <div class='projectContentMaterialIcon' style='
                    <?php if($material->icon && strlen($material->icon)>2): ?>-webkit-mask-image: url(/uploads/images/icons/<?=$material->icon?>);    mask-image: url(/uploads/images/icons/<?=$material->icon?>);
                    <?php endif; ?>
                    '></div><?=$material->caption?>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>