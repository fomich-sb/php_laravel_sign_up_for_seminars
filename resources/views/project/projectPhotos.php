<div class='projectPhotosRoot projectContentSector' id='photos'>
    <div class='projectContentPhotosCaption'>Фотографии</div>
    <div class='projectContentPhotosRoot'>
        <section class='photosRoot'>
            <?=view('/photoViewer', ['photoItems' => $photoItems, 'add' => false, 'add' => $project->photo_user_upload_allow, 'type' => 'project', 'id' => $project->id])?>
        </section>
    </div>
</div>
