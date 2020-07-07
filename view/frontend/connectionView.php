<?php $css = 'style.css'; ?>
<?php $title = 'GBAF | Connexion'; ?>

<?php ob_start(); ?>
    	<section id="section_forms_connection_page" class="section_forms">
            <form method="post" action="index.php">
                <fieldset>
                    <legend><strong>Connexion</strong></legend>                    
                    <?php if(isset($loginExist) AND !$loginExist){?><p class="error">Nom d'utilisateur ou mot de passe incorrect</p><?php }elseif(isset($_GET['updatePswStatus']) AND $_GET['updatePswStatus']){?><p class="correct">La modification du mot de passe a bien été prise en compte</p><?php }elseif(isset($_GET['registration']) AND $_GET['registration']){?><p class="correct">Inscription validée</p><?php }?>
                    <label for="usernameConnection">Nom d'utilisateur</label>
                    <input type="text" name="usernameConnection" autofocus required>   
                    <label for="passwordConnection">Mot de passe</label>
                    <input type="password" name="passwordConnection" required>
                    <div>
                        <input type="checkbox" name="autoConnect" value="ok"><label for="autoConnect">Connexion automatique</label>
                    </div>
                    <div>
                        <input type="submit" value="Se connecter">
                    </div>
                    <a href="index.php?action=forgotPsw">Mot de passe oublié ?</a>
                </fieldset>
            </form>
        </section>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/pageTemplate.php'); ?>