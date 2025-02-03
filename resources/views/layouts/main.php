<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
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

    <script>
        let _token = '<?= csrf_token() ?>';
    </script>
</head>

<body class='<?= (isset($bodyClass) ? $bodyClass : '') ?>'>
    <?= $blockContent ?>
    
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