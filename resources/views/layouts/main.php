<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1"><!--, initial-scale=1, maximum-scale=1.0, user-scalable=0-->
    
    <title><?= isset($title) ? $title : "Семинары по транзактному анализу | Феруза Абдалова | Психолог" ?></title>
    <meta property="og:url" content="https://firapsy.ru">
    <meta property="og:title" content="Семинары по транзактному анализу | Феруза Абдалова | Психолог">
    <meta property="og:description" content="">
    <meta property="og:type" content="website">
    <meta property="og:image" content="https://firapsy.ru/themes/default/favicon.png">
    <link rel="canonical" href="https://firapsy.ru">

    <link rel="icon" type="image/png" href="/themes/default/favicon.png">
    <link rel="stylesheet" type="text/css" href="/_libs/tagify.css">
    <link rel="stylesheet" type="text/css" href="/_libs/carousel/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="/_libs/carousel/owl.theme.default.min.css">
    <link rel="stylesheet" type="text/css" href="/themes/default/style.css?v=<?=date("dmyH")?>">
    <?php if($subtheme): ?>
        <link rel="stylesheet" type="text/css" href="/themes/default/subthemes/<?=$subtheme?>/style.css?v=<?=date("dmyH")?>">
    <?php endif; ?>

    <script type="text/javascript" src="/_libs/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="/_libs/nicEdit.js"></script>
    <script type="text/javascript" src="/_libs/jquery-ui.js"></script>
    <script type="text/javascript" src="/_libs/tagify.min.js"></script>
    <script type="text/javascript" src="/_libs/jquery.fileupload.js"></script>
    <script type="text/javascript" src="/_libs/carousel/owl.carousel.min.js"></script>
    <script type="text/javascript" src="/_libs/scripts.js?v=<?=date("dmyH")?>"></script>

    <script type="text/javascript" src="/_libs/jquery.onepage-scroll.js?v=1"></script>

    <script>
        let _token = '<?= csrf_token() ?>';
    </script>
</head>

<body class='<?= (isset($bodyClass) ? $bodyClass : '') ?>'>
    <div class='headerRoot'>
        <div class='headerMenu'>
            <?php if($user): ?>
                <div class='headerMenuItemMobile' onclick="openUserCard()">
                    <div class='headerMenuItemUserIcon'></div>
                    +<?=$user->phone?>
                </div>
            <?php else: ?>
                <div class='headerMenuItemMobile' onclick='openLoginForm()'>
                    <div class='headerMenuItemUserIcon'></div>Войти</div>
            <?php endif; ?>
            <div class='headerMenuItemMobile' onclick='openSection("mainPageProjectsFuture")'>Семинары</div>
            <div class='headerMenuItemMenu' onclick='$("body").toggleClass("menuVisibled")'><div class='headerMenuItemMenuIcon'></div>Меню</div>

            <div class='headerMenuItemLogo' onclick='openSection("mainPageIndex")'></div>
            <div class='headerMenuItem' onclick='openSection("mainPageProjectsFuture")'>Предстоящие семинары</div>
            <div class='headerMenuItem' onclick='openSection("mainPageMyProjects")'>Ваши семинары</div>
            <div class='headerMenuItem' onclick='openSection("mainPageAbout")'>Обо мне</div>
            <?php if($user): ?>
                <div class='headerMenuItem ' onclick="openUserCard()">
                    <div class='headerMenuItemUserIcon'></div>
                    +<?=$user->phone?>
                </div>
            <?php else: ?>
                <div class='headerMenuItem' onclick='openLoginForm()'>
                    <div class='headerMenuItemUserIcon'></div>Войти</div>
            <?php endif; ?>

            <?php if($user && $user->admin): ?>
                <div class='headerMenuItem' onclick='window.open("/admin/")'>Админка</div>
            <?php endif; ?>
        </div>
    </div>
    <div class='bgRootBlur'></div>
    <div class='bgRoot'></div>

    <div class='mainRoot' <?=$currentProjectId ? "style='display:none;'" : ""?>  onclick='$("body").removeClass("menuVisibled")'>
        <?= $mainContent ?>
    </div>
    <div class='projectRoot' <?=!$currentProjectId ? "style='display:none;'" : ""?>   onclick='$("body").removeClass("menuVisibled")'>
        <div class='projectContentRoot'>
            <div class="mainButton backButton" onclick="openPage({'historyCaption': document.title,'historyUrl': '/',});">Вернуться</div>
            <div class='projectContent'>
                <?= $projectContent ?>
            </div>
        </div>
    </div>
    <div class='footerRoot'   onclick='$("body").removeClass("menuVisibled")'>
        <div class='footerInner'>
        © <?=date("Y");?> Абдалова Феруза Кадамовна
        </div>
    </div>
    
    
    <div style='display:none;' id='modalWinTemplate' onclick='closeModalWindow(this);' class='pop_up_win'>
        <div class='pop_up_top'>

        </div>
        <div class='pop_up_middle' onclick='event.stopPropagation();'>
            <div class='pop_up_content_root'>
                <div class='pop_up_win_close_button' onclick='closeModalWindow(this);'><div class='pop_up_win_close_button_inner'></div></div>
                <div class='pop_up_content'></div>
            </div>
        </div>
        <div class='pop_up_bottom'></div>
    </div>

    
    <div class="owl-carousel owl-theme photoSliderRoot photoSliderTemplate" style='display:none;'>
        
    </div>
    <div class="slide photoSliderSlideTemplate" style='display:none;' onclick='closeModalWindow(this);'>
        <img class="owl-lazy" src='' onclick='event.stopPropagation()'>
    </div>

</body>

</html>



<script>
    var currentProjectId = <?= $currentProjectId ? $currentProjectId : 0 ?>;
    window.addEventListener('popstate', function(event) {
        if($_GET('id')){
            loadProject($_GET('id'));
        } else {
            $('.projectRoot').hide();
            $('.mainRoot').show();
            currentProjectId = 0;
        }

       /* if (event.state && event.state.projectId) {
            loadProject(event.state.projectId);
        } else {
            $('.projectRoot').hide();
            $('.mainRoot').show();
            currentProjectId = 0;
        }*/
    });
    
    $('.projectsMenuRoot a').on('click', function(event) {
        event.preventDefault();
        openPage({
            'projectId': this.dataset.projectid,
            'historyCaption': $(this.parentNode).find('.projectsMenuItemCaption').text(),
            'historyUrl': this.href,
        });
    });
    
    function openPage(param)
    {
        if(param.projectId){
            history.pushState({
                'projectId': param.projectId
            }, param.historyCaption, param.historyUrl);
            loadProject(param.projectId);
        }
        else{
            history.pushState({ }, param.historyCaption, param.historyUrl);
            $('.projectRoot').hide();
            $('.mainRoot').show();
            currentProjectId = 0;
        }
    }
    function loadProject(projectId, anchor = null)
    {
        $(".mainRoot").hide();
    //    $(".projectRoot").hide();
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
                $('.projectContent').text('');
                $(".mainRoot").show();
                return;
            }
            $('.projectContent').html(data.content);
            if(anchor){
                let el = $("." + anchor);
                if(el.length>0)
                    $('html, body').scrollTop(el.offset().top);
            }
            $(".projectRoot").show();
        });
        $("body").removeClass("projectsMenuRootVisible");
    }

    
    function openSection(sectionId)
    {
        if(currentProjectId)
            openPage({'historyCaption': document.title,'historyUrl': '/',});

        $("body").removeClass("menuVisibled");
        $(".mainRoot").show();
        $(".projectRoot").hide();
        
        document.getElementById(sectionId).scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        })
    }

    function $_GET(key) {
        var p = window.location.search;
        p = p.match(new RegExp(key + '=([^&=]+)'));
        return p ? p[1] : false;
    }
</script>