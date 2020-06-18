<?php $css = 'style.css'; ?>
<?php $title = 'Page de connexion - GBAF'; ?>

<?php ob_start(); ?>
    	<section>
            <form method="post" action="index.php">
                <fieldset>
                    <legend><strong>Connexion</strong></legend>
                    <label for="usernameConnection">Nom d'utilisateur</label>
                    <div>
                    <input type="text" name="usernameConnection" autofocus required>
                    </div>
                    <label for="passwordConnection">Mot de passe</label>
                    <div>
                        <input type="password" name="passwordConnection" required>
                    </div>
                    <div>
                        <input type="checkbox" name="autoConnect" value="ok" checked=""><label for="autoConnect">Connexion automatique</label>
                    </div>
                    <?php if(isset($connexion_failed) AND $connexion_failed){echo 'Pseudo ou mot de passe incorrect';}?>
                    <div id="sendButton">
                        <input type="submit">
                    </div>
                    <a href="index.php?action=registration">Pas encore membre ? Incrivez-vous !</a>
                    <a href="">Mot de passe oublié</a>
                </fieldset>
            </form>
        </section>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/pageTemplate.php'); ?>