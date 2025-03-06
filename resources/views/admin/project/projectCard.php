<link rel="stylesheet" type="text/css" href="/_libs/iconselect/css/lib/control/iconselect.css" >
<script type="text/javascript" src="/_libs/iconselect/lib/control/iconselect.js"></script>
<script type="text/javascript" src="/_libs/iconselect/lib/iscroll.js"></script>

<div class='projectContentSector'>
    <div class='projectCaption'><?=$project->caption?></div>


    <div class='projectSectionCaption projectContentDocCaption'>Общая информация</div>
    <div class='formFieldRoot'>
        <div class='formFieldCaption'>Название</div>
        <div class='formFieldInput'><input name="caption" value="<?=$project->caption?>" onchange="onChangeFieldForm(this)"/></div>
    </div>
    <div class='formFieldRoot'>
        <div class='formFieldCaption'>Статус</div>
        <div class='formFieldInput'>
            <select name="status" onchange="onChangeFieldForm(this)">
                <?php foreach(App(App\Models\Project::class)->getStatuses() as $key => $status): ?>
                    <option value='<?=$status['id']?>' <?= $project->status==$status['id'] ? " selected " : "" ?>><?=$status['caption']?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class='formFieldRoot'>
        <div class='formFieldCaption'>Даты</div>
        <div class='formFieldInput'>
            <input type='date' name="date_start" value="<?=$project->date_start?>" onchange="onChangeFieldForm(this)"/> по 
            <input type='date' name="date_end" value="<?=$project->date_end?>" onchange="onChangeFieldForm(this)"/>
        </div>
    </div>
    <div class='formFieldRoot'>
        <div class='formFieldCaption'>Даты текстом (для сайта)</div>
        <div class='formFieldInput'><input name="dates" value="<?=$project->dates?>" onchange="onChangeFieldForm(this)"/></div>
    </div>

    <div class='formFieldRoot'>
        <div class='formFieldCaption'>Ведущие</div>
        <div class='formFieldInput'>
            <?php foreach($tamadaItems as $user): ?>
                <div>
                    <label>
                        <input class="tamadaCheckbox" type="checkbox" value="<?=$user->id?>" onchange="onChangeFieldForm(this)" <?=$projectTamadaItems->search($user->id)!==false ? "checked='checked'" : "" ?>  >
                        <?=$user->name1?> <?=$user->name2?> <?=$user->name3?>
                    </label>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class='formFieldRoot'>
        <div class='formFieldCaption'>Цена</div>
        <div class='formFieldInput'><input type='number' name="price" value="<?=$project->price?>" onchange="onChangeFieldForm(this)"/></div>
    </div>
    <div class='formFieldRoot'>
        <div class='formFieldCaption'>Место</div>
        <div class='formFieldInput'>
            <select name="place" onchange="onChangeFieldForm(this)">
                <option value='-1'>-</option>
                <?php foreach($placeItems as $place): ?>
                    <option value='<?=$place->id?>' <?= $project->place_id==$place->id ? " selected " : "" ?>><?=$place->code?></option>
                <?php endforeach; ?>
            </select>
            <!-- textarea class='textareaHtml' name="place" id='place' onchange="onChangeFieldForm(this)"><?=$project->place?></textarea -->
        </div>
    </div>
    <div class='formFieldRoot'>
        <div class='formFieldCaption'>Для кого</div>
        <div class='formFieldInput'>
            <textarea class='textareaHtml' name="user_requirements" id='user_requirements' onchange="onChangeFieldForm(this)"><?=$project->user_requirements?></textarea>
        </div>
    </div>
    <div class='formFieldRoot'>
        <div class='formFieldCaption'>Время</div>
        <div class='formFieldInput'>
            <textarea class='textareaHtml' name="time" id='time' onchange="onChangeFieldForm(this)"><?=$project->time?></textarea>
        </div>
    </div>
    <div class='formFieldRoot'>
        <div class='formFieldCaption'>Описание</div>
        <div class='formFieldInput'>
            <textarea class='textareaHtml' name="descr" id='descr' onchange="onChangeFieldForm(this)"><?=$project->descr?></textarea>
        </div>
    </div>
</div>

<div class='projectContentSector'>
    <div class='projectSectionCaption projectContentForAcceptCaption'>Для согласованных участников</div>

    <div class='formFieldRoot'>
        <div class='formFieldCaption'>Текст</div>
        <div class='formFieldInput'>
            <textarea class='textareaHtml' name="text_for_accepted" id='text_for_accepted' onchange="onChangeFieldForm(this)"><?=$project->text_for_accepted?></textarea>
        </div>
    </div>
</div>

<div class='projectContentSector'>
    <div class='projectSectionCaption projectContentMaterialsCaption'>Материалы</div>
    <div class='materials'>
        <?php foreach($materialItems as $material): ?>
            <div class='materialDiv materialDiv<?=$material->id?>' data-id='<?=$material->id?>'>
                <div style='flex:0 0 auto; margin-right:0.5em;' class="materialIconSelector" name='materialIcon' id='materialIconSelector<?=$material->id?>' data-value='<?= $material->icon ?>'></div>
                <input style='flex:1 1; margin-right:1em;' class='materialCaption' value='<?= $material->caption ?>' onchange="onChangeFieldForm(this)" placeholder="Название">
                <select class='materialType' onchange="onChangeFieldForm(this)" style='min-width: auto; flex:0 0 auto; margin-right:1em;'>
                    <option value="0" <?=$material->type==0 ? "selected" : "" ?>>Ссылка</option>
                    <option value="1" <?=$material->type==1 ? "selected" : "" ?>>Файл</option>
                </select>
                <label style='flex:0 0 auto; margin-right:1em;' title='Только для согласованных участников'>
                    <input style='margin: 0;' name='materialForAccepted' type="checkbox" onchange="onChangeFieldForm(this)" <?=$material->for_accepted ? "checked='checked'" : "" ?>> согл
                </label>
                <input style='flex:2 1; margin-right:1em;' class='materialUrl' value='<?= $material->url ?>' onclick="materialUrlClick(this, <?=$material->id?>)" onchange="onChangeFieldForm(this)" placeholder="Ссылка">
                <div class='button buttonOpen buttonSmall' style='flex:0 0 auto; margin-right:1em;' onclick='openMaterial(<?=$material->id?>)'><div class='buttonOpenIcon'></div></div>
                <div class='button buttonDelete buttonSmall' onclick='deleteMaterial(<?=$material->id?>)' style='flex:0 0 auto;'><div class='buttonDeleteIcon'></div></div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class='button' onclick='addElement("/admin/material/add", "project_id", <?=$project->id?>, 1, false, function(data){addMaterial(data)})'>Добавить</div>
    
            <div class='materialDivTemplate' style='display: none;'>
                <div style='flex:0 0 auto; margin-right:0.5em;' name='materialIcon' data-value=''></div>
                <input style='flex:1 1; margin-right:1em;' class='materialCaption' value='' onchange="onChangeFieldForm(this)" placeholder="Название">
                <select class='materialType' onchange="onChangeFieldForm(this)" style='min-width: auto; flex:0 0 auto; margin-right:1em;'>
                    <option value="0" selected>Ссылка</option>
                    <option value="1">Файл</option>
                </select>
                <label style='flex:0 0 auto; margin-right:1em;' title='Только для согласованных участников'>
                    <input style='margin: 0;' name='materialForAccepted' type="checkbox" onchange="onChangeFieldForm(this)" checked='checked'> согл
                </label>
                <input style='flex:2 1; margin-right:1em;' class='materialUrl' value='' onchange="onChangeFieldForm(this)" placeholder="Ссылка">
                <div class='button buttonOpen buttonSmall' style='flex:0 0 auto; margin-right:1em;'><div class='buttonOpenIcon'></div></div>
                <div class='button buttonDelete buttonSmall' style='flex:0 0 auto;'><div class='buttonDeleteIcon'></div></div>
            </div>
    <form class="materialFileUploadForm" action="/admin/material/uploadFile" method="post" enctype="multipart/form-data">
        <input type="file" name="file" style='display: none;' />
        <input type="hidden" name="materialId" />
        <input type="hidden" name="_token" value='<?= csrf_token() ?>' />
    </form>

    <!-- div class='formFieldRoot'>
        <div class='formFieldCaption'>Группа Telegram</div>
        <div class='formFieldInput'><input name="telegram_group" value="<?=$project->telegram_group?>" onchange="onChangeFieldForm(this)"/></div>
    </div>

    <div class='formFieldRoot'>
        <div class='formFieldCaption'>Ссылка ZOOM</div>
        <div class='formFieldInput'><input name="zoom_url" value="<?=$project->zoom_url?>" onchange="onChangeFieldForm(this)"/></div>
    </div -->
    
</div>

<div class='projectContentSector'>
    <div class='projectSectionCaption projectContentPhotosCaption'>Фотографии</div>

    <div class='formFieldRoot'>
        <div class='formFieldCaption' style='max-width: 18em;'>Загрузка фотографий участниками</div>
        <div class='formFieldInput'>
            <label>
                <input name='photo_user_upload_allow' type="checkbox" onchange="onChangeFieldForm(this)" <?=$project->photo_user_upload_allow ? "checked='checked'" : "" ?>  >
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
    <div class='projectSectionCaption projectContentCertificateCaption'>Сертификат участника</div>

    <div class='formFieldRoot'>
        <div class='formFieldCaption' style='max-width: 18em;'>Доступен участникам</div>
        <div class='formFieldInput'>
            <label>
                <input name='certificate_enabled' type="checkbox" onchange="onChangeFieldForm(this)" <?=$project->certificate_enabled ? "checked='checked'" : "" ?>  >
            </label>
        </div>
    </div>
    <div class='formFieldRoot'>
        <div class='formFieldCaption' style='max-width: 18em;'>Портретная ориентация</div>
        <div class='formFieldInput'>
            <label>
                <input name='certificate_orientation' type="checkbox" onchange="onChangeFieldForm(this); updateCertificatePreview();" <?=$project->certificate_orientation ? "checked='checked'" : "" ?>  >
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
        <textarea name="certificate_html" class='certificateHtml' onchange="onChangeFieldForm(this); updateCertificatePreview();"><?=$project->certificate_html?></textarea>
    </div>
    <div style='display:flex; justify-content: center;'>
        <div class='button ' onclick='$(".certificatePreviewRoot").toggle();' style='margin: 0.5em;'>Предпросмотр</div>
        <div class='button ' onclick='recreateProjectCertificates();' style='margin: 0.5em;'>Обновить сертификаты участников</div>
    </div>
    <section class='certificatePreviewRoot' style='display:none; position:relative; margin: 0 auto;width: fit-content;'>

    </section>

</div>
<div style='position: sticky;bottom: 0;background: #FFF; padding: 0.5em'>
    <div class='button buttonDisabled buttonSave' onclick='saveProjectCard();' style='margin: 0 auto;'>Сохранить</div>
</div>


<script>
    function addMaterial(data)
    {
        var el = $('.materialDivTemplate').clone()
            .removeClass('materialDivTemplate')
            .addClass('materialDiv')
            .addClass('materialDiv'+data.ids[0])
            .show();
        el[0].dataset.id=data.ids[0];
        
        el.find('.materialUrl').on('click', function() {materialUrlClick(this, data.ids[0])});
        el.find('.buttonOpen').on('click', function() {openMaterial(data.ids[0])});
        el.find('.buttonDelete').on('click', function() {deleteMaterial(data.ids[0])});

        el.find('[name="materialIcon"]').addClass('materialIconSelector').attr('id', 'materialIconSelector'+data.ids[0]);
        $('.materials').append(el);
        initMaterialIconSelector('materialIconSelector'+data.ids[0]);
    }
    function deleteMaterial(id)
    {
        if(!confirm('Удалить элемент?')) return;
        $('.materialDiv'+id).hide();
        $('.materialDiv'+id)[0].dataset.deleted = 1;
        $('.buttonSave').removeClass('buttonDisabled');
    }
    function openMaterial(id)
    {
        let type = $('.materialDiv'+id+' .materialType').val();
        window.open((type==1 ?  '<?=config('app.uploadMaterialFolder')?>/'+id+'/' : '') + $('.materialDiv'+id+' .materialUrl').val());
    }
    function materialUrlClick(el, id)
    {
        if($('.materialDiv'+id+' .materialType').val()==1)
        {
            $(el).prop('readonly', true);

            $('.materialFileUploadForm').fileupload({
                // Функция будет вызвана при помещении файла в очередь
                add: function(e, data) {
                    // Автоматически загружаем файл при добавлении в очередь
                    var jqXHR = data.submit();
                },
                success: function(data) {
                    if (data.success == 0)
                        alert(data.error);
                    else{
                        if(data.url){
                            $(el).val(data.url);
                            if($('.materialDiv'+id+' .materialCaption').val().length == 0)
                                $('.materialDiv'+id+' .materialCaption').val(data.url.replace(/\.[^/.]+$/, ""));
                        }
                        else{
                            $(el).val(null);
                        }
                    }
                },
                fail: function(e, data) {
                    alert("Ошибка загрузки файла");
                },
            });
            $('.materialFileUploadForm [name="materialId"]').val(id);
            $('.materialFileUploadForm').find("input[name='file']").click();
        }
        else {
            $(el).prop('readonly', false);
        }
    }


    function onChangeFieldForm(el)
    {
        $('.buttonSave').removeClass('buttonDisabled');
        el.dataset.dirty = 1;
    }

    function saveProjectCard()
    {
        var tamadaIds = $(".tamadaCheckbox:checkbox:checked").map(function(){
            return parseInt($(this).val());
        }).get();
        
        let data = {
            'projectId': <?=$project->id?>,
            'caption': $('input[name="caption"]').data('dirty') ? $('input[name="caption"]').val() : null,
            'status': $('select[name="status"]').data('dirty') ? $('select[name="status"]').val() : null,
            'date_start': $('input[name="date_start"]').data('dirty') ? $('input[name="date_start"]').val() : null,
            'date_end': $('input[name="date_end"]').data('dirty') ? $('input[name="date_end"]').val() : null,
            'dates': $('input[name="dates"]').data('dirty') ? $('input[name="dates"]').val() : null,
            'price': $('input[name="price"]').data('dirty') ? $('input[name="price"]').val() : null,
            'place_id': $('select[name="place"]').val()==-1 ? null : $('select[name="place"]').val(),
            'time': $('textarea[name="time"]').data('dirty') ? $('textarea[name="time"]').val() : null,
            'descr': $('textarea[name="descr"]').data('dirty') ? $('textarea[name="descr"]').val() : null,
            'user_requirements': $('textarea[name="user_requirements"]').data('dirty') ? $('textarea[name="user_requirements"]').val() : null,
            'text_for_accepted': $('textarea[name="text_for_accepted"]').data('dirty') ? $('textarea[name="text_for_accepted"]').val() : null,
            'photo_user_upload_allow': $('input[name="photo_user_upload_allow"]').data('dirty') ? ($('input[name="photo_user_upload_allow"]').prop('checked') ? 1 : 0) : null,
            'certificate_enabled': $('input[name="certificate_enabled"]').data('dirty') ? ($('input[name="certificate_enabled"]').prop('checked') ? 1 : 0) : null,
            'certificate_bg': $('input[name="certificate_bg"]').data('dirty') ? $('input[name="certificate_bg"]').val() : null,
            'certificate_html': $('textarea[name="certificate_html"]').data('dirty') ? $('textarea[name="certificate_html"]').val() : null,
            'certificate_orientation': $('input[name="certificate_orientation"]').data('dirty') ? ($('input[name="certificate_orientation"]').prop('checked') ? 1 : 0) : null,
            'tamada_items': tamadaIds,

            'materialDeletes':[],
            'materials':{},

            '_token': _token,
        };
        
        let els = $('.materialDiv');
        for(i in els)
        {
            if(els[i].dataset && els[i].dataset.deleted==1){
                data['materialDeletes'].push(els[i].dataset.id);
                continue;
            }
            if(els[i].dataset && $(els[i]).find('[data-dirty=1]').length>0){
                data['materials'][els[i].dataset.id]={
                    'icon': $(els[i]).find('[name="materialIcon').data('value'), 
                    'caption': $(els[i]).find('.materialCaption').val(), 
                    'for_accepted': $(els[i]).find('[name="materialForAccepted"]').prop('checked') ? 1 : 0,
                    'type': $(els[i]).find('.materialType').val(),
                    'url': $(els[i]).find('.materialUrl').val(),
                };
                continue;
            }
        }

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
                    onChangeFieldForm($('input[name="certificate_bg"]')[0]);
                    updateCertificatePreview();
                }
            },
            fail: function(e, data) {
                alert("Ошибка загрузки файла");
            },
        });
        $('.certificateBgForm' + projectId).find("input[name='file']").click();
    }

    function recreateProjectCertificates() {
        let data = {
            'projectId': <?=$project->id?>,
            '_token': _token,
        };
        fetch('/admin/certificate/recreate', {
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
            }
            else {
                alert('Сертификаты пользователей очищены. Сохраните изменения проекта.');
            }
        });
    }

    function updateCertificatePreview() {
        let data = {
            'projectId': <?=$project->id?>,
            'certificate_bg': $('input[name="certificate_bg"]').val(),
            'certificate_html': $('textarea[name="certificate_html"]').val(),
            'certificate_orientation': $('input[name="certificate_orientation"]').prop('checked') ? 1 : 0,
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

    function startInitMaterialIconSelector()
    {
        let els = $('.materialIconSelector');
        for(i=0; i<els.length; i++)
            initMaterialIconSelector(els[i].id)
    }
    function initMaterialIconSelector(id)
    {
        let iconSelect = new IconSelect(id, 
            {'selectedIconWidth':48,
            'selectedIconHeight':48,
            'selectedBoxPadding':1,
            'iconsWidth':23,
            'iconsHeight':23,
            'boxIconSpace':1,
            'vectoralIconNumber':4,
            'horizontalIconNumber':4});

        var icons = [];
        icons.push({'iconFilePath':'/uploads/images/icons/icon_default.svg', 'iconValue':'icon_default.svg'});
        <?php $files = scandir( public_path() . '/uploads/images/icons/');
            foreach($files as $file)
                if($file != '.' && $file != '..' && $file != 'icon_default.svg'):?>
                    icons.push({'iconFilePath':'/uploads/images/icons/<?=$file?>', 'iconValue':'<?=$file?>'});
        <?php endif; ?>
        iconSelect.refresh(icons);

        var el = document.getElementById(id);
        if(el.dataset.value && el.dataset.value.length>0){
            for(let i=0; i<icons.length;i++)
                if(icons[i].iconValue == el.dataset.value){
                    iconSelect.setSelectedIndex(i);
                    break;
                }
        }

        el.addEventListener('changed', function(e){
            this.dataset.value = iconSelect.getSelectedValue();
            onChangeFieldForm(this);
        });
        
    }
    startInitMaterialIconSelector();
</script>

<style>
    .materialDiv{
        display: flex;
        margin: 0.5em 0;
    }
</style>