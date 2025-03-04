<div class='projectContentSector'>
    <div class='projectCaption'><?=$project->caption?></div>
    <div class='filterRoot'>
        Фильтр: 
        <div style='display:inline-block;'>
            <input class='filterText' type='text' placeholder="по телефону и ФИО" onkeyup='filter()'>
        </div>
        <div style='display:inline-block;'>
            <div style='display:inline-block; margin-left:1em;' class='filterStatus'>
                <div class='filterSelectField tag' onclick='$(this).toggleClass("filterSelectFieldSelected"); filter();' value='1'>Одобрено</div>
                <div class='filterSelectField tag' onclick='$(this).toggleClass("filterSelectFieldSelected"); filter();' value='0'>На рассмотрении</div>
                <div class='filterSelectField tag' onclick='$(this).toggleClass("filterSelectFieldSelected"); filter();' value='-1'>Отклонено</div>
            </div>
            <div style='display:inline-block; margin-left:1em;' class='filterParticipationType'>
                <div class='filterSelectField tag' onclick='$(this).toggleClass("filterSelectFieldSelected"); filter();' value='1'>Онлайн</div>
                <div class='filterSelectField tag' onclick='$(this).toggleClass("filterSelectFieldSelected"); filter();' value='0'>Очно</div>
            </div>
            <div style='display:inline-block; margin-left:1em;' class='filterGender'>
                <div class='filterSelectField tag' onclick='$(this).toggleClass("filterSelectFieldSelected"); filter();' value='0'>Жен</div>
                <div class='filterSelectField tag' onclick='$(this).toggleClass("filterSelectFieldSelected"); filter();' value='1'>Муж</div>
            </div>
            <div style='display:inline-block; margin-left:1em;' class='filterTags'>
                <?php foreach($tagItems as $tag): ?>
                    <div class='filterSelectField tag' onclick='$(this).toggleClass("filterSelectFieldSelected"); filter();' value='1'><?=$tag?></div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <div class='projectSectionCaption'>Выберите участников</div>
    <table class='adminTable projectUserTable' cellspacing='0' cellpadding='0'>
        <thead>
            <tr>
                <th style='cursor:pointer;' onclick='selectAll()'></th>
                <th>Телефон</th>
                <th>Заявка</th>
                <th>Участие</th>
                <th colspan='3'>ФИО</th>
                <th>Сертиф.</th>
                <th>Пол</th>
                <th>Теги</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($projectUserItems as $projectUser): ?>
                <tr class='projectUserTr<?=$projectUser->id?>'>
                    <td><input type='checkbox' class='mailingSelector' onchange='calcSelected()' value='<?=$projectUser->user_id?>'></td>
                    <td class='userPhone clickableDiv <?=$userItems[$projectUser->user_id]->messager_type==0 ? 'telegramIcon' : 'whatsappIcon'?>' onclick='openModalWindowAndLoadContent("/user/getCardEditContent", {"userId": <?=$projectUser->user_id?>, "projectId": <?=$projectUser->project_id?>});'><?=$userItems[$projectUser->user_id]->phone?></td>
                    <td class='userStatus' value='<?=$projectUser->status?>' style='text-align: center;'><?=$projectUser->status>0 ? 'Одобр' : ($projectUser->status<0 ? 'Отклон' : 'На рассм')?></td>
                    <td class='userParticipationType' style='text-align: center;' value='<?=$projectUser->participation_type?>'><?=$projectUser->participation_type ? 'Онлайн' : 'Очно'?></td>
                    <td class='userName1'><?=$userItems[$projectUser->user_id]->name1?></td>
                    <td class='userName2'><?=$userItems[$projectUser->user_id]->name2?></td>
                    <td class='userName3'><?=$userItems[$projectUser->user_id]->name3?></td>
                    <td class='certificateNum certificateNum<?=$projectUser->id?> <?=$projectUser->certificate_active ? '' : 'certificateNumDisactive'?>'>
                        <?php if(isset($certificateItems[$projectUser->certificate_id])): ?>
                            <span class='clickableDiv' onclick='getCertificate("<?=$certificateItems[$projectUser->certificate_id]->url?>")'><?=$certificateItems[$projectUser->certificate_id]->num ?></span>
                        <?php endif; ?>
                    </td>
                    <td class='userGender' value='<?=$userItems[$projectUser->user_id]->gender?>' style='text-align: center;'><?=$userItems[$projectUser->user_id]->gender ? 'М' : 'Ж'?></td>
                    <td class='tagsRoot'>
                        <?php if(isset($userTagItems[$projectUser->user_id])) 
                            foreach($userTagItems[$projectUser->user_id] as $tag): ?>
                            <div class='tag'><?=$tag->tag?></div>
                        <?php endforeach; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table><br>
    <div class='selectedCnt'>Выбрано участников: 0 </div>
    <div class='projectSectionCaption'>Текст</div>
    <div style='display: flex; flex-wrap:wrap;'>
        <div style='flex:1 1;'>
            <textarea class='mailingText' style='width:100%; height:8em;' onchange='updateMailingPreview()'></textarea>
            <pre class='mailingTextPreview' style='min-height:8em; white-space: pre-wrap;margin: 0; background:white;'></pre>
        </div>
        <div style='flex:1 1;padding-left:1em;'>
            <?php foreach($mailingTemplateItems as $item): ?>
                <div style='border:1px solid var(--caption-color);padding:0.5em; margin:0.5em;' class='clickableDiv' title='<?=$item->text?>' onclick='$(".mailingText").val(this.title); updateMailingPreview();'><?=$item->caption?></div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class='button' onclick='sendMailing()'>Отправить</div>
</div>



<script>
    function sendMailing()
    {
        let users = $('.projectUserTable tbody .mailingSelector:checked');
        if(users.length==0)
        {
            alert('Не выбраны получатели');
            return;
        }
        if(!confirm('Отправить сообщение '+users.length+' участникам?'))
            return;
        users2 = [];
        for(i in users){
            users2.push(users[i].value);
        }

        let data = {
            'projectId': <?=$project->id?>,
            'text': $('.mailingText').val(),
            'userIds': users2,
            '_token': _token,
        };
        fetch('/admin/mailing/send', {
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
            alert('Сообщение разослано');
            $('.mailingText').val('');
            $('.projectUserTable tbody .mailingSelector:checked').prop('checked', false);
            $('.mailingTextPreview').html('');
        });

    }
    function updateMailingPreview()
    {
        let data = {
            'projectId': <?=$project->id?>,
            'text': $('.mailingText').val(),
            '_token': _token,
        };
        fetch('/admin/mailing/getPreviewContent', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success !== 1){
                $('.mailingTextPreview').html(data.error);
                alert(data.error);
                return;
            }
            $('.mailingTextPreview').html(data.content);
        });
    }


    var filterActive = false;
    function filter()
    {
        filterActive = false;
        $('.projectUserTable tbody tr').removeClass('hiddenByFilter');
        var fields = $('.filterParticipationType .filterSelectFieldSelected');
        if(fields.length>0)
        {
            var filterValues=[];
            for(i=0; i<fields.length; i++)
                filterValues[$(fields[i]).attr('value')] = 1;
            var els = $('.projectUserTable tbody tr:not(.hiddenByFilter)');
            for(i=0; i<els.length; i++)
            {
                if(!filterValues[$(els[i]).find('.userParticipationType').attr('value')])
                    $(els[i]).addClass('hiddenByFilter');
            }
            filterActive = true;
        }
        
        var fields = $('.filterStatus .filterSelectFieldSelected');
        if(fields.length>0)
        {
            var filterValues=[];
            for(i=0; i<fields.length; i++)
                filterValues[$(fields[i]).attr('value')] = 1;
            var els = $('.projectUserTable tbody tr:not(.hiddenByFilter)');
            for(i=0; i<els.length; i++)
            {
                if(!filterValues[$(els[i]).find('.userStatus').attr('value')])
                    $(els[i]).addClass('hiddenByFilter');
            }
            filterActive = true;
        }

        var fields = $('.filterGender .filterSelectFieldSelected');
        if(fields.length>0)
        {
            var filterValues=[];
            for(i=0; i<fields.length; i++)
                filterValues[$(fields[i]).attr('value')] = 1;
            var els = $('.projectUserTable tbody tr:not(.hiddenByFilter)');
            for(i=0; i<els.length; i++)
            {
                if(!filterValues[$(els[i]).find('.userGender').attr('value')])
                    $(els[i]).addClass('hiddenByFilter');
            }
            filterActive = true;
        }

        var fields = $('.filterTags .filterSelectFieldSelected');
        if(fields.length>0)
        {
            var filterValues=[];
            for(i=0; i<fields.length; i++)
                filterValues[fields[i].innerHTML] = 1;

            console.log(filterValues);
            var els = $('.projectUserTable tbody tr:not(.hiddenByFilter)');
            for(i=0; i<els.length; i++)
            {
                var fl = 0;
                var tags = $(els[i]).find('.tagsRoot').html();
                for(j in filterValues)
                {
                    if(tags.indexOf('>'+j+'<')>=0)
                    {
                        fl=1;
                        break;
                    }
                }
                if(!fl)
                    $(els[i]).addClass('hiddenByFilter');
            }
            filterActive = true;
        }

        if($('.filterText').val().length>0)
        {
            var filterText=$('.filterText').val().toUpperCase();
            var els = $('.projectUserTable tbody tr:not(.hiddenByFilter)');
            for(i=0; i<els.length; i++)
            {
                if($(els[i]).find('.userPhone').text().indexOf(filterText)<0
                    && $(els[i]).find('.userName1').text().toUpperCase().indexOf(filterText)<0
                    && $(els[i]).find('.userName2').text().toUpperCase().indexOf(filterText)<0
                    && $(els[i]).find('.userName3').text().toUpperCase().indexOf(filterText)<0
                    && $(els[i]).find('.userNameEn1').text().toUpperCase().indexOf(filterText)<0
                    && $(els[i]).find('.userNameEn2').text().toUpperCase().indexOf(filterText)<0)

                    $(els[i]).addClass('hiddenByFilter');
            }
            filterActive = true;
        }
    }

    function selectAll()
    {
        var trsAll = $('.projectUserTable tbody tr:not(.hiddenByFilter)');
        var trsSelected = $('.projectUserTable tbody tr:not(.hiddenByFilter) .mailingSelector:checked');
        if(trsAll.length == trsSelected.length)
            trsSelected.prop('checked', false);
        else
            $('.projectUserTable tbody tr:not(.hiddenByFilter) .mailingSelector').prop('checked', true);

        calcSelected();
    }

    function calcSelected()
    {
        $('.selectedCnt').text('Выбрано участников: ' + $('.projectUserTable tbody .mailingSelector:checked').length);
    }
    
</script>

<style>
    .projectUserTable{
        width:95%;
    }
    .filterSelectField{
        cursor: pointer;
    }
    .filterSelectField.filterSelectFieldSelected{
        background-color: #0F05;
    }
    .hiddenByFilter{
        display: none;
    }
</style>