<?php

use App\Facades\L;
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0">
    <?php if (isset($game) && config('gameImagesFolder') && $game->image && strlen($game->image) > 0) : ?>
        <link rel="icon" type="image/png" href="<?= config('gameImagesFolder') ?>/<?= $game->id ?>/<?= $game->image ?>">
    <?php else : ?>
        <link rel="icon" type="image/png" href="/<?= config('gameCode') ?>/favicon.png">
    <?php endif; ?>
    <link rel="stylesheet" type="text/css" href="/_libs/style.css?v=<?=date("dmyH")?>">

    <title><?= $title ?></title>
    <script type="text/javascript" src="/_libs/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="/_libs/utils.js"></script>


    <script>
        _token = '<?= csrf_token() ?>';
        const gameCode = '<?= config('gameCode') ?>';
        const gameURL = '<?= config('gameURL') ?>';
        var currentLocaleCode = '<?= L::getLocaleCode() ?>';
    </script>

    <link rel="stylesheet" type="text/css" href="/_libs/admin_style.css?v=<?=date("dmyH")?>">
    <script type="text/javascript" src="/_libs/admin_utils.js"></script>
    <script type="text/javascript" src="/_libs/nicEdit.js"></script>
    <script type="text/javascript" src="/_libs/jquery-ui.js"></script>
    <script src="/_libs/jquery.ui.touch-punch.js?v=q"></script>
    <script src="/_libs/jquery.ui.widget.js"></script>
    <script src="/_libs/jquery.iframe-transport.js"></script>
    <script src="/_libs/jquery.fileupload.js"></script>

</head>

<body class='<?= (isset($bodyClass) ? $bodyClass : '') ?>'>
    <div class='top_settings_button' onclick='showSettingsWin(-1, gameCode);'></div>
    <div style='display:none;' id='modalWinTemplate' onclick='closeModalWindow(this);' class='pop_up_win'>
        <div class='pop_up_top'>

        </div>
        <div class='pop_up_middle' onclick='event.stopPropagation();'>
            <div class='pop_up_content_root'>
                <div class='pop_up_win_close_button' onclick='closeModalWindow(this);'></div>
                <div class='pop_up_content'></div>
            </div>
        </div>
        <div class='pop_up_bottom'></div>
    </div>
    <div class='modalWin' id='modalWin' onclick='modalWinHide()'>
        <div style='flex:1 1 auto;'></div>
        <div class='modalWinContent' style='overflow: auto;'>

        </div>
        <div style='flex:2 1 auto;'></div>

        <script>
            function modalWinHide() {
                $('#modalWin').hide();
            }
        </script>
    </div>
    <div style='display: flex; flex: 1 1 auto;overflow: hidden;'>
        <div style='flex: 0 0 auto; width:200px;border-right: 2px solid #EEE; display:flex; flex-direction: column;  overflow: auto;'>

            <div style='flex: 5 1 auto; max-height:250px;'>
                <?= (isset($blockMenu) ? $blockMenu : '') ?>
            </div>
            <div style='flex:1 1 auto'></div>
            <div style='flex: 0 0 auto; '>
                <?= (isset($blockGameMenu) ? $blockGameMenu : '') ?>
            </div>
            <div style='flex:1 1 auto'></div>
            <div style='flex: 0 0 auto; '>
                <?= (isset($blockControlPanel) ? $blockControlPanel : '') ?>
            </div>
            <div style='flex:1 1 auto'></div>
            <div style='flex: 0 0 auto; '>
                <?= (isset($blockBottomMenu) ? $blockBottomMenu : '') ?>
            </div>
        </div>
        <div style='flex: 1 1 auto;  display:flex; flex-direction:column; overflow-x: hidden;'>
            <?php if (isset($game)) : ?>

                <div style='flex: 0 0 auto;' id='adminGameStatusBlock'>
                    <br>
                    <?php echo view('elements/gameAndStageStatusDiv', [
                        'game' => $game,
                    ]);
                    ?>
                </div>
            <?php endif; ?>
            <div style='flex: 1 1 auto; overflow: auto; position: relative; padding-bottom:100px;display: flex; flex-direction: column;' id='adminBlockContent'>

                <?= (isset($blockContent) ? $blockContent : '') ?>
            </div>

        </div>
    </div>

    <script type="text/javascript" src="/_libs/websocket.js"></script>
    <script>
        $(window).on('load', function () {
            let scrollTop = get('scrollTop');
            if(scrollTop){
                $('#adminBlockContent').scrollTop(scrollTop);
            }
        });

        <?php
            $wsParams=[];
            $wsParams['game_id'] = (isset($game_id) ? $game_id : (isset($game) ? $game->id : -1));
            $wsParams['admin_game_id'] = (isset($game_id) ? $game_id : (isset($game) ? $game->id : -1));
        ?>
        init_websocket('<?=config('app.webSocketSSLEnabled') ? 'wss://'.config('app.webSocketURLForClient') : 'ws://'.config('app.webSocketURLForClient')?>', '<?= config('gameCode') ?>', <?=json_encode($wsParams)?>);
    </script>
    

    <?= view('gameViews/cookieAccept') ?>

</body>

</html>