<!DOCTYPE html> 
<html lang="fr">         
    <head>   
        <meta charset="utf-8" />
       <link rel="stylesheet" type="text/css" href="public/css/<?= $css ?>" />
        <title><?= $title ?></title>
    </head>
    <body>
        <header>
            <img src="public/images/LOGO_GBAF.png" id="logo">
        </header>
        <?= $content ?>
        <footer>
            <p>Mentions légales</p>
            <p>Contact</p>
        </footer>
    </body>
</html>