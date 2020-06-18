<!DOCTYPE html> 
<html lang="fr">         
    <head>   
        <meta charset="utf-8" />
       <link rel="stylesheet" type="text/css" href="public/css/<?= $css ?>" />
       <link rel="shortcut icon" type="image/png" href="public/images/favicon.png"/>
        <title><?= $title ?></title>
    </head>
    <body>
        <header>
            <nav>
                <ul>
                    <li><a href="index.php" title="GBAF"><img src="public/images/LOGO_GBAF.png" id="logo_GBAF"></a></li>
                    <li>
                        <ul id="userBloc">
                        <?php 
                        if(isset($_SESSION['username']) AND isset($_SESSION['password']))
                        {
                        ?>
                            <li>Prénom Nom</li>
                            <li><a href="index.php?action=logout" title="Se déconnecter">Se déconnecter</a></li>
                        <?php 
                        }
                        elseif(isset($_GET['action']) AND $_GET['action'] == 'registration')
                        {
                        ?>
                            <li><a href="index.php">Déjà inscrit ? Connectez-vous !</a></li>
                        <?php
                        }
                        else
                        {
                        ?>
                            <li><a href="index.php?action=registration">Pas encore membre ? Incrivez-vous !</a></li>
                        <?php 
                        }
                        ?>
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