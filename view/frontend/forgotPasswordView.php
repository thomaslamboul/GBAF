<?php $css = 'style.css'; ?>
<?php $title = 'GBAF | Mot de passe oublié'; ?>

<?php ob_start(); ?>
    	<section id="section-forms">
            <a href="index.php" class="back_button"><img src="public/images/back_icon.png" alt="Back icon" class="logo"> Retour</a>
            <form method="post" action="index.php?action=forgotPsw">
                <fieldset>
                    <legend><strong>Création d'un nouveau mot de passe - Étape <?=$step?></strong></legend>  
<?php   
if($step == 1)
{
                    if(isset($loginNotExist) AND $loginNotExist){?><p class="error">Nom d'utilisateur incorrect</p><?php }?>
                    <label for="usernameForgotPsw">Saisissez votre nom d'utilisateur</label>
                    <input type="text" name="usernameForgotPsw" autofocus required>
<?php
}
if($step == 2)
{
                    if(isset($answerCheck) AND !$answerCheck){?><p class="error">Réponse incorrecte</p><?php }?>
                    <label for="answerForgotPsw">Répondez à la question suivante : <strong><?=htmlspecialchars($userQuestion)?></strong></label>
                    <input type="text" name="answerForgotPsw" autofocus required>
                    <input type="hidden" name="usernameForgotPsw" value="<?=$usernameForgotPsw?>">
                    <input type="hidden" name="userQuestion" value="<?=htmlspecialchars($userQuestion)?>">
<?php
}
if($step == 3)
{
?>
                    <div class="blocFormsFormat">
                        <div class="formsFormat">
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
                            <input type="password" name="newPsw" required>
                        </div>

                        <div class="formsFormat">
                            <label for="newPswConfirmation"><?php if(isset($passwordConfirmationCheck) AND !$passwordConfirmationCheck AND $passwordCheck){?><span class="error">Les mots de passe ne correspondent pas</span><?php }else{?>Confirmation du mot de passe<?php }?></label>
                            <input type="password" name="newPswConfirmation" required>
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