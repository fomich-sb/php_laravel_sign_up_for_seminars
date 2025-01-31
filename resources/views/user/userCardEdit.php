<?php

use Illuminate\Support\Facades\Auth;
?>
<div class='cardRoot userCardRoot userCardRoot<?=$user->id?>'>
    <div class='cardHeader'><?=$user->name1?> <?=$user->name2?> <?=$user->name3?></div>
    <div class='cardContent userCardContent'>
        <div class='userCardImageRoot'>
            <form class="userCardImageForm userCardImageForm<?=$user->id?>" action="/user/setImage" method="post" enctype="multipart/form-data">
                <div class='userCardImageImg' onclick='uploadUserImage(<?=$user->id?>)' style='<?= $user->image ? 'background-image: url('.config('app.uploadImageFolder').'/avatars/thumbs/'.$user->image.');' : '' ?>'></div>
                <input type="file" name="file" style='display: none;' />
                <input type="hidden" name="userId" value='<?= $user->id ?>' />
                <input type="hidden" name="_token" value='<?= csrf_token() ?>' />
            </form>
            <input type="hidden" name="image" class="userCardImage" value="<?=$user->image?>"/>
        </div>

        <div class='formFieldRoot'>
            <div class='formFieldCaption'>Телефон</div>
            <div class='formFieldInput'><input type="tel" name="phone" class="userCardPhone" value="+<?=$user->phone?>" <?= Auth::user()->admin ? '' : 'disabled="disabled"'?>/></div>
        </div>
        <div class='formFieldRoot'>
            <div class='formFieldCaption'>Фамилия</div>
            <div class='formFieldInput'><input name="lastname" class="userCardName1"value="<?=$user->name1?>" /></div>
        </div>

        <div class='formFieldRoot'>
            <div class='formFieldCaption'>Имя</div>
            <div class='formFieldInput'><input name="firstname" class="userCardName2" value="<?=$user->name2?>" /></div>
        </div>
        <div class='formFieldRoot'>
            <div class='formFieldCaption'>Отчество</div>
            <div class='formFieldInput'><input name="middlename" class="userCardName3" value="<?=$user->name3?>" /></div>
        </div>
        <div class='formFieldRoot'>
            <div class='formFieldCaption'>Пол</div>
            <div class='formFieldInput toggleControlRoot'>
                <div>жен</div>
                <div style='flex:0 0 auto;'>
                    <label class="toggleControl">
                        <input type="checkbox" name="gender" class='userCardGender' <?=$user->gender ? " checked='checked' " : "" ?> >
                        <span class="control"></span>
                    </label>
                </div>
                <div>муж</div>
            </div>
        </div>

        <div style='margin-top:1em;'>На английском:</div>
        <div class='formFieldRoot'>
            <div class='formFieldCaption'>Фамилия</div>
            <div class='formFieldInput'><input name="lastnameEn" class="userCardNameEn1" value="<?=$user->nameEn1?>" /></div>
        </div>
        <div class='formFieldRoot'>
            <div class='formFieldCaption'>Имя</div>
            <div class='formFieldInput'><input name="firstnameEn" class="userCardNameEn2"  value="<?=$user->nameEn2?>"/></div>
        </div>
        <br>
        <?php if($projectUser): ?>
            <div class='formFieldRoot'>
                <div class='formFieldCaption'>Участие в семинаре</div>
                <div class='formFieldInput toggleControlRoot'>
                    <div>очно</div>
                    <div style='flex:0 0 auto;'><label class="toggleControl">
                        <input type="checkbox" name="participationType" class='userCardParticipationType' <?= $projectUser && $projectUser->participation_type ? " checked='checked' " : "" ?>>
                        <span class="control"></span>
                    </label></div>
                    <div>онлайн</div>
                </div>
            </div>
        <?php endif; ?>

        <?php if($curUser->admin): ?>
            <div class='hr'></div>
            <div class='formFieldRoot'>
                <div class='formFieldCaption'>Автоматически одобрять</div>
                <div class='formFieldInput toggleControlRoot'>
                    <div>нет</div>
                    <div style='flex:0 0 auto;'><label class="toggleControl">
                        <input type="checkbox" name="autoApprove" class='userCardAutoApprove' <?= $user && $user->auto_approve ? " checked='checked' " : "" ?>>
                        <span class="control"></span>
                    </label></div>
                    <div>да</div>
                </div>
            </div>

            <div class='formFieldCaption'>Теги</div>
            <div class='formFieldInput'> <input name="firstnameEn" class="userCardTags tags_field" value="<?= implode(', ', $tags->pluck('tag')->toArray()) ?>"/>  </div>

            <div class='hr'></div>
            
            <div class='formFieldRoot'>
                <div class='formFieldCaption'>Ведущий</div>
                <div class='formFieldInput toggleControlRoot'>
                    <div>нет</div>
                    <div style='flex:0 0 auto;'><label class="toggleControl">
                        <input type="checkbox" name="tamada" class='userCardTamada' <?= $user && $user->tamada ? " checked='checked' " : "" ?>>
                        <span class="control"></span>
                    </label></div>
                    <div>да</div>
                </div>
            </div>
            
            <div class='formFieldRoot'>
                <div class='formFieldCaption'>Описание</div>
            </div>
            <div>
                <textarea class='textareaHtml' name="descr" id='descr'><?=$user->descr?></textarea>
            </div>
            
            <div class='hr'></div>

            <div class='formFieldRoot'>
                <div class='formFieldCaption'>Администратор</div>
                <div class='formFieldInput toggleControlRoot'>
                    <div>нет</div>
                    <div style='flex:0 0 auto;'><label class="toggleControl">
                        <input type="checkbox" name="admin" class='userCardAdmin' <?= $user && $user->admin ? " checked='checked' " : "" ?>>
                        <span class="control"></span>
                    </label></div>
                    <div>да</div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class='cardFooter'>
        <div class='button' style='margin:0.5em;' onclick='saveUserCard(<?= $user->id ?>, <?= $projectUser ? $projectUser->project_id : "null" ?>)'>Сохранить</div>
        <div class='button' style='margin:0.5em;' onclick='closeModalWindow(this)'>Закрыть</div>
    </div>
</div>

<script>
    <?php if($curUser->admin): ?>
        tagifyWhitelistUserTags=['<?= implode("', '", $allTags->pluck('tag')->toArray()) ?>'];
        //РЕДАКТОР ТЕГОВ
        inputElm = document.querySelectorAll('.userCardTags')[0];
        tagify = new Tagify(inputElm, {
            enforceWhitelist: false, //только из белого списка
            whitelist: tagifyWhitelistUserTags
        });

        // Chainable event listeners
        /* tagify.on('add', function onAddTag(e) {
            tagify.off('add', onAddTag) // exmaple of removing a custom Tagify event
        });*/
    /*  tagify.on('change', function onTagChange(e) {
            filterTasks();
        });*/
        tagify.on('input', function onInput(e) {
            tagify.settings.whitelist.length = 0; // reset current whitelist
            tagify.loading(true).dropdown.hide.call(tagify) // show the loader animation

            // get new whitelist from a delayed mocked request (Promise)
            mockAjax()
                .then(function(result) {
                    // replace tagify "whitelist" array values with new values
                    // and add back the ones already choses as Tags
                    tagify.settings.whitelist.push(...result, ...tagify.value)

                    // render the suggestions dropdown.
                    tagify.loading(false).dropdown.show.call(tagify, e.detail.value);
                })
        });
        tagify.on('focus', function onTagifyFocusBlur(e) {
            tagify.settings.whitelist.length = 0; // reset current whitelist
            tagify.loading(true).dropdown.hide.call(tagify) // show the loader animation

            // get new whitelist from a delayed mocked request (Promise)
            mockAjax()
                .then(function(result) {
                    // replace tagify "whitelist" array values with new values
                    // and add back the ones already choses as Tags
                    tagify.settings.whitelist.push(...result, ...tagify.value)

                    // render the suggestions dropdown.
                    tagify.loading(false).dropdown.show.call(tagify, e.detail.value);
                })
        });

        var mockAjax = (function mockAjax() {
            var timeout;
            return function(duration) {
                clearTimeout(timeout); // abort last request
                return new Promise(function(resolve, reject) {
                    timeout = setTimeout(resolve, duration || 0, tagifyWhitelistUserTags) 
                })
            }
        })();
        //КОНЕЦ РЕДАКТОР ТЕГОВ
    
        function afterCardTabContentLoad()
        {
            nicEditorInit();
        }
    <?php endif; ?>

    function uploadUserImage(userId) {
        $('.userCardImageForm' + userId).fileupload({
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
                        $('.userCardImageForm' + userId + ' .userCardImageImg').css('background-image', 'url(<?=config('app.uploadImageFolder')?>/avatars/thumbs/'+data.image+')');
                        $('.userCardRoot' + userId + ' .userCardImage').val(data.image);
                    }
                    else{
                        $('.userCardImageForm' + userId + ' .userCardImageImg').css('background-image', null);
                        $('.userCardRoot' + userId + ' .userCardImage').val(null);
                    }
                }
            },
            fail: function(e, data) {
                alert("Ошибка загрузки файла");
            },
        });
        $('.userCardImageForm' + userId).find("input[name='file']").click();
    }
</script>