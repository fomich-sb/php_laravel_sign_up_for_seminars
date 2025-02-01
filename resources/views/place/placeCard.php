<div class='cardRoot placeCardRoot placeCardRoot<?=$place->id?>'>
    <div class='cardHeader'>
        <?=$place->caption?>
        <div style='font-size:0.8em; opacity:0.8;'><?=$place->address?> 
            <?php if($place->map_link && strlen($place->map_link)>0): ?>
                <a class='mapLink' href='<?=$place->map_link?>' target='_blank' title="Открыть на карте"></a>
            <?php endif; ?>
        </div>

    </div>
    <div class='cardContent placeCardContent'>
        <div>
            <section><?=$place->descr?></section>
        </div>

        <section class='photosRoot'>
            <?=view('/photoViewer', ['photoItems' => $photoItems, 'add' => false, 'type' => 'place', 'id' => $place->id])?>
        </section>
    </div>
</div>