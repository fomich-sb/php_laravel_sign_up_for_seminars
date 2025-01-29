<div class='cardRoot userCardRoot userCardRoot<?=$user->id?>'>
    <div class='cardHeader'><?=$user->name1?> <?=$user->name2?> <?=$user->name3?></div>
    <div class='cardContent userCardContent'>
        <?php if($user->image): ?>
            <div class='projectTamadaPhoto' style='background-image: url(<?=config('app.uploadImageFolder')?>/avatars/thumbs/<?=$user->image?>)'></div>
        <?php endif; ?>
        <section><?=$user->descr?></section>
</div>
