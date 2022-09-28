<?php

require 'vendor/autoload.php';
include_once 'app/urlGenerator.php';

$config = include_once 'config.php';
$db = new \App\BD($config['dbhost'], $config['dbbase'],$config['dbuser'],$config['dbpassword']);

if($_SERVER['REQUEST_URI'] != '/') {
    $urlRow = $db->getLinks(['short_link' => 'http://'.$_SERVER["HTTP_HOST"] . $_SERVER['REQUEST_URI']]);
    if(!empty($urlRow))
        header('Location: '.$urlRow[0]['long_link']);
}

if(!empty($_POST))
    $shortUrl = urlGenerate($db, $_POST['url']);

$linesLinks = $db->getLinks();

?>

<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Укоротитель ссылок</title>
        <link rel="stylesheet" href="/assets/style.css">
    </head>
    <body class="neon-text">
        <div class="background">
            <div class="input-line">
                <form method="post" action="/">
                    <p>Insert long link -> </p>
                    <input id="field" name="url" class="neon-text" type="url">
                    <input id="submit" type="submit" class="neon-text" value="Generate">
                </form>

            </div>
            <?php if(!empty($_POST)): ?>
                <div class="result-line">
                    Your short URL: <a href="<?=$shortUrl?>"><?=$shortUrl?></a><br><br>
                </div>
            <?php endif; ?>
            <div class="outout-line">
                <?php if(!empty($linesLinks)): ?>
                    <?php foreach($linesLinks as $row):?>
                        <a><?=$row['long_link']?></a> ---------> <a href="<?=$row['short_link']?>"><?=$row['short_link']?></a> <--------- (<?=$row['created_at']?>)<br>
                    <?php endforeach?>
                <?php endif?>
            </div>
        </div>

        <script>

        </script>
    </body>
</html>
