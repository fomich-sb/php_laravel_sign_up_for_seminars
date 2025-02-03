<?php

use App\Facades\L;
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!--, initial-scale=1, maximum-scale=1.0, user-scalable=0-->
    <link rel="icon" type="image/png" href="/favicon.png">
    <link rel="stylesheet" type="text/css" href="/_libs/carousel/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="/_libs/carousel/owl.theme.default.min.css">
    <link rel="stylesheet" type="text/css" href="/themes/default/style.css?v=<?=date("dmyH")?>">
    <link rel="stylesheet" type="text/css" href="/themes/default/style_admin.css?v=<?=date("dmyH")?>">
    <link rel="stylesheet" type="text/css" href="/_libs/tagify.css">

    <title><?= isset($title) ? $title : "Семинары по психологии" ?></title>
    <script>
        _token = '<?= csrf_token() ?>';
    </script>

    <script type="text/javascript" src="/_libs/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="/_libs/nicEdit.js"></script>
    <script type="text/javascript" src="/_libs/jquery-ui.js"></script>
    <script type="text/javascript" src="/_libs/tagify.min.js"></script>
    <script type="text/javascript" src="/_libs/jquery.fileupload.js"></script>
    <script type="text/javascript" src="/_libs/carousel/owl.carousel.min.js"></script>
    <script type="text/javascript" src="/_libs/scripts.js?v=<?=date("dmyH")?>"></script>
</head>

<body class='<?= (isset($bodyClass) ? $bodyClass : '') ?>'>
    <div class='mainRoot'>
        <div class='projectsMenuRoot'>
            <div class='projectsMenu'>
                <div class='projectsMenuItem'>
                    <div class='projectsMenuItemHeader'></div>
                    <a href='/admin'>
                        <div class = 'projectsMenuItemCaption'>Проекты</div>
                    </a>
                    <div class='projectsMenuItemFooter'></div>
                </div>

                <?php if(isset($project)): ?>
                    <div class='projectsMenuSubRoot'>
                        <div class='projectsMenuSubItem'>
                            <a href='/admin/project/main?project_id=<?=$project->id?>'>
                                <div class = 'projectsMenuItemCaption'>Общая информация</div>
                            </a>
                        </div>
                        <div class='projectsMenuSubItem'>
                            <a href='/admin/project/user?project_id=<?=$project->id?>'>
                                <div class = 'projectsMenuItemCaption'>Участники</div>
                            </a>
                        </div>
                        <div class='projectsMenuSubItem'>
                            <a href='/admin/project/mailing?project_id=<?=$project->id?>'>
                                <div class = 'projectsMenuItemCaption'>Рассылка</div>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

                <div class='projectsMenuItem'>
                    <div class='projectsMenuItemHeader'></div>
                    <a href='/admin/user'>
                        <div class = 'projectsMenuItemCaption'>Пользователи</div>
                    </a>
                    <div class='projectsMenuItemFooter'></div>
                </div>

                <div class='projectsMenuItem'>
                    <div class='projectsMenuItemHeader'></div>
                    <a href='/admin/certificate'>
                        <div class = 'projectsMenuItemCaption'>Сертификаты</div>
                    </a>
                    <div class='projectsMenuItemFooter'></div>
                </div>

                <div class='projectsMenuItem'>
                    <div class='projectsMenuItemHeader'></div>
                    <a href='/admin/place'>
                        <div class = 'projectsMenuItemCaption'>Места / центры</div>
                    </a>
                    <div class='projectsMenuItemFooter'></div>
                </div>

                <div class='projectsMenuItem'>
                    <div class='projectsMenuItemHeader'></div>
                    <a href='/admin/setting'>
                        <div class = 'projectsMenuItemCaption'>Общие настройки</div>
                    </a>
                    <div class='projectsMenuItemFooter'></div>
                </div>

                <div class='projectsMenuItem'>
                    <div class='projectsMenuItemHeader'></div>
                    <a href='/admin/setting/telegram'>
                        <div class = 'projectsMenuItemCaption'>Telegram API</div>
                    </a>
                    <div class='projectsMenuItemFooter'></div>
                </div>
            </div>
        </div>
        
        <div class='projectsMenuButton' onclick='$(".projectsMenuRoot").toggleClass("projectsMenuRootVisible");'></div>
        <div class='projectContentRoot' onclick='$(".projectsMenuRoot").removeClass("projectsMenuRootVisible");'>
            <?= $blockContent ?>
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
    </div>
    
    
    <div class="owl-carousel owl-theme photoSliderRoot photoSliderTemplate" style='display:none;'>
        
    </div>
    <div class="slide photoSliderSlideTemplate" style='display:none;' onclick='closeModalWindow(this);'>
        <img class="owl-lazy" src='' onclick='event.stopPropagation()'>
    </div>
</body>

</html>