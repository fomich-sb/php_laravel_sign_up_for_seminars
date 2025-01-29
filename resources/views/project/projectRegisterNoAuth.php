<div class='projectRegisterRoot projectContentSector'>
    <div class='projectContentRegisterCaption'>Регистрация</div>
    <div class='projectContentRegisterRoot'>
        <div class='projectRegisterForm'>
            <div class='formFieldRoot'>
                <div class='formFieldCaption'>Телефон</div>
                <div class='formFieldInput'><input type="tel" name="phone" class="projectContentRegisterPhone" value="+7" onkeyup='if (event.keyCode === 13) {findPhone($(".projectContentRegisterPhone"))} else onPhoneChange($(this)); '/></div>
            </div>
            <div class='button buttonDisabled projectContentRegisterButtonCheckPhone' onclick='findPhone($(".projectContentRegisterPhone"))'>Далее</div>

            <div class='projectContentRegisterStep2' style="display:none;">

                <div class='formFieldRoot'>
                    <div class='formFieldCaption'>Фамилия</div>
                    <div class='formFieldInput'><input name="lastname" class="projectContentRegisterName1" onkeyup="onRegisterFormChange()" /></div>
                </div>

                <div class='formFieldRoot'>
                    <div class='formFieldCaption'>Имя</div>
                    <div class='formFieldInput'><input name="firstname" class="projectContentRegisterName2"  onkeyup="onRegisterFormChange()"/></div>
                </div>
                <div class='formFieldRoot'>
                    <div class='formFieldCaption'>Отчество</div>
                    <div class='formFieldInput'><input name="middlename" class="projectContentRegisterName3"  onkeyup="onRegisterFormChange()"/></div>
                </div>
                <div class='formFieldRoot'>
                    <div class='formFieldCaption'>Пол</div>
                    <div class='formFieldInput toggleControlRoot'>
                        <div>жен</div>
                        <div style='flex:0 0 auto;'>
                            <label class="toggleControl">
                                <input type="checkbox" name="gender" class='projectContentRegisterGender'>
                                <span class="control"></span>
                            </label>
                        </div>
                        <div>муж</div>
                    </div>
                </div>
                <div class='formFieldRoot'>
                    <div class='formFieldCaption'>Участие</div>
                    <div class='formFieldInput toggleControlRoot'>
                        <div>очно</div>
                        <div style='flex:0 0 auto;'><label class="toggleControl">
                            <input type="checkbox" name="participationType" class='projectContentRegisterParticipationType'>
                            <span class="control"></span>
                        </label></div>
                        <div>онлайн</div>
                    </div>
                </div>

                <div style='margin-top:1em;'>На английском:</div>
                <div class='formFieldRoot'>
                    <div class='formFieldCaption'>Фамилия</div>
                    <div class='formFieldInput'><input name="lastnameEn" class="projectContentRegisterNameEn1"  onkeyup="onRegisterFormChange()"/></div>
                </div>
                <div class='formFieldRoot'>
                    <div class='formFieldCaption'>Имя</div>
                    <div class='formFieldInput'><input name="firstnameEn" class="projectContentRegisterNameEn2"  onkeyup="onRegisterFormChange()"/></div>
                </div>
                
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
                <div class='projectContentRegisterUserExist'>Для этого необходимо получить код по телефону и ввести его ниже.</div>
                <div class='button projectContentRegisterButtonSendLoginCode' onclick='sendLoginCode(this, $(".projectContentRegisterPhone"))'>Отправить код</div>
                <div class='formFieldRoot'>
                    <div class='formFieldCaption'>Введите код:</div>
                    <div class='formFieldInput'><input type='number' class='projectContentRegisterLoginCode' onkeyup='if (event.keyCode === 13) {checkLoginCode(this, $(".projectContentRegisterPhone"), $(".projectContentRegisterLoginCode"))} else { if(this.value.length > 0) $(".projectContentRegisterButtonCheckLoginCode").removeClass("buttonDisabled"); else  $(".projectContentRegisterButtonCheckLoginCode").addClass("buttonDisabled");}'></div>
                </div>
                <div class='projectContentRegisterButtonCheckLoginCodeError'></div>
                <div class='button buttonDisabled projectContentRegisterButtonCheckLoginCode' onclick='checkLoginCode(this, $(".projectContentRegisterPhone"), $(".projectContentRegisterLoginCode"))'>Проверить код</div>
            </div>

            <div class='projectContentRegisterError' style='display:none'></div>
        </div>
        <div class='projectContentRegisterDoneRoot' style='display:none'>
            Заявка зарегистрирована.
        </div>
    </div>
</div>

