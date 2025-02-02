<div class='projectContentSector'>
    <div class='projectCaption'>Все пользователи</div>
    <div class='filterRoot'>
        Фильтр: 
        <div style='display:inline-block;'>
            <input class='filterText' type='text' placeholder="по телефону и ФИО" onkeyup='filter()'>
        </div>
        <div style='display:inline-block;'>
            <!--div style='display:inline-block; margin-left:1em;' class='filterParticipationType'>
                <div class='filterSelectField tag' onclick='$(this).toggleClass("filterSelectFieldSelected"); filter();' value='1'>Онлайн</div>
                <div class='filterSelectField tag' onclick='$(this).toggleClass("filterSelectFieldSelected"); filter();' value='0'>Очно</div>
            </div-->
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
    <br>
    <table class='adminTable userTable' cellspacing='0' cellpadding='0'>
        <thead>
            <tr>
                <th>Телефон</th>
                <th colspan='3'>ФИО</th>
                <th colspan='2'>ФИ англ.</th>
                <th>Пол</th>
                <th>Проектов</th>
                <th>Теги</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($userItems as $user): ?>
                <tr class='userTr<?=$user->id?>'>
                    <td class='userPhone clickableDiv' onclick='openModalWindowAndLoadContent("/user/getCardEditContent", {"userId": <?=$user->id?>});'><?=$user->phone?></td>
                    <td class='userName1'><?=$user->name1?></td>
                    <td class='userName2'><?=$user->name2?></td>
                    <td class='userName3'><?=$user->name3?></td>
                    <td class='userNameEn1'><?=$user->name_en1?></td>
                    <td class='userNameEn2'><?=$user->name_en2?></td>
                    <td class='userGender' value='<?=$user->gender?>' style='text-align: center;'><?=$user->gender ? 'М' : 'Ж'?></td>
                    <td style='text-align: center;'><?=$user->projects_1?></td>
                    <td class='tagsRoot'>
                        <?php if(isset($userTagItems[$user->id])) 
                            foreach($userTagItems[$user->id] as $tag): ?>
                            <div class='tag'><?=$tag->tag?></div>
                        <?php endforeach; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class='button' onclick='addElement("/admin/user/add", null, null, 1, true, null)'>Добавить</div>
</div>

<script>
    
    function filter()
    {
        filterActive = false;
        $('.userTable tbody tr').removeClass('hiddenByFilter');
        var fields = $('.filterParticipationType .filterSelectFieldSelected');
        if(fields.length>0)
        {
            var filterValues=[];
            for(i=0; i<fields.length; i++)
                filterValues[$(fields[i]).attr('value')] = 1;
            var els = $('.userTable tbody tr:not(.hiddenByFilter)');
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
            var els = $('.userTable tbody tr:not(.hiddenByFilter)');
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
            var els = $('.userTable tbody tr:not(.hiddenByFilter)');
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
            var els = $('.userTable tbody tr:not(.hiddenByFilter)');
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
</script>

<style>
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