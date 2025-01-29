<div class='projectContentSector'>
    <div class='projectCaption'><?=$project->caption?></div>


    <div class='projectSectionCaption'>Общая информация</div>
    <div class='formFieldRoot'>
        <div class='formFieldCaption'>Название</div>
        <div class='formFieldInput'><input name="caption" value="<?=$project->caption?>" onchange="onChangeFieldForm()"/></div>
    </div>
    <div class='formFieldRoot'>
        <div class='formFieldCaption'>Статус</div>
        <div class='formFieldInput'>
            <select name="status" onchange="onChangeFieldForm()">
                <?php foreach(App(App\Models\Project::class)->getStatuses() as $key => $status): ?>
                    <option value='<?=$status['id']?>' <?= $project->status==$status['id'] ? " selected " : "" ?>><?=$status['caption']?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class='formFieldRoot'>
        <div class='formFieldCaption'>Даты</div>
        <div class='formFieldInput'>
            <input type='date' name="date_start" value="<?=$project->date_start?>" onchange="onChangeFieldForm()"/> по 
            <input type='date' name="date_end" value="<?=$project->date_end?>" onchange="onChangeFieldForm()"/>
        </div>
    </div>
    <div class='formFieldRoot'>
        <div class='formFieldCaption'>Даты текстом (для сайта)</div>
        <div class='formFieldInput'><input name="dates" value="<?=$project->dates?>" onchange="onChangeFieldForm()"/></div>
    </div>

    <div class='formFieldRoot'>
        <div class='formFieldCaption'>Ведущие</div>
        <div class='formFieldInput'>
            <?php foreach($tamadaItems as $user): ?>
                <div>
                    <label>
                        <input class="tamadaCheckbox" type="checkbox" value="<?=$user->id?>" onchange="onChangeFieldForm()" <?=$projectTamadaItems->search($user->id)!==false ? "checked='checked'" : "" ?>  >
                        <?=$user->name1?> <?=$user->name2?> <?=$user->name3?>
                    </label>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class='formFieldRoot'>
        <div class='formFieldCaption'>Цена</div>
        <div class='formFieldInput'><input type='number' name="price" value="<?=$project->price?>" onchange="onChangeFieldForm()"/></div>
    </div>
    <div class='formFieldRoot'>
        <div class='formFieldCaption'>Место</div>
        <div class='formFieldInput'>
            <select name="place" onchange="onChangeFieldForm()">
                <option value='-1'>-</option>
                <?php foreach($placeItems as $place): ?>
                    <option value='<?=$place->id?>' <?= $project->place_id==$place->id ? " selected " : "" ?>><?=$place->code?></option>
                <?php endforeach; ?>
            </select>
            <!-- textarea class='textareaHtml' name="place" id='place' onchange="onChangeFieldForm()"><?=$project->place?></textarea -->
        </div>
    </div>
    <div class='formFieldRoot'>
        <div class='formFieldCaption'>Время</div>
        <div class='formFieldInput'>
            <textarea class='textareaHtml' name="time" id='time' onchange="onChangeFieldForm()"><?=$project->time?></textarea>
        </div>
    </div>
    <div class='formFieldRoot'>
        <div class='formFieldCaption'>Описание</div>
        <div class='formFieldInput'>
            <textarea class='textareaHtml' name="descr" id='descr' onchange="onChangeFieldForm()"><?=$project->descr?></textarea>
        </div>
    </div>
</div>

<div class='projectContentSector'>
    <div class='projectSectionCaption'>Для согласованных участников</div>

    <div class='formFieldRoot'>
        <div class='formFieldCaption'>Текст</div>
        <div class='formFieldInput'>
            <textarea class='textareaHtml' name="text_for_accepted" id='text_for_accepted' onchange="onChangeFieldForm()"><?=$project->text_for_accepted?></textarea>
        </div>
    </div>
    <div class='formFieldRoot'>
        <div class='formFieldCaption'>Группа Telegram</div>
        <div class='formFieldInput'><input name="telegram_group" value="<?=$project->telegram_group?>" onchange="onChangeFieldForm()"/></div>
    </div>
    <div class='formFieldRoot'>
        <div class='formFieldCaption'>Ссылка ZOOM</div>
        <div class='formFieldInput'><input name="zoom_url" value="<?=$project->zoom_url?>" onchange="onChangeFieldForm()"/></div>
    </div>
    
</div>

<div class='projectContentSector'>
    <div class='projectSectionCaption'>Фотографии</div>

    <div class='formFieldRoot'>
        <div class='formFieldCaption' style='max-width: 18em;'>Загрузка фотографий участниками</div>
        <div class='formFieldInput'>
            <label>
                <input name='photo_user_upload_allow' type="checkbox" onchange="onChangeFieldForm()" <?=$project->photo_user_upload_allow ? "checked='checked'" : "" ?>  >
            </label>
        </div>
    </div>
    
    <div>
        <section class='photosRoot'>
            <?=view('/photoViewer', ['photoItems' => $photoItems, 'add' => true, 'type' => 'project', 'id' => $project->id])?>
        </section>
    </div>
</div>

<div class='projectContentSector'>
    <div class='projectSectionCaption'>Сертификат участника</div>

    <div class='formFieldRoot'>
        <div class='formFieldCaption' style='max-width: 18em;'>Доступен участникам</div>
        <div class='formFieldInput'>
            <label>
                <input name='certificate_enabled' type="checkbox" onchange="onChangeFieldForm()" <?=$project->certificate_enabled ? "checked='checked'" : "" ?>  >
            </label>
        </div>
    </div>
    <div class='formFieldRoot'>
        <div class='formFieldCaption' style='max-width: 18em;'>Картинка фона</div>
        <div class='formFieldInput'>
            <form class="certificateBgForm certificateBgForm<?=$project->id?>" action="/admin/project/setImage" method="post" enctype="multipart/form-data">
                <div class='certificateBgImg' onclick='uploadCertificateBgImage(<?=$project->id?>)' style='<?= $project->certificate_bg ? 'background-image: url('.config('app.uploadImageFolder').'/certificates/thumbs/'.$project->certificate_bg.');' : '' ?>'></div>
                <input type="file" name="file" style='display: none;' />
                <input type="hidden" name="projectId" value='<?= $project->id ?>' />
                <input type="hidden" name="_token" value='<?= csrf_token() ?>' />
            </form>
            <input type="hidden" name="certificate_bg" class="certificateBg" value="<?=$project->certificate_bg?>"/>

        </div>
    </div>
    
    <div class='formFieldCaption'>HTML</div>
    <div class='formFieldInput'>
        <textarea name="certificate_html" class='certificateHtml' onchange="onChangeFieldForm(); updateCertificatePreview();"><?=$project->certificate_html?></textarea>
    </div>
    
    <div class='formFieldCaption clickableDiv' onclick='$(".certificatePreviewRoot").toggle();'>Предпросмотр</div>
    <section class='certificatePreviewRoot' style='display:none; position:relative;'>

    </section>

</div>
<div style='position: sticky;bottom: 0;background: #FFF; padding: 0.5em'>
<div class='button buttonDisabled buttonSave' onclick='saveProjectCard();' style='margin: 0 auto;'>Сохранить</div>

<script>
    function onChangeFieldForm()
    {
        $('.buttonSave').removeClass('buttonDisabled');
    }

    function saveProjectCard()
    {
        var tamadaIds = $(".tamadaCheckbox:checkbox:checked").map(function(){
            return parseInt($(this).val());
        }).get();
        
        let data = {
            'projectId': <?=$project->id?>,
            'caption': $('input[name="caption"]').val(),
            'status': $('select[name="status"]').val(),
            'date_start': $('input[name="date_start"]').val(),
            'date_end': $('input[name="date_end"]').val(),
            'dates': $('input[name="dates"]').val(),
            'price': $('input[name="price"]').val(),
            //'place': $('textarea[name="place"]').val(),
            'place_id': $('select[name="place"]').val()==-1 ? null : $('select[name="place"]').val(),
            'time': $('textarea[name="time"]').val(),
            'descr': $('textarea[name="descr"]').val(),
            'text_for_accepted': $('textarea[name="text_for_accepted"]').val(),
            'telegram_group': $('input[name="telegram_group"]').val(),
            'zoom_url': $('input[name="zoom_url"]').val(),
            'photo_user_upload_allow': $('input[name="photo_user_upload_allow"]').prop('checked') ? 1 : 0,
            'certificate_enabled': $('input[name="certificate_enabled"]').prop('checked') ? 1 : 0,
            'certificate_bg': $('input[name="certificate_bg"]').val(),
            'certificate_html': $('textarea[name="certificate_html"]').val(),
            'tamada_items': tamadaIds,

            '_token': _token,
        };
        fetch('/admin/project/save', {
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
            $('.buttonSave').addClass('buttonDisabled');
        });
    }

    function uploadCertificateBgImage(projectId) {
        $('.certificateBgForm' + projectId).fileupload({
            // Функция будет вызвана при помещении файла в очередь
            add: function(e, data) {
                // Автоматически загружаем файл при добавлении в очередь
                var jqXHR = data.submit();
            },
            success: function(data) {
                if (data.success == 0)
                    alert(data.error);
                else{
                    if(data.image){
                        $('.certificateBgForm' + projectId + ' .certificateBgImg').css('background-image', 'url(<?=config('app.uploadImageFolder')?>/certificates/thumbs/'+data.image+')');
                        $('input[name="certificate_bg"]').val(data.image);
                    }
                    else{
                        $('.certificateBgForm' + projectId + ' .certificateBgImg').css('background-image', null);
                        $('input[name="certificate_bg"]').val(null);
                    }
                    onChangeFieldForm();
                    updateCertificatePreview();
                }
            },
            fail: function(e, data) {
                alert("Ошибка загрузки файла");
            },
        });
        $('.certificateBgForm' + projectId).find("input[name='file']").click();
    }
    function updateCertificatePreview() {
        let data = {
            'projectId': <?=$project->id?>,
            'certificate_bg': $('input[name="certificate_bg"]').val(),
            'certificate_html': $('textarea[name="certificate_html"]').val(),

            '_token': _token,
        };
        fetch('/admin/certificate/getPreviewContent', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success !== 1){
                $('.certificatePreviewRoot').html(data.error);
                alert(data.error);
                return;
            }
            $('.certificatePreviewRoot').html(data.content);
        });
    }
    updateCertificatePreview();
	nicEditorInit();
</script>