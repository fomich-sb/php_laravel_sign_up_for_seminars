<div class='projectRegisterRoot projectContentSector' id='registration'>
    <div class='projectContentRegisterCaption'>Регистрация</div>
    <div class='projectContentRegisterRoot'>
        <div class='projectRegisterForm'>
            <div class='formFieldRoot'>
                <div class='formFieldCaption'>Телефон</div>
                <div class='formFieldInput'><input type="tel" name="phone" class="projectContentRegisterPhone" value="+<?=$user->phone?>" disabled="disabled"/></div>
            </div>
            <div class='button' onclick='logout()'>Это не мой номер телефона</div>

            <div class='projectContentRegisterStep2'>
                <div class='formFieldRoot'>
                    <div class='formFieldCaption'>Фамилия</div>
                    <div class='formFieldInput'><input name="lastname" class="projectContentRegisterName1" onkeyup="onRegisterFormChange()" value="<?=$user->name1?>" /></div>
                </div>

                <div class='formFieldRoot'>
                    <div class='formFieldCaption'>Имя</div>
                    <div class='formFieldInput'><input name="firstname" class="projectContentRegisterName2"  onkeyup="onRegisterFormChange()" value="<?=$user->name2?>" /></div>
                </div>
                <div class='formFieldRoot'>
                    <div class='formFieldCaption'>Отчество</div>
                    <div class='formFieldInput'><input name="middlename" class="projectContentRegisterName3"  onkeyup="onRegisterFormChange()" value="<?=$user->name3?>" /></div>
                </div>
                <div class='formFieldRoot'>
                    <div class='formFieldCaption'>Пол</div>
                    <div class='formFieldInput toggleControlRoot'>
                        <div>жен</div>
                        <div style='flex:0 0 auto;'>
                            <label class="toggleControl">
                                <input type="checkbox" name="gender" class='projectContentRegisterGender' <?=$user->gender ? " checked='checked' " : "" ?> >
                                <span class="control"></span>
                            </label>
                        </div>
                        <div>муж</div>
                    </div>
                </div>

                <div style='margin-top:1em;'>На английском:</div>
                <div class='formFieldRoot'>
                    <div class='formFieldCaption'>Фамилия</div>
                    <div class='formFieldInput'><input name="lastnameEn" class="projectContentRegisterNameEn1"  onkeyup="onRegisterFormChange()" value="<?=$user->nameEn1?>" /></div>
                </div>
                <div class='formFieldRoot'>
                    <div class='formFieldCaption'>Имя</div>
                    <div class='formFieldInput'><input name="firstnameEn" class="projectContentRegisterNameEn2"  onkeyup="onRegisterFormChange()"  value="<?=$user->nameEn2?>"/></div>
                </div>
                <br>
                
                <div class='formFieldRoot'>
                    <div class='formFieldCaption'>Участие</div>
                    <div class='formFieldInput toggleControlRoot'>
                        <div>очно</div>
                        <div style='flex:0 0 auto;'><label class="toggleControl">
                            <input type="checkbox" name="participationType" class='projectContentRegisterParticipationType'  >
                            <span class="control"></span>
                        </label></div>
                        <div>онлайн</div>
                    </div>
                </div>
                
                <div class='button projectContentRegisterButtonRegister' onclick='register()'>Подать заявку</div>
            </div>

            <div class='projectContentRegisterError' style='display:none'></div>
        </div>
    </div>
</div>

<script>
    onRegisterFormChange();
</script>