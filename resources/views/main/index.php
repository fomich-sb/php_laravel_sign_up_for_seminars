<div class='mainRoot'>
    <div class='projectsMenuRoot'>
        <div class='projectsMenuLogin'>
            <?php if($user): ?>
                <div class='button' onclick="openUserCard()">
                    +<?=$user->phone?>
                </div>
                <div class='button buttonLogout' onclick="logout()">
                    <div class='buttonLogoutInner' title='Выйти из учетной записи'>
                        Выйти
                    </div>
                </div>
            <?php else: ?>
                <div class='button' onclick="openLoginForm()">
                    Авторизоваться
                </div>
            <?php endif; ?>
        </div>

        <div class='projectsMenuLogo'></div>
        <?php if($user && $user->admin): ?>
            <div class='projectsMenuItem'>
                <div class='projectsMenuItemHeader'></div>
                <div class = 'projectsMenuItemCaption' onclick='window.open("/admin/")'>Панель администрирования</div>
                <div class='projectsMenuItemFooter'></div>
            </div>
        <?php endif; ?>
        <div class='projectsMenuItemsRoot'>
            <?php foreach($projectItems as $project): ?>
                <div class='projectsMenuItem projectsMenuItem<?= $project->id ?> <?= $currentProjectId == $project->id ? ' projectsMenuItemActive ' : '' ?>' data-projectid='<?= $project->id ?>'>
                    <div class='projectsMenuItemHeader'></div>
                    <a href='/?id=<?= $project->id ?>'>
                        <div class = 'projectsMenuItemDate'><?= $project->dates ?></div>
                        <div class = 'projectsMenuItemCaption'><?= $project->caption ?></div>
                    </a>
                    <div class='projectsMenuItemFooter'></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class='projectsMenuButton' onclick='$(".projectsMenuRoot").toggleClass("projectsMenuRootVisible");'></div>

    <div class='projectContentRoot' onclick='$(".projectsMenuRoot").removeClass("projectsMenuRootVisible");'>
        <?= $projectContent ?>
    </div>
</div>
<div class='footerRoot'>
    <div>
        Что-то
    </div>
</div>

<script>
    var currentProjectId = <?= $currentProjectId ? $currentProjectId : 0 ?>;
    $('.projectsMenuRoot a').on('click', function(e) {
        event.preventDefault();
        openProject(this.parentNode);
    });

    function openProject(el)
    {
        var projectId = el.dataset.projectid;
        history.pushState({
            'projectId': projectId
        }, $(el).find('.projectsMenuItemCaption').text(), $(el).find('a').prop('href'));
        loadProject(projectId);
    }
    function loadProject(projectId, anchor = null)
    {
        if(currentProjectId != projectId)
            window.scrollTo({top: 0, behavior: 'smooth'});

        currentProjectId = projectId;
        $('.projectsMenuItemActive').removeClass('projectsMenuItemActive');
        $('.projectsMenuItem'+projectId).addClass('projectsMenuItemActive');


        let data = {
            'projectId': projectId,
            '_token': _token,
        };
        fetch('/project/getContent', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success !== 1){
                console.log(data.error);
                $('.projectContentRoot').text('');
                return;
            }
            $('.projectContentRoot').html(data.content);
            if(anchor){
                let el = $("." + anchor);
                if(el.length>0)
                    $('html, body').scrollTop(el.offset().top);
            }
        });
        $(".projectsMenuRoot").removeClass("projectsMenuRootVisible");
    }
  /*  var prevPhone = null;
    function onPhoneChange(phoneEl){
        var phone = getPhone(phoneEl);
        if(prevPhone != phone)
        {
            $('.projectContentRegisterStep2, .projectContentRegisterPhoneError, .projectContentRegisterNeedAuth').hide();
            $('.projectContentRegisterButtonCheckPhone').show();
        }
        prevPhone = phone;
        if(!phone || phone.substr(0, 1)=="7" && phone.length != 11 || phone.length < 8)
        {
            $('.projectContentRegisterButtonCheckPhone').addClass('buttonDisabled');
        }
        else
        {
            $('.projectContentRegisterButtonCheckPhone').removeClass('buttonDisabled');
        }
    }

    function getPhone(phoneEl)
    {
        var numberPattern = /\d+/g;
        return phoneEl.val().match( numberPattern ).join('');
    }

    function findPhone(phoneEl)
    {
        if($('.projectContentRegisterButtonCheckPhone').hasClass('buttonDisabled'))
            return;

        let data = {
            'projectId': currentProjectId,
            'phone': getPhone(phoneEl),
            '_token': _token,
        };
        fetch('/projectUser/findPhone', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success !== 1){
                $('.projectContentRegisterError').text(data.error).show();
                return;
            }
            $('.projectContentRegisterError').hide();

            if(data.user){
                $('.projectContentRegisterNeedAuth').show();
                if(data.projectUser){
                    $('.projectContentRegisterAllreadyRegistered').show();
                    $('.projectContentRegisterUserExist').hide();
                }
                else {
                    $('.projectContentRegisterAllreadyRegistered').hide();
                    $('.projectContentRegisterUserExist').show();
                }
            } 
            else 
            {
                $('.projectContentRegisterStep2').show();
                onRegisterFormChange();
            }
            $('.projectContentRegisterButtonCheckPhone').hide();
        });
    }*/


  /*  function sendLoginCode(elButton, phoneEl)
    {
        if($(elButton).hasClass('buttonDisabled'))
            return;

        $(elButton).addClass('buttonDisabled');
        setTimeout(function() { $(elButton).removeClass('buttonDisabled'); }, 10000)
        let data = {
            'phone': getPhone(phoneEl),
            '_token': _token,
        };
        fetch('/user/sendLoginCode', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success !== 1){
                console.log(data.error);
                return;
            }
        });
    }*/

    /*function checkLoginCode(elButton, phoneEl, codeEl)
    {
        if($(elButton).hasClass('buttonDisabled'))
            return;

        let data = {
            'phone': getPhone(phoneEl),
            'code': codeEl.val(),
            '_token': _token,
        };
        fetch('/user/checkLoginCode', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success !== 1){
                $('.projectContentRegisterButtonCheckLoginCodeError').text(data.error);
                return;
            }
            document.location.reload();
        });
    }*/
    
</script>