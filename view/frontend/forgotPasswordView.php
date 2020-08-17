<?php $css = 'style.css'; ?>

<?php $title = 'GBAF | Mot de passe oublié'; ?>

<?php ob_start(); ?>

<!-- Affichage du formulaire pour le mot de passe oublié en 3 étapes -->
<section class="section_forms">

    <a href="index.php" class="back_button"><img src="public/images/back_icon.png" alt="Back icon" class="logo"> Retour</a>

    <form method="post" action="index.php?action=forgotPsw">
        <fieldset>
            
            <legend><h2>Création d'un nouveau mot de passe - Étape <?=$step?></h2></legend>  
            <?php   
            if($step == 1)
            {
                if(isset($loginNotExist) AND $loginNotExist){?><p class="error">Nom d'utilisateur incorrect</p><?php }?>
                <!-- Affichage du formulaire "mot de passe oublié" - Etape 1 (demande du nom d'utilisateur) -->
                <label for="usernameForgotPsw">Saisissez votre nom d'utilisateur</label>
                <input type="text" name="usernameForgotPsw" id="usernameForgotPsw" autofocus required>
            <?php
            }
            if($step == 2)
            {
                if(isset($answerCheck) AND !$answerCheck){?><p class="error">Réponse incorrecte</p><?php }?>
                <!-- Affichage du formulaire "mot de passe oublié" - Etape 2 (demande de la réponse secrète) -->
                <label for="answerForgotPsw">Répondez à la question suivante : <strong><?=htmlspecialchars($userQuestion)?></strong></label>
                <input type="text" name="answerForgotPsw" id="answerForgotPsw" autofocus required>
                <input type="hidden" name="usernameForgotPsw" value="<?=$usernameForgotPsw?>">
                <input type="hidden" name="userQuestion" value="<?=htmlspecialchars($userQuestion)?>">
            <?php
            }
            if($step == 3)
            {
            ?>
                <!-- Affichage du formulaire "mot de passe oublié" - Etape 3 (demande nouveau mot de passe et confirmation du mot de passe) -->
                <div class="blocFormsFormat column_forms">
                    <div class="formsFormat width_forms">
                        <div class="blocWithTooltip">
                            <label for="newPsw"><?php if(isset($passwordCheck) AND !$passwordCheck){?><span class="error">Format de mot de passe incorrect</span><?php }else{?>Nouveau mot de passe<?php }?></label>
                            <a class="toolTip">
                                <img src="public/images/infobulle_aide_icon.png" alt=" ? " />
                                <ul>
                                    <li>Au moins 8 caractères</li>
                                    <li>Au moins 1 caractère spécial</li>
                                    <li>Au moins 1 majuscule</li>
                                    <li>Au moins 1 chiffre</li>
                                </ul>
                            </a>
                        </div>
                        <input type="password" name="newPsw" id="newPsw" required>
                    </div>

                    <div class="formsFormat width_forms">
                        <label for="newPswConfirmation"><?php if(isset($passwordConfirmationCheck) AND !$passwordConfirmationCheck AND $passwordCheck){?><span class="error">Les mots de passe ne correspondent pas</span><?php }else{?>Confirmation du mot de passe<?php }?></label>
                        <input type="password" name="newPswConfirmation" id="newPswConfirmation" required>
                    </div>

                    <input type="hidden" name="usernameForgotPsw" value="<?=$usernameForgotPsw?>">
                </div>
            <?php
            }
            ?>
            <div>
                <input type="submit" value="Valider">
            </div>

        </fieldset>
    </form>

</section>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/pageTemplate.php'); ?>