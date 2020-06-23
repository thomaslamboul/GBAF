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
                    <li><a href="index.php" title="GBAF"><img src="public/images/LOGO_GBAF.png" class="logo"></a></li>
                    <li>
                        <ul id="userBlock">
                        <?php 
                        if(isset($_SESSION['username']) AND isset($_SESSION['password']))
                        {
                        ?>
                            <li><a href="" title="Paramètres de l'utilisateur" id="test"><img src="public/images/logo_profil.png" class="logo" id="logo_profil"><?=$_SESSION['lastname'] .' '. $_SESSION['firstname']?></a></li>
                            <li><a href="index.php?action=logout" title="Déconnexion" class="navButton">Se déconnecter</a></li>
                        <?php 
                        }
                        elseif(isset($_GET['action']) AND $_GET['action'] == 'registration')
                        {
                        ?>
                            <li><a href="index.php" title="Se connecter" class="navButton">Déjà inscrit ? Connectez-vous !</a></li>
                        <?php
                        }
                        else
                        {
                        ?>
                            <li><a href="index.php?action=registration" title="S'inscrire" class="navButton">Pas encore membre ? Incrivez-vous !</a></li>
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