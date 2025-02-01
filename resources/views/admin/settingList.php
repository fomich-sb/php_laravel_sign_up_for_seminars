<div class='settingContentSector' style='flex:1 1 auto;'>
    <div class='settingCaption'>Общие настройки</div>
    
    
                <!-- input 
                    name="authoring_code_text" 
                    value="<?=isset($setting['authoring_code_text']) ? $setting['authoring_code_text']->value_string : '' ?>" 
                    onchange="onChangeSetting(this)"
                / -->
    <div class='settingSectionCaption'>Уведомления</div>
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


</div>

<div style='position: sticky;bottom: 0;background: #FFF; padding: 0.5em'>
    <div class='button buttonDisabled buttonSave' onclick='saveSettings();' style='margin: 0 auto;'>Сохранить</div>
</div>

<script>
    function onChangeSetting(el)
    {
        $('.buttonSave').removeClass('buttonDisabled');
        el.dataset.dirty = 1;
    }

    function saveSettings()
    {
        let data = {
            '_token': _token,
        };
        let inpts = $('.settingContentSector input, .settingContentSector textarea');
        for(i in inpts)
        {
            let inpt = inpts[i];
            if(inpt.dataset && inpt.dataset.dirty)
                data[inpt.name] = inpt.value;
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