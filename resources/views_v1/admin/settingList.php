<div class='settingContentSector' style='flex:1 1 auto;'>
    <div class='settingCaption'>Общие настройки</div>
    
    <div class='settingSectionCaption projectContentMessageCaption'>Уведомления</div>
    <div>
        <div class='formFieldRoot'>
            <div class='formFieldCaption'>Код авторизации</div>
            <div class='formFieldInput'>
                <textarea name="authoring_code_text" onchange="onChangeSetting(this)"><?=isset($setting['authoring_code_text']) ? $setting['authoring_code_text']->value_string : '' ?></textarea>
            </div>
        </div>
        <div class='formFieldRoot'>
            <div class='formFieldCaption'>Заявка подана</div>
            <div class='formFieldInput'>
                <textarea name="project_register_status0" onchange="onChangeSetting(this)"><?=isset($setting['project_register_status0']) ? $setting['project_register_status0']->value_string : '' ?></textarea>
            </div>
        </div>
        <div class='formFieldRoot'>
            <div class='formFieldCaption'>Заявка одобрена</div>
            <div class='formFieldInput'>
                <textarea name="project_register_status1" onchange="onChangeSetting(this)"><?=isset($setting['project_register_status1']) ? $setting['project_register_status1']->value_string : '' ?></textarea>
            </div>
        </div>
        <div class='formFieldRoot'>
            <div class='formFieldCaption'>Заявка отклонена</div>
            <div class='formFieldInput'>
                <textarea name="project_register_status-1" onchange="onChangeSetting(this)"><?=isset($setting['project_register_status-1']) ? $setting['project_register_status-1']->value_string : '' ?></textarea>
            </div>
        </div>
    </div>

    <div class='settingSectionCaption projectContentMessageCaption'>Шаблоны рассылок</div>
    <div>
        <div class='mailingTemplates' style='display:flex; flex-wrap:wrap;'>
            <?php foreach($mailingTemplateItems as $item): ?>
                <div class='mailingTemplateDiv mailingTemplateDiv<?=$item->id?>' data-id='<?=$item->id?>'>
                    <div style='display:flex;'>
                        <input class='mailingTemplateCaption' style='width:100%' value='<?= $item->caption ?>' onchange="onChangeSetting(this)" placeholder="Название">&nbsp;
                        <div class='button buttonDelete buttonSmall' onclick='deleteMailingTemplate(<?=$item->id?>)'>
                            <div class='buttonDeleteIcon'></div>
                        </div>
                    </div>
                    <br>
                    <textarea class='mailingTemplateText' style='min-height:8em; width:100%' onchange="onChangeSetting(this)" placeholder="Текст"><?= $item->text ?></textarea>
                    
                </div>
            <?php endforeach; ?>
        </div>

                <div class='mailingTemplateDivTemplate' style='display:none;'>
                <div style='display:flex;'>
                        <input class='mailingTemplateCaption' style='width:100%' value='<?= $item->caption ?>' onchange="onChangeSetting(this)" placeholder="Название">&nbsp;
                        <div class='button buttonDelete buttonSmall'>
                            <div class='buttonDeleteIcon'></div>
                        </div>
                    </div>
                    <br>
                    <textarea class='mailingTemplateText' style='min-height:8em; width:100%' onchange="onChangeSetting(this)" placeholder="Текст"></textarea>
                </div>

        <div class='button' onclick='addElement("/admin/mailingTemplate/add", null, null, 1, false, function(data){addMailingTemplate(data)})'>Добавить</div>
    </div>

</div>

<div style='position: sticky;bottom: 0;background: #FFF; padding: 0.5em'>
    <div class='button buttonDisabled buttonSave' onclick='saveSettings();' style='margin: 0 auto;'>Сохранить</div>
</div>

<script>
    function addMailingTemplate(data)
    {
        var el = $('.mailingTemplateDivTemplate').clone()
            .removeClass('mailingTemplateDivTemplate')
            .addClass('mailingTemplateDiv')
            .addClass('mailingTemplateDiv'+data.ids[0])
            .show();
        el[0].dataset.id=data.ids[0];
        el.find('.buttonDelete').on('click', function() {deleteMailingTemplate(data.ids[0])});
        $('.mailingTemplates').append(el);
    }
    function deleteMailingTemplate(id)
    {
        if(!confirm('Удалить элемент?')) return;
        $('.mailingTemplateDiv'+id).hide();
        $('.mailingTemplateDiv'+id)[0].dataset.deleted = 1;
        $('.buttonSave').removeClass('buttonDisabled');
    }

    function onChangeSetting(el)
    {
        $('.buttonSave').removeClass('buttonDisabled');
        el.dataset.dirty = 1;
    }

    function saveSettings()
    {
        let data = {
            'fields': {},
            'mailingTemplatesDeletes':[],
            'mailingTemplates':{},
            '_token': _token,
        };
        let inpts = $('.settingContentSector input, .settingContentSector textarea');
        for(i in inpts)
        {
            let inpt = inpts[i];
            if(inpt.dataset && inpt.dataset.dirty)
                data['fields'][inpt.name] = inpt.value;
        }
        
        let els = $('.mailingTemplateDiv');
        for(i in els)
        {
            if(els[i].dataset && els[i].dataset.deleted==1){
                data['mailingTemplatesDeletes'].push(els[i].dataset.id);
                continue;
            }
            if(els[i].dataset && $(els[i]).find('[data-dirty=1]').length>0){
                data['mailingTemplates'][els[i].dataset.id]={
                    'caption': $(els[i]).find('.mailingTemplateCaption').val(), 
                    'text': $(els[i]).find('.mailingTemplateText').val()
                };
                continue;
            }
        }

        fetch('/admin/setting/save', {
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
</script>

<style>
    .mailingTemplateDiv{
        max-width: 20em;
        width: 100%;
        margin: 0.5em;
        padding: 0.5em;
        border: 1px solid var(--caption-color);
    }
</style>