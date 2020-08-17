<?php $css = 'style.css'; ?>

<?php $title = 'GBAF | Paramètres'; ?>

<?php ob_start(); ?>

<!-- Affichage du formulaire des paramètres de l'utilisateur -->
<section id="section_settings">

    <a href="index.php" class="back_button"><img src="public/images/back_icon.png" alt="Back icon" class="logo"> Retour</a>

    <div id="block_settings">

        <div>
            <img src="public/images/logo_profil_noir.png" alt="Logo profil" title="<?=$_SESSION['lastname'] .' '. $_SESSION['firstname']?>" class="logo"/>
            <div>
                <?php if (isset($success) AND $success){?><p class="correct">Modifications validées</p><?php }?>
                <h3>Paramètres du compte</h3>
                <p><?=$_SESSION['lastname'] .' '. $_SESSION['firstname']?></p>
            </div>
        </div>

        <form method="post" action="index.php?action=settings" id="form_settings">
            <fieldset>                  

                <div>
                    <label for="lastnameSettings"><?php if(isset($checkLastname) AND !$checkLastname){?><span class="error">Format de nom incorrect</span><?php }else{?>Nom:<?php }?></label>
                    <input type="text" name="lastnameSettings" id="lastnameSettings" value="<?=htmlspecialchars($userInfos['last_name'])?>">
                </div>

                <div>
                    <label for="firstnameSettings"><?php if(isset($checkFirstname) AND !$checkFirstname){?><span class="error">Format de prénom incorrect</span><?php }else{?>Prénom:<?php }?></label>
                    <input type="text" name="firstnameSettings" id="firstnameSettings" value="<?=htmlspecialchars($userInfos['first_name'])?>">
                </div>

                <div>
                    <label for="usernameSettings"><?php if(isset($checkUsername) AND !$checkUsername){?><span class="error">Format incorrect</span><?php }elseif(isset($checkUsernameNotUsed) AND !$checkUsernameNotUsed){?><span class="error">Nom d'utilisateur déjà utilisé</span><?php }else{?>Nom d'utilisateur:<?php }?></label>
                    <input type="text" name="usernameSettings" id="usernameSettings" value="<?=htmlspecialchars($userInfos['username'])?>">
                </div>

                <div>
                    <label for="newPasswordSettings"><?php if(isset($checkPassword) AND !$checkPassword){?><span class="error">Format de mot de passe incorrect</span><?php }else{?>Nouveau mot de passe:<?php }?></label>
                    <input type="password" name="newPasswordSettings" id="newPasswordSettings" placeholder="Saisissez votre nouveau mot de passe">
                </div>

                <div>
                    <label for="passwordConfirmationSettings"><?php if(isset($checkPasswordConfirm) AND !$checkPasswordConfirm AND $checkPassword){?><span class="error">Les mots de passe ne correspondent pas</span><?php }else{?>Confirmer le mot de passe:<?php }?></label>
                    <input type="password" name="passwordConfirmationSettings" id="passwordConfirmationSettings" placeholder="Confirmer le nouveau mot de passe">
                </div>

                <div>
                    <label for="questionSettings"><?php if(isset($questionCheck) AND !$questionCheck){?><span class="error">Veuillez saisir une question</span><?php }else{?>Question:<?php }?></label>
                    <input type="text" name="questionSettings" id="questionSettings" value="<?=htmlspecialchars($userInfos['question'])?>">
                </div>

                <div>
                    <label for="answerSettings"><?php if(isset($answerCheck) AND !$answerCheck){?><span class="error">Veuillez saisir une réponse</span><?php }else{?>Réponse:<?php }?></label>
                    <input type="text" name="answerSettings" id="answerSettings" placeholder="Saisissez votre nouvelle réponse">
                </div>

                <hr>

                <div>
                    <label for="passwordCurrentSettings"><?php if(isset($currentPswSend) AND !$currentPswSend){?><span class="error">Veuillez saisir votre mot de passe</span><?php }else{?>Mot de passe actuel:<?php }?></label>
                    <input type="password" name="passwordCurrentSettings" id="passwordCurrentSettings" placeholder="Entrez votre mot de passe actuel" required="">
                </div>

                <input type="submit" value="Mettre à jour mes paramètres">

            </fieldset>
        </form>
        
    </div>

    <a href="index.php" class="back_button"><img src="public/images/back_icon.png" alt="Back icon" class="logo"> Retour</a>

</section>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/pageTemplate.php'); ?>