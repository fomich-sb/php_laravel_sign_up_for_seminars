<div class='cardRoot projectAddUserCardRoot projectAddUserCardRoot<?=$project->id?>'>
    <div class='cardHeader'>Добавить участников в "<?=$project->caption?>"</div>
    <div class='cardContent projectAddUserCardContent'>
        <div class='formFieldRoot'>
            Введите номера телефонов добавляемых участников (через +7). Каждый участник с новой строки.
        </div>
        <textarea name="projectAddUserList" style="    width: 40em;    height: 10em;"></textarea>

        <div>
            <label>
                <input name='projectAddUserCreate' type="checkbox">
                Создавать учетные записи при необходимости
            </label>
        </div>

    </div>
    <div class='cardFooter'>
        <div class='button' style='margin:0.5em;' onclick='projectAddUserAction()'>Добавить</div>
        <div class='button' style='margin:0.5em;' onclick='closeModalWindow(this)'>Закрыть</div>
    </div>
</div>
<script>

    function projectAddUserAction()
    {
        let data = {
            'projectId': <?=$project->id?>,
            'userList': $('textarea[name="projectAddUserList"]').val(),
            'create': $('input[name="projectAddUserCreate"]').prop('checked') ? 1 : 0,
            '_token': _token,
        };
        fetch('/admin/projectUser/add', {
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
            else
            {
                let stat='Приглашено участников: ' + data.addedUsers.length;
                if(data.newUsers.length>0)
                    stat+='\nЗарегистрировано новых пользователей: ' + data.newUsers.length;
                if(data.notExistPhones.length>0)
                    stat+='\nНе зарегистрировано пользователей: ' + data.notExistPhones.length;
                if(data.existProjectUsers.length>0)
                    stat+='\nУже было в проекте: ' + data.existProjectUsers.length;
                if(data.badPhones.length>0)
                    stat+='\nНе распознан телефон: ' + data.badPhones.length;
                alert(stat);
                if(data.notExistPhones.length>0 || data.badPhones.length>0){
                    $('textarea[name="projectAddUserList"]').val(data.notExistPhones.join('\n') + '\n' + data.badPhones.join('\n'));
                }
                else
                    closeModalWindow($('.projectCardRoot<?=$project->id?>')[0]);
            }
        });
    }
</script>