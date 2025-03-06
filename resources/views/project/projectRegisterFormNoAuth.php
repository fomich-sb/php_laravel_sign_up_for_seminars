<div class='projectRegisterRoot projectContentSector' id='registration'>
    <div class='projectContentCaption projectContentRegisterCaption'>Регистрация</div>
    <div class='projectContentRegisterRoot'>
        <div>Для регистрации (или проверки состояния ранее поданной заявки) необходимо ввести номер телефона и подтвердить его.</div>
        <div class='projectRegisterForm'>
            <div class='formFieldRoot'>
                <div class='formFieldCaption'>Телефон</div>
                <div class='formFieldInput'>
                    <input type="tel" name="phone" class="projectContentRegisterPhone" value="+7" onkeyup='
                        if (event.keyCode === 13) 
                            $(".projectContentRegisterButtonCheckPhone").click();
                        
                        else onPhoneChange($(this), 1); 
                    '/>
                </div>
            </div>
            <div class='button buttonDisabled projectContentRegisterButtonCheckPhone' onclick='sendLoginCode(this, $(".projectContentRegisterPhone"), 1)'>Отправить код</div>
            <div class='projectContentRegisterSendMessageError'></div>
            <div class='projectContentRegisterSendMessageSuccess'></div>
            <div style='display:flex;justify-content: center;flex-wrap: wrap;'>
                <div class='button projectContentRegisterButtonCheckPhoneMessager projectContentRegisterButtonCheckPhoneMessager0' onclick='sendLoginCode(this, $(".projectContentRegisterPhone"), 1, 0)' style=' display:none;'><div class='telegramIcon' style='margin: 0 auto;  width: max-content;'>Отправить в Telegram</div></div>
                <div class='button projectContentRegisterButtonCheckPhoneMessager projectContentRegisterButtonCheckPhoneMessager1' onclick='sendLoginCode(this, $(".projectContentRegisterPhone"), 1, 1)' style=' display:none;'><div class='whatsappIcon' style='margin: 0 auto;  width: max-content;'>Отправить в WhatsApp</div></div>
            </div>
            <div class='projectContentRegisterCorrectPhoneRoot' style='display:none;'>
                <div class='formFieldRoot'>
                    <div class='formFieldCaption'>Введите код:</div>
                    <div class='formFieldInput'>
                        <input type='number' class='projectContentRegisterLoginCode' onkeyup='
                            if (event.keyCode === 13) $(".projectContentRegisterButtonCheckLoginCode").click(); 
                            else { 
                                if(this.value.length > 0) $(".projectContentRegisterButtonCheckLoginCode").removeClass("buttonDisabled"); 
                                else  $(".projectContentRegisterButtonCheckLoginCode").addClass("buttonDisabled");
                            }'>
                    </div>
                </div>
                <div class='projectContentRegisterButtonCheckLoginCodeError'></div>
                <div class='button buttonDisabled projectContentRegisterButtonCheckLoginCode' onclick='checkLoginCode(this, $(".projectContentRegisterPhone"), $(".projectContentRegisterLoginCode"), 1)'>Проверить</div>
            </div>
        </div>
    </div>
</div>
<script>
    prevPhone[1] = null;
</script>