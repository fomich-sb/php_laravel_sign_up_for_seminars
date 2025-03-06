
<div class='projectContentDescriptionRoot projectContentSector'>
    <div class='projectCaption'><?= $project->caption ?></div>
    <div class='projectDate'><?= $project->dates ?></div>
    <?php if($project->user_requirements && strlen($project->user_requirements)>0): ?>
        <div class='projectSectionCaption projectSectionCaptionUserRequirements'>Для кого</div>
        <section class='projectUserRequirements'><?= $project->user_requirements ?></section>
    <?php endif; ?>
    <?php if($place): ?>
        <div class='projectSectionCaption projectSectionCaptionPlace'>Место</div>
        <section class='projectPlace'>
            <div class='projectPlaceCaption clickableDiv' onclick='openModalWindowAndLoadContent("/place/getCardContent", {"placeId": <?=$place->id?>});'><?= $place->caption ?></div>
            <div class='projectPlaceAddress'><?= $place->address ?></div>
        </section>
    <?php endif; ?>
    <?php if($project->time && strlen($project->time)>0): ?>
        <div class='projectSectionCaption projectSectionCaptionTime'>Время</div>
        <section class='projectTime'><?= $project->time ?></section>
    <?php endif; ?>
    <?php if($project->descr && strlen($project->descr)>0): ?>
        <div class='projectSectionCaption projectSectionCaptionDescr'>Описание</div>
        <section class='projectDescr'><?= $project->descr ?></section>
    <?php endif; ?>
    <?php if(count($tamadaItems)>0): ?>
        <div class='projectSectionCaption projectSectionCaptionTamada'>Ведущие</div>
        <section class='projectTamadas'>
            <?php foreach($tamadaItems as $user): ?>
                <div class='projectTamada clickableDiv'  onclick='openModalWindowAndLoadContent("/user/getCardContent", {"userId": <?=$user->id?>});'>
                    <div class='projectTamadaPhoto' style='<?= $user->image ? 'background-image: url('.config('app.uploadImageFolder').'/avatars/thumbs/'.$user->image : '' ?>)'></div>
                    <div class='projectTamadaCaption'><?=$user->name1?> <?=$user->name2?> <?=$user->name3?></div>
                </div>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>
    <?php if($project->price && strlen($project->price)>0): ?>
        <div class='projectSectionCaption projectSectionCaptionPrice'>Стоимость</div>
        <section class='projectPrice'><?= $project->price ?></section>
    <?php endif; ?>

    <div class='projectContentDescriptionButtons'>
        <div class='mainButton projectContentDescriptionButtonRegister' style='display:none;'>Подать заявку</div>
        <div class='mainButton projectContentDescriptionButtonMaterials' style='display:none;'>Материалы встречи</div>
    </div>
</div>

