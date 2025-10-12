<div class='projectContentSector'>
    <div class='projectCaption'>Места / центры</div>
    <table class='adminTable placeTable' cellspacing='0' cellpadding='0'>
        <thead>
            <tr>
                <th>Код</th>
                <th>Название</th>
                <th>Адрес</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($placeItems as $place): ?>
                <tr class='placeTr<?=$place->id?>'>
                    <td class='placeCode clickableDiv' onclick='openModalWindowAndLoadContent("/admin/place/getCardContent", {"placeId": <?=$place->id?>});'><?=$place->code?></td>
                    <td class='placeCaption'><?=$place->caption?></td>
                    <td class='placeAddress'><?=$place->address?></td>
                    <td>
                        <div class='button buttonDelete buttonSmall' onclick='deleteElement("/admin/place/delete", <?=$place->id?>, 1)'>
                            <div class='buttonDeleteIcon'></div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class='button' onclick='addElement("/admin/place/add", null, null, 1, true, null)'>Добавить</div>
</div>
