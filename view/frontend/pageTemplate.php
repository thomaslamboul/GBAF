<!DOCTYPE html> 
<html lang="fr">         
    <head>   
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" type="text/css" href="public/css/<?= $css ?>"/>
        <link rel="shortcut icon" type="image/png" href="public/images/favicon.png"/>
        <title><?= $title ?></title>
    </head>
    <body>
    <div id="background" <?php if(!isset($_SESSION['username'])){?>class="background_forms"<?php }elseif(!isset($_GET['action']) AND isset($_SESSION['username'])){?>class="background_main_page"<?php }elseif(isset($_GET['action']) AND $_GET['action'] == 'comments' OR $_GET['action'] == 'addComment'){?>class="background_comments_page"<?php }?>>
        <header>
            <nav>
                <ul>
                    <li id="logoGBAF-block"><a href="index.php" title="GBAF"><img src="public/images/LOGO_GBAF.png" alt="Logo GBAF" class="logo"></a></li>
                    <li>
                        <ul id="userBlock">
                        <?php 
                        if(isset($_SESSION['username']) AND isset($_SESSION['password']))
                        {
                        ?>
                            <li><a href="" title="Paramètres de l'utilisateur"><img src="public/images/logo_profil.png" alt="Icon profil" class="logo" id="logo_profil"><?=$_SESSION['lastname'] .' '. $_SESSION['firstname']?></a></li>
                            <li id="li_logout"><a href="index.php?action=logout" title="Déconnexion" class="navButton"><img src="public/images/logo_logout.png" alt="Icon logout" class="logo" id="logo_logout">Se déconnecter</a></li>
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
                    <li><a href="#">Mentions légales</a></li>
                    <li><hr class="verticalSeparator"></li>
                    <li><a href="#">Contact</a></li>
                    <li><hr class="verticalSeparator"></li>
                </ul>
            </nav>
        </footer>
    </div>
    </body>
</html>