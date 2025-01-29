<div class='projectContentSector'>
    <div class='projectCaption'>Места / центры</div>
    <table class='adminTable placeTable' cellspacing='0' cellpadding='0'>
        <thead>
            <tr>
                <th>Код</th>
                <th>Название</th>
                <th>Адрес</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($placeItems as $place): ?>
                <tr class='placeTr<?=$place->id?>'>
                    <td class='placeCode clickableDiv' onclick='openModalWindowAndLoadContent("/admin/place/getCardContent", {"placeId": <?=$place->id?>});'><?=$place->code?></td>
                    <td class='placeCaption'><?=$place->caption?></td>
                    <td class='placeAddress'><?=$place->address?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class='button' onclick='addElement("/admin/place/add", null, null, 1, true, null)'>Добавить</div>
</div>
