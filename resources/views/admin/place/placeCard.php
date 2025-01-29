<div class='cardRoot placeCardRoot placeCardRoot<?=$place->id?>'>
    <div class='cardHeader'><?=$place->caption?></div>
    <div class='cardContent placeCardContent'>
        <div class='formFieldRoot'>
            <div class='formFieldCaption'>Код</div>
            <div class='formFieldInput'><input name="code" class="placeCardCode" value="<?=$place->code?>"/></div>
        </div>
        <div class='formFieldRoot'>
            <div class='formFieldCaption'>Название</div>
            <div class='formFieldInput'><input name="caption" class="placeCardCaption"value="<?=$place->caption?>" /></div>
        </div>

        <div class='formFieldRoot'>
            <div class='formFieldCaption'>Адрес</div>
            <div class='formFieldInput'><input name="address" class="placeCardAddress" value="<?=$place->address?>" /></div>
        </div>
        <div class='formFieldRoot'>
            <div class='formFieldCaption'>Описание</div>
        </div>
        <div>
            <textarea class='textareaHtml' name="descr" id='descr' onchange222="onChangeFieldForm($('.placeCardRoot'))"><?=$place->descr?></textarea>
        </div>
        <div class='formFieldRoot'>
            <div class='formFieldCaption'>Фотографии</div>
        </div>
        <div>
            <section class='photosRoot'>
                <?=view('/photoViewer', ['photoItems' => $photoItems, 'add' => true, 'type' => 'place', 'id' => $place->id])?>
            </section>
        </div>

    </div>
    <div class='cardFooter'>
        <div class='button' style='margin:0.5em;' onclick='savePlaceCard()'>Сохранить</div>
        <div class='button' style='margin:0.5em;' onclick='closeModalWindow(this)'>Закрыть</div>
    </div>
</div>
<script>
   /* function onChangeFieldForm(form)
    {
        form.find('.buttonSave').removeClass('buttonDisabled');
    }*/

    function savePlaceCard()
    {
        let data = {
            'placeId': <?=$place->id?>,
            'code': $('.placeCardRoot input[name="code"]').val(),
            'caption': $('.placeCardRoot input[name="caption"]').val(),
            'address': $('.placeCardRoot input[name="address"]').val(),
            'descr': $('textarea[name="descr"]').val(),
            '_token': _token,
        };
        fetch('/admin/place/save', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success !== 1){
                alert(data.error);
                return;
            }
            closeModalWindow($('.placeCardRoot<?=$place->id?>')[0]);
        });
    }
    function afterCardTabContentLoad()
    {
	    nicEditorInit();
    }
</script>