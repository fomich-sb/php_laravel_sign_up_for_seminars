<div class='projectRegisterRoot projectContentSector'>
    <div class='projectContentRegisterCaption'>Регистрация</div>
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