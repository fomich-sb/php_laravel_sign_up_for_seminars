<?php
use Illuminate\Support\Facades\Auth;
$user=Auth::user();
?>

<div class='photoViewerRoot photoViewer<?=$type?><?=$id?>'>
    <div class='photoViewerContent'>
        <?php foreach($photoItems as $photo): ?>
            <div class='photoDiv photoDiv<?= $photo->id ?>' style='background-image: url("<?=config('app.uploadImageFolder')?>/photos/thumbs/<?=$photo->file?>")'onclick='openPhotoSlider("photoViewer<?=$type?><?=$id?>", <?= $photo->id ?>)' data-id='<?=$photo->id?>' data-img='<?=config('app.uploadImageFolder')?>/photos/<?=$photo->file?>'>

                <?php if($user && ($user->admin || $user->id==$photo->creator_id)): ?>
                    <div class='photoDeleteButton button buttonSmall' onclick='deletePhoto(<?= $photo->id ?>)'><div class='buttonDeleteIcon'></div></div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div class='photoViewerUploadForm'>
        <?php if(isset($add) && $add): ?>
            <br>
            Добавить фотографии:
            <input type="file" name="files" accept="image/*" multiple>
            <div class='button' onclick='uploadPhotos("<?=$type?>", "<?=$id?>", this)'>Загрузить</div>
            <div class='photoViewerUploadResult'></div>
        <?php endif;?>
    </div>
</div>