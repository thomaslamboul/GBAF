<?php $css = 'style.css'; ?>
<?php $title = 'Connexion - GBAF'; ?>

<?php ob_start(); ?>
    	<section>
            <form method="post" action="index.php">
                <fieldset>
                    <legend><strong>Connexion</strong></legend>                    
                    <?php if(isset($loginExist) AND !$loginExist){?><p class="error">Nom d'utilisateur ou mot de passe incorrect</p><?php }?>
                    <label for="usernameConnection">Nom d'utilisateur</label>
                    <input type="text" name="usernameConnection" value="<?php if(isset($lastnameCheck) AND $lastnameCheck){echo "$lastname";}?>" autofocus required>
                    <label for="passwordConnection">Mot de passe</label>
                    <input type="password" name="passwordConnection" required>
                    <div>
                        <input type="checkbox" name="autoConnect" value="ok" checked=""><label for="autoConnect">Connexion automatique</label>
                    </div>
                    <div>
                        <input type="submit" value="Se connecter">
                    </div>
                    <a href="">Mot de passe oublié ?</a>
                </fieldset>
            </form>
        </section>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/pageTemplate.php'); ?>