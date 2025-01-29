<div class='projectContentSector'>
    <div class='projectCaption'><?=$project->caption?></div>
    <div class='filterRoot'>
        Фильтр: 
        <div style='display:inline-block;'>
            <input class='filterText' type='text' placeholder="по телефону и ФИО" onkeyup='filter()'>
        </div>
        <div style='display:inline-block;'>
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
    
    <div class='projectSectionCaption'>Участие подтверждено <span class='projectUserCnt1' style='margin-left: 1em;'></span> <span class='projectUserCnt1Filtered' style='margin-left: 1em;'></span></div>
    <table class='adminTable projectUserTable1' cellspacing='0' cellpadding='0'>
        <thead>
            <tr>
                <th>Телефон</th>
                <th>Участие</th>
                <th colspan='3'>ФИО</th>
                <th colspan='2'>ФИ англ.</th>
                <th colspan='2'>Сертиф.</th>
                <th>Пол</th>
                <th>Теги</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($projectUserItems as $projectUser): 
                    if($projectUser->status <= 0) continue;?>
                <tr class='projectUserTr<?=$projectUser->id?>'>
                    <td class='userPhone clickableDiv' onclick='openModalWindowAndLoadContent("/user/getCardEditContent", {"userId": <?=$projectUser->user_id?>, "projectId": <?=$projectUser->project_id?>});'><?=$userItems[$projectUser->user_id]->phone?></td>
                    <td class='userParticipationType' style='text-align: center;' value='<?=$projectUser->participation_type?>'><?=$projectUser->participation_type ? 'Онлайн' : 'Очно'?></td>
                    <td class='userName1'><?=$userItems[$projectUser->user_id]->name1?></td>
                    <td class='userName2'><?=$userItems[$projectUser->user_id]->name2?></td>
                    <td class='userName3'><?=$userItems[$projectUser->user_id]->name3?></td>
                    <td class='userNameEn1'><?=$userItems[$projectUser->user_id]->nameEn1?></td>
                    <td class='userNameEn2'><?=$userItems[$projectUser->user_id]->nameEn2?></td>
                    <td class='certificateActive'><input class="certificateActiveCheckbox certificateActiveCheckbox<?=$projectUser->id?>" type="checkbox" value="<?=$projectUser->id?>" onchange="onChangeCertificateActive(this)" <?=$projectUser->certificate_active ? "checked='checked'" : "" ?> style='margin-right:0;' ></td>
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
                    <td>
                        <div class='button buttonSmall buttonProjectUserSetStatus1' style='background:#9F9;' onclick='setProjectUserStatus(<?=$projectUser->id?>, 1)'>Принять</div>
                        <div class='button buttonSmall buttonProjectUserSetStatus-1' style='background:#F99;' onclick='setProjectUserStatus(<?=$projectUser->id?>, -1)'>Откл.</div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class='projectSectionCaption'>Заявка на рассмотрении <span class='projectUserCnt0' style='margin-left: 1em;'></span> <span class='projectUserCnt0Filtered' style='margin-left: 1em;'></span></div>
    <table class='adminTable projectUserTable0' cellspacing='0' cellpadding='0'>
        <thead>
            <tr>
                <th>Телефон</th>
                <th>Участие</th>
                <th colspan='3'>ФИО</th>
                <th colspan='2'>ФИ англ.</th>
                <th>Пол</th>
                <th>Теги</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($projectUserItems as $projectUser): 
                    if($projectUser->status != 0) continue;?>
                <tr class='projectUserTr<?=$projectUser->id?>'>
                    <td class='userPhone clickableDiv' onclick='openModalWindowAndLoadContent("/user/getCardEditContent", {"userId": <?=$projectUser->user_id?>, "projectId": <?=$projectUser->project_id?>});'><?=$userItems[$projectUser->user_id]->phone?></td>
                    <td class='userParticipationType' style='text-align: center;' value='<?=$projectUser->participation_type?>'><?=$projectUser->participation_type ? 'Онлайн' : 'Очно'?></td>
                    <td class='userName1'><?=$userItems[$projectUser->user_id]->name1?></td>
                    <td class='userName2'><?=$userItems[$projectUser->user_id]->name2?></td>
                    <td class='userName3'><?=$userItems[$projectUser->user_id]->name3?></td>
                    <td class='userNameEn1'><?=$userItems[$projectUser->user_id]->nameEn1?></td>
                    <td class='userNameEn2'><?=$userItems[$projectUser->user_id]->nameEn2?></td>
                    <td class='userGender' value='<?=$userItems[$projectUser->user_id]->gender?>' style='text-align: center;'><?=$userItems[$projectUser->user_id]->gender ? 'М' : 'Ж'?></td>
                    <td class='tagsRoot'>
                        <?php if(isset($userTagItems[$projectUser->user_id])) 
                            foreach($userTagItems[$projectUser->user_id] as $tag): ?>
                            <div class='tag'><?=$tag->tag?></div>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <div class='button buttonSmall buttonProjectUserSetStatus1' style='background:#9F9;' onclick='setProjectUserStatus(<?=$projectUser->id?>, 1)'>Принять</div>
                        <div class='button buttonSmall buttonProjectUserSetStatus-1' style='background:#F99;' onclick='setProjectUserStatus(<?=$projectUser->id?>, -1)'>Откл.</div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


    <div class='projectSectionCaption'>Отклоненные заявки <span class='projectUserCnt-1' style='margin-left: 1em;'></span> <span class='projectUserCnt-1Filtered' style='margin-left: 1em;'></span></div>
    <table class='adminTable projectUserTable-1' cellspacing='0' cellpadding='0'>
        <thead>
            <tr>
                <th>Телефон</th>
                <th>Участие</th>
                <th colspan='3'>ФИО</th>
                <th colspan='2'>ФИ англ.</th>
                <th>Пол</th>
                <th>Теги</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($projectUserItems as $projectUser): 
                    if($projectUser->status >= 0) continue;?>
                <tr class='projectUserTr<?=$projectUser->id?>'>
                    <td class='userPhone clickableDiv' onclick='openModalWindowAndLoadContent("/user/getCardEditContent", {"userId": <?=$projectUser->user_id?>, "projectId": <?=$projectUser->project_id?>});'><?=$userItems[$projectUser->user_id]->phone?></td>
                    <td class='userParticipationType' style='text-align: center;' value='<?=$projectUser->participation_type?>'><?=$projectUser->participation_type ? 'Онлайн' : 'Очно'?></td>
                    <td class='userName1'><?=$userItems[$projectUser->user_id]->name1?></td>
                    <td class='userName2'><?=$userItems[$projectUser->user_id]->name2?></td>
                    <td class='userName3'><?=$userItems[$projectUser->user_id]->name3?></td>
                    <td class='userNameEn1'><?=$userItems[$projectUser->user_id]->nameEn1?></td>
                    <td class='userNameEn2'><?=$userItems[$projectUser->user_id]->nameEn2?></td>
                    <td class='userGender' value='<?=$userItems[$projectUser->user_id]->gender?>' style='text-align: center;'><?=$userItems[$projectUser->user_id]->gender ? 'М' : 'Ж'?></td>
                    <td class='tagsRoot'>
                        <?php if(isset($userTagItems[$projectUser->user_id])) 
                            foreach($userTagItems[$projectUser->user_id] as $tag): ?>
                            <div class='tag'><?=$tag->tag?></div>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <div class='button buttonSmall buttonProjectUserSetStatus1' style='background:#9F9;' onclick='setProjectUserStatus(<?=$projectUser->id?>, 1)'>Принять</div>
                        <div class='button buttonSmall buttonProjectUserSetStatus-1' style='background:#F99;' onclick='setProjectUserStatus(<?=$projectUser->id?>, -1)'>Откл.</div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class='button' onclick='openModalWindowAndLoadContent("/admin/projectUser/getAddCardContent", {"projectId": <?=$projectUser->project_id?>});'>Добавить участника</div>
</div>

<script>
   function setProjectUserStatus(projectUserId, status)
   {
    let data = {
            'projectUserId': projectUserId,
            'status': status,

            '_token': _token,
        };
        fetch('/admin/projectUser/setStatus', {
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
            $('.projectUserTable'+status+' tbody').append($('.projectUserTr'+projectUserId));
            calcProjectUserCnts();
        });
    }

    function onChangeCertificateActive(el)
    {
        let projectUserId = el.value;
        if(el.checked)
        {
            if(!confirm("Выдать сертификат?")) {
                el.checked = false;
                return;
            }
        }
        else 
        {
            if(!confirm("Аннулировать сертификат?")) {
                el.checked = true;
                return;
            }
        }
        
        let data = {
            'projectUserId': projectUserId,
            'active': el.checked ? 1 : 0,
            '_token': _token,
        };
        fetch('/admin/certificate/setActive', {
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
            else {
                $('.certificateActiveCheckbox'+projectUserId).checked = data.active;
                if(data.active)
                    $('.certificateNum'+projectUserId).removeClass('certificateNumDisactive');
                else
                    $('.certificateNum'+projectUserId).addClass('certificateNumDisactive');
                if(data.num)
                    $('.certificateNum'+projectUserId).text(data.num);
            }
        });
    }


    var filterActive = false;
    function calcProjectUserCnts(){

        $('.projectUserCnt1').text($('.projectUserTable1 tbody tr').length + ' чел');
        $('.projectUserCnt0').text($('.projectUserTable0 tbody tr').length + ' чел');
        $('.projectUserCnt-1').text($('.projectUserTable-1 tbody tr').length + ' чел');

        if(filterActive)
        {
            $('.projectUserCnt1Filtered').text('(фильтр '+ $('.projectUserTable1 tbody tr:not(.hiddenByFilter)').length +' чел)');
            $('.projectUserCnt0Filtered').text('(фильтр '+ $('.projectUserTable0 tbody tr:not(.hiddenByFilter)').length +' чел)');
            $('.projectUserCnt-1Filtered').text('(фильтр '+ $('.projectUserTable-1 tbody tr:not(.hiddenByFilter)').length +' чел)');
            $('.projectUserCnt1Filtered, .projectUserCnt0Filtered, .projectUserCnt-1Filtered').show();
        }
        else
            $('.projectUserCnt1Filtered, .projectUserCnt0Filtered, .projectUserCnt-1Filtered').hide();
        
    }
    calcProjectUserCnts();

    function filter()
    {
        filterActive = false;
        $('.projectUserTable1 tbody tr, .projectUserTable0 tbody tr, .projectUserTable-1 tbody tr').removeClass('hiddenByFilter');
        var fields = $('.filterParticipationType .filterSelectFieldSelected');
        if(fields.length>0)
        {
            var filterValues=[];
            for(i=0; i<fields.length; i++)
                filterValues[$(fields[i]).attr('value')] = 1;
            var els = $('.projectUserTable1 tbody tr:not(.hiddenByFilter), .projectUserTable0 tbody tr:not(.hiddenByFilter), .projectUserTable-1 tbody tr:not(.hiddenByFilter)');
            for(i=0; i<els.length; i++)
            {
                if(!filterValues[$(els[i]).find('.userParticipationType').attr('value')])
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
            var els = $('.projectUserTable1 tbody tr:not(.hiddenByFilter), .projectUserTable0 tbody tr:not(.hiddenByFilter), .projectUserTable-1 tbody tr:not(.hiddenByFilter)');
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
            var els = $('.projectUserTable1 tbody tr:not(.hiddenByFilter), .projectUserTable0 tbody tr:not(.hiddenByFilter), .projectUserTable-1 tbody tr:not(.hiddenByFilter)');
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
            var els = $('.projectUserTable1 tbody tr:not(.hiddenByFilter), .projectUserTable0 tbody tr:not(.hiddenByFilter), .projectUserTable-1 tbody tr:not(.hiddenByFilter)');
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
        calcProjectUserCnts();
    }
</script>

<style>
    .projectUserTable1, .projectUserTable0, .projectUserTable-1{
        width:95%;
    }
    .projectUserTable1 .buttonProjectUserSetStatus1, .projectUserTable-1 .buttonProjectUserSetStatus-1{
        display: none;
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
    .certificateNum{
        border-left: 0;
    }
    .certificateActive{
        border-right: 0;
    }
    .certificateNumDisactive{
        text-decoration: line-through;
        opacity: 0.5;
    }
</style>