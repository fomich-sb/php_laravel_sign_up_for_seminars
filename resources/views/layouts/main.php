<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1"><!--, initial-scale=1, maximum-scale=1.0, user-scalable=0-->
    <link rel="icon" type="image/png" href="/favicon.png">
    <link rel="stylesheet" type="text/css" href="/_libs/tagify.css">
    <link rel="stylesheet" type="text/css" href="/_libs/carousel/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="/_libs/carousel/owl.theme.default.min.css">
    <link rel="stylesheet" type="text/css" href="/themes/default/style.css?v=<?=date("dmyH")?>">

    <title><?= isset($title) ? $title : "Семинары по психологии" ?></title>
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
            <div class='headerMenuItemMenu' onclick='$("body").toggleClass("menuVisibled")'><div class='headerMenuItemMenuIcon'></div>Меню</div>
            <div class='headerMenuItemLogo'></div>
            <div class='headerMenuItem' onclick='openSection("mainPageIndex")'>Главная</div>
            <div class='headerMenuItem' onclick='openSection("mainPageProjectsFuture")'>Предстоящие семинары</div>
            <div class='headerMenuItem' onclick='openSection("mainPageMyProjects")'>Ваши семинары</div>
            <div class='headerMenuItem' onclick='openSection("mainPageAbout")'>Обо мне</div>
        </div>
    </div>
    <div class='bgRootBlur'></div>
    <div class='bgRoot'></div>

    <div class='mainRoot' <?=$currentProjectId ? "style='display:none;'" : ""?>>
        <?= $mainContent ?>
    </div>
    <div class='projectRoot' <?=!$currentProjectId ? "style='display:none;'" : ""?>>
        <div class='projectContentRoot'>
            <div class="mainButton backButton" onclick="$('.projectRoot').hide();$('.mainRoot').show();">Вернуться</div>
            <div class='projectContent'>
                <?= $projectContent ?>
            </div>
        </div>
    </div>
    <div class='footerRoot'>
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
    $('.projectsMenuRoot a').on('click', function(e) {
        event.preventDefault();
        openProject(this);
    });

    function openProject(el)
    {
        var projectId = el.dataset.projectid;
        history.pushState({
            'projectId': projectId
        }, $(el).find('.projectsMenuItemCaption').text(), $(el).prop('href'));
        loadProject(projectId);
    }
    function loadProject(projectId, anchor = null)
    {
        $(".mainRoot").hide();
        $(".projectRoot").hide();
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
        $("body").removeClass("menuVisibled");
        $(".mainRoot").show();
        $(".projectRoot").hide();
        $(".mainOnePageSlider").moveTo($(".mainOnePageSlider .section").toArray().indexOf($('#'+sectionId)[0]) + 1);
    }
</script>