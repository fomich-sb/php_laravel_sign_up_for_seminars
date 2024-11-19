<div class='projectsMenuRoot'>
    <?php foreach($projectItems as $project): ?>
        <div class='projectsMenuItem projectsMenuItem<?= $project->id ?> <?= $currentProjectId == $project->id ? ' projectsMenuItemActive ' : '' ?>' data-projectid='<?= $project->id ?>'>
            <a href='?id=<?= $project->id ?>'>
                <div calss = 'projectsMenuItemDate'><?= $project->date_start ?> - <?= $project->date_end ?></div>
                <div calss = 'projectsMenuItemCaption'><?= $project->caption ?></div>
            </a>
        </div>
    <?php endforeach; ?>
</div>

<div class='projectContentRoot'>
    <?= $projectContent ?>
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
        currentProjectId = projectId;
        $('.projectsMenuItemActive').removeClass('projectsMenuItemActive');
        $('.projectsMenuItem'+projectId).addClass('projectsMenuItemActive');

        history.pushState({
            'projectId': projectId
        }, $(el).find('.projectsMenuItemCaption').text(), $(el).find('a').prop('href'));

        let data = {
            'projectId': projectId,
            '_token': _token,
        };
        fetch('/main/getProjectContent', {
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

        });
    }

    function onPhoneChange(){
        $('.projectContentRegisterStep2, .projectContentRegisterPhoneError, .projectContentRegisterNeedAuth').hide();
        $('.projectContentRegisterButtonCheckPhone').show();
        var phone = getPhone();
        if(!phone || phone.substr(0, 1)=="7" && phone.length != 11 || phone.length < 8)
        {
            $('.projectContentRegisterButtonCheckPhone').addClass('buttonDisabled');
        }
        else
        {
            $('.projectContentRegisterButtonCheckPhone').removeClass('buttonDisabled');
        }
    }

    function getPhone()
    {
        var numberPattern = /\d+/g;
        return $('.projectContentRegisterPhone').val().match( numberPattern ).join('');
    }

    function findPhone()
    {
        if($('.projectContentRegisterButtonCheckPhone').hasClass('buttonDisabled'))
            return;

        let data = {
            'projectId': currentProjectId,
            'phone': getPhone(),
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
    }

    function onRegisterFormChange()
    {
        if(
            $('.projectContentRegisterStep2 .projectContentRegisterName1').val().trim().length == 0 || 
            $('.projectContentRegisterStep2 .projectContentRegisterName2').val().trim().length == 0 || 
            $('.projectContentRegisterStep2 .projectContentRegisterName3').val().trim().length == 0 || 
            $('.projectContentRegisterStep2 .projectContentRegisterNameEn1').val().trim().length == 0 || 
            $('.projectContentRegisterStep2 .projectContentRegisterNameEn2').val().trim().length == 0
        )
            $('.projectContentRegisterButtonRegister').addClass('buttonDisabled');
        else
            $('.projectContentRegisterButtonRegister').removeClass('buttonDisabled');

    }

    function register()
    {
        if($('.projectContentRegisterButtonRegister').hasClass('buttonDisabled'))
            return;

        let data = {
            'projectId': currentProjectId,
            'phone': getPhone(),
            'name1': $('.projectContentRegisterStep2 .projectContentRegisterName1').val(),
            'name2': $('.projectContentRegisterStep2 .projectContentRegisterName2').val(),
            'name3': $('.projectContentRegisterStep2 .projectContentRegisterName3').val(),
            'nameEn1': $('.projectContentRegisterStep2 .projectContentRegisterNameEn1').val(),
            'nameEn2': $('.projectContentRegisterStep2 .projectContentRegisterNameEn2').val(),
            'gender': $('.projectContentRegisterStep2 input[name="gender"]:checked').val(),
            '_token': _token,
        };
        fetch('/projectUser/register', {
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
            $('.projectContentRegisterRoot').hide();
            $('.projectContentRegisterDoneRoot').show();
        });
    }

    function sendLoginCode(elButton)
    {
        if($(elButton).hasClass('buttonDisabled'))
            return;
        let data = {
            'phone': getPhone(),
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
            $(elButton).addClass('buttonDisabled');
        });
    }

    function checkLoginCode(elButton)
    {
        if($(elButton).hasClass('buttonDisabled'))
            return;
        let data = {
            'phone': getPhone(),
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
    }
    
</script>