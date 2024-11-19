<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <link rel="icon" type="image/png" href="/favicon.png">
    <link rel="stylesheet" type="text/css" href="/themes/default/style.css?v=<?=date("dmyH")?>">

    <title><?= isset($title) ? $title : "Семинары по психологии" ?></title>
    <script type="text/javascript" src="/_libs/jquery-3.4.1.min.js"></script>

    <script>
        let _token = '<?= csrf_token() ?>';
    </script>
</head>

<body class='<?= (isset($bodyClass) ? $bodyClass : '') ?>'>
    <?= $blockContent ?>
</body>

</html>