<div class='loginFormRoot'>
    <div class='cardHeader'>Авторизация</div>
    <div class='cardContent loginFormContent'>
        <div class='formFieldRoot'>
            <div class='formFieldCaption'>Телефон</div>
            <div class='formFieldInput'>
                <input type="tel" name="phone" class="loginFormPhone" value="+7"  
                    onkeyup='if (event.keyCode === 13) $(".loginFormButtonCheckPhone").click(); else onPhoneChange($(this)); '
                />
            </div>
        </div>
        <div class='button buttonDisabled loginFormButtonCheckPhone' onclick='sendLoginCode(this, $(".loginFormPhone"))'>Отправить код</div>
        <div class='loginFormSendMessageError'></div>
        <div class='loginFormSendMessageSuccess'></div>
        <div style='display:flex;justify-content: center;flex-wrap: wrap; margin-bottom: 1em;'>
            <div class='button loginFormButtonCheckPhoneMessager loginFormButtonCheckPhoneMessager0' onclick='sendLoginCode(this, $(".loginFormPhone"), 0, 0)' style=' display:none;'><div class='telegramIcon' style='margin: 0 auto;  width: max-content;    margin: 0.2em auto;'>Отправить в Telegram</div></div>
            <div class='button loginFormButtonCheckPhoneMessager loginFormButtonCheckPhoneMessager1' onclick='sendLoginCode(this, $(".loginFormPhone"), 0, 1)' style=' display:none;'><div class='whatsappIcon' style='margin: 0 auto;  width: max-content;    margin: 0.2em auto;'>Отправить в WhatsApp</div></div>
        </div>

        <div class='loginFormCorrectPhoneRoot' style='display:none;'>
            <div class='formFieldRoot'>
                <div class='formFieldCaption'>Введите код:</div>
                <div class='formFieldInput'>
                    <input type='number' class='loginFormLoginCode' onkeyup='
                        if (event.keyCode === 13) $(".loginFormButtonCheckLoginCode").click(); 
                        else { 
                            if(this.value.length > 0) $(".loginFormButtonCheckLoginCode").removeClass("buttonDisabled"); 
                            else  $(".loginFormButtonCheckLoginCode").addClass("buttonDisabled");
                        }'>
                </div>
            </div>
            <div class='loginFormButtonCheckLoginCodeError'></div>
            <div class='button buttonDisabled loginFormButtonCheckLoginCode' onclick='checkLoginCode(this, $(".loginFormPhone"), $(".loginFormLoginCode"))'>Войти</div>
        </div>
    </div>
</div>

