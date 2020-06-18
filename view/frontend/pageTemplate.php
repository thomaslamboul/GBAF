<!DOCTYPE html> 
<html lang="fr">         
    <head>   
        <meta charset="utf-8" />
       <link rel="stylesheet" type="text/css" href="public/css/<?= $css ?>" />
        <title><?= $title ?></title>
    </head>
    <body>
        <header>
            <nav>
                <ul>
                    <li><a href="index.php" title="GBAF"><img src="public/images/LOGO_GBAF.png" id="logo_GBAF"></a></li>
                    <li>
                        <ul id="userBloc">
                            <li>Prénom Nom</li>
                            <li><a href="index.php?action=logout" title="Se déconnecter">Se déconnecter</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </header>
        <?= $content ?>
        <footer>
            <nav>
                <ul>
                    <li><hr class="verticalSeparator"></li>
                    <li>Mentions légales</li>
                    <li><hr class="verticalSeparator"></li>
                    <li>Contact</li>
                    <li><hr class="verticalSeparator"></li>
                </ul>
            </nav>
        </footer>
    </body>
</html>