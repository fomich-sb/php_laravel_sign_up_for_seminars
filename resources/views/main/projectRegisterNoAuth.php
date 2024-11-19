<div class='projectRegisterRoot'>
    <div class='projectContentRegisterRoot'>
        <div class='projectContentRegisterCaption'>Регистрация</div>
        <div>Телефон: <input type="tel" name="phone" class="projectContentRegisterPhone" value="+7" onkeyup="onPhoneChange()"/></div>
        <div class='button buttonDisabled projectContentRegisterButtonCheckPhone' onclick='findPhone()'>Далее</div>

        <div class='projectContentRegisterStep2' style="display:none;">
            <div>Фамилия: <input name="lastname" class="projectContentRegisterName1" onkeyup="onRegisterFormChange()" /></div>
            <div>Имя: <input name="firstname" class="projectContentRegisterName2"  onkeyup="onRegisterFormChange()"/></div>
            <div>Отчество: <input name="middlename" class="projectContentRegisterName3"  onkeyup="onRegisterFormChange()"/></div>
            <div>Пол: 
                <label><input type="radio" name="gender" class="projectContentRegisterGender0" value="0" checked /> Жен</label>
                <label><input type="radio" name="gender" class="projectContentRegisterGender1" value="1" /> Муж</label>
            </div>
            <div>На английском:</div>
            <div>Фамилия: <input name="lastnameEn" class="projectContentRegisterNameEn1"  onkeyup="onRegisterFormChange()"/></div>
            <div>Имя: <input name="firstnameEn" class="projectContentRegisterNameEn2"  onkeyup="onRegisterFormChange()"/></div>
            <div class='button buttonDisabled projectContentRegisterButtonRegister' onclick='register()'>Подать заявку</div>
        </div>

        <div class='projectContentRegisterNeedAuth' style="display:none;">
            <div class='projectContentRegisterAllreadyRegistered' style="display:none;">
                <div>Заявка на участие с этим номером уже подана.</div>
                <div>Для просмотра статуса заявки и редактирования личных данных необходимо авторизоваться в системе.</div>
            </div>
            <div class='projectContentRegisterUserExist' style="display:none;">
                <div>Пользователь с данным номером телефона уже зарегистрирован.</div>
                <div>Для подачи заявок необходимо авторизоваться в системе.</div>
            </div>
            <div>Для этого необходимо получить код сообщением в Telegram.</div>
            <div class='button projectContentRegisterButtonSendLoginCode' onclick='sendLoginCode(this)'>Отправить код</div>
            Введите код: <input type='number' class='projectContentRegisterButtonLoginCode'>
            <div class='projectContentRegisterButtonCheckLoginCodeError'></div>
            <div class='button projectContentRegisterButtonCheckLoginCode' onclick='checkLoginCode()'>Проверить код</div>
        </div>

        <div class='projectContentRegisterError' style='display:none'></div>
    </div>
    <div class='projectContentRegisterDoneRoot' style='display:none'>
        Заявка зарегистрирована.
    </div>
</div>

