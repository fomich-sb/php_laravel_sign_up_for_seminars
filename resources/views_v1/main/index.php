<div class='mainRoot'>
    <div class='projectsMenuRoot'>
        <div class='projectsMenuLogin'>
            <div class='projectsMenuButtonClose' onclick='$("body").toggleClass("projectsMenuRootVisible");'></div>
            <?php if($user): ?>
                <div class='button' onclick="openUserCard()">
                    +<?=$user->phone?>
                </div>
                <!-- div class='button buttonLogout' onclick="logout()">
                    <div class='buttonLogoutInner' title='Выйти из учетной записи'>
                        Выйти
                    </div>
                </div -->
            <?php else: ?>
                <div class='button' onclick="openLoginForm()">
                    Авторизоваться
                </div>
            <?php endif; ?>
        </div>

        <div class='projectsMenuLogo'></div>
        <div class='projectsMenuLogo2'>
            <div class='projectsMenuLogo2Inner'>Абдалова Феруза</div>
        </div>
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
    
    <div class='projectsMenuButton' onclick='$("body").toggleClass("projectsMenuRootVisible");'></div>
    <div class='projectContentRoot' onclick='$("body").removeClass("projectsMenuRootVisible");'>
        <?= $projectContent ?>
    </div>
</div>
<div class='footerRoot'>
    <div>
    © <?=date("Y");?> Абдалова Феруза Кадамовна
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
        $("body").removeClass("projectsMenuRootVisible");
    }
</script>