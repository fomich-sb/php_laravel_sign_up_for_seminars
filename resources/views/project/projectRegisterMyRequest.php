<div class='projectRegisterRoot projectContentSector' id='registration'>
    <div class='projectContentRegisterCaption'>Регистрация</div>
    <div class='projectContentRegisterRoot'>

        <div class='projectContentRegisterStatusRoot'>
            <?php if($projectUser->status > 0): ?>
                <div class='projectContentRegisterStatus projectContentRegisterStatus1'>Заявка на участие ПОДТВЕРЖДЕНА</div>
            <?php elseif($projectUser->status < 0): ?>
                <div class='projectContentRegisterStatus projectContentRegisterStatus-1'>Заявка на участие ОТКЛОНЕНА</div>
            <?php else: ?>
                <div class='projectContentRegisterStatus projectContentRegisterStatus0'>Заявка на участие НА РАССМОТРЕНИИ</div>
            <?php endif; ?>
        </div>
        <div>Проверьте личные данные:</div>
        <div style='font-size:0.8em;margin: 0 auto;width: fit-content;'>
            <div style=''>

                <div class='formFieldRoot'>
                    <div class='formFieldCaption'>Телефон</div>
                    <div class='formFieldInput'>+<?=$user->phone?></div>
                </div>
                <div class='formFieldRoot'>
                    <div class='formFieldCaption'>Фамилия</div>
                    <div class='formFieldInput'><?=$user->name1?></div>
                </div>

                <div class='formFieldRoot'>
                    <div class='formFieldCaption'>Имя</div>
                    <div class='formFieldInput'><?=$user->name2?></div>
                </div>
                <div class='formFieldRoot'>
                    <div class='formFieldCaption'>Отчество</div>
                    <div class='formFieldInput'><?=$user->name3?></div>
                </div>
                <div class='formFieldRoot'>
                    <div class='formFieldCaption'>Пол</div>
                    <div class='formFieldInput'>
                        <?=$user->gender ? 'муж' : 'жен'?>
                    </div>
                </div>

                <div style='margin-top:1em;'>На английском:</div>
                <div class='formFieldRoot'>
                    <div class='formFieldCaption'>Фамилия</div>
                    <div class='formFieldInput'><?=$user->name_en1?></div>
                </div>
                <div class='formFieldRoot'>
                    <div class='formFieldCaption'>Имя</div>
                    <div class='formFieldInput'><?=$user->name_en2?></div>
                </div>
                <br>
                <div class='formFieldRoot'>
                    <div class='formFieldCaption'>Участие</div>
                    <div class='formFieldInput'>
                        <?=$projectUser->participation_type ? 'онлайн' : 'очно'?>
                    </div>
                </div>
            </div>
            <div class='cardFooter'>
                <div class='button' onclick='openUserCard(<?=$project->id?>)' style='margin:0.5em;'>Откорректировать данные</div>
                <div class='button' onclick='logout()' style='margin:0.5em;'>Это не мой номер телефона</div>
                <?php if($project->status < $project->getStatusId('fixed')): ?>
                    <div class='button projectContentRegisterButtonDelete' onclick='deleteRegistration()' style='margin:0.5em;'>Удалить заявку</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

