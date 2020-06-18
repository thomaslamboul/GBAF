<?php $css = 'style.css'; ?>
<?php $title = 'Inscription - GBAF'; ?>

<?php ob_start(); ?>
    	<section>
            <form method="post" action="index.php?action=registration">
                <fieldset>
                    <legend><strong>Inscription</strong></legend>                    
                    <!--<?php if(isset($loginExist) AND !$loginExist){?><p class="error">Nom d'utilisateur ou mot de passe incorrect</p><?php }?>-->
                    <div class="blocFormsFormat">
                        <div class="formsFormat">
                            <label for="lastnameRegistration">Nom</label><?php if(isset($lastnameCheck) AND !$lastnameCheck){echo 'Veuillez saisir votre nom';}?>
                            <input type="text" name="lastnameRegistration" placeholder="Ex: John" autofocus required>
                        </div>
                        <div class="formsFormat">  
                            <label for="firstnameRegistration">Prénom</label><?php if(isset($firstnameCheck) AND !$firstnameCheck){echo 'Veuillez saisir votre prénom';}?>
                            <input type="text" name="firstnameRegistration" placeholder="Ex: Smith" required>
                        </div>
                    </div>
                    
                    <label for="usernameRegistration">Nom d'utilisateur</label><?php if(isset($usernameNotUsed) AND !$usernameNotUsed){echo 'Nom d\'utilisateur déjà utilisé';}elseif(isset($usernameCheck) AND !$usernameCheck){echo 'Veuillez saisir un nom d\'utilisateur';}?>
                    <input type="text" name="usernameRegistration" placeholder="Ex: JohnS-58" required>
                    

                    <div class="blocFormsFormat">
                        <div class="formsFormat">
                            <label for="passwordRegistration">Mot de passe</label><?php if(isset($passwordCheck) AND !$passwordCheck){echo 'Veuillez saisir un mot de passe';}?>
                            <input type="password" name="passwordRegistration" required>
                        </div>
                        <div class="formsFormat">
                            <label for="passwordConfirmationRegistration">Confirmation du mot de passe</label><?php if(isset($passwordConfirmationCheck) AND !$passwordConfirmationCheck){echo 'Les mots de passe ne correspondent pas';}?>
                            <input type="password" name="passwordConfirmationRegistration" required>
                        </div>
                    </div>

                    <label for="questionRegistration">Question secrète</label><?php if(isset($questionCheck) AND !$questionCheck){echo 'Veuillez saisir une question secrète';}?>
                    <input type="text" name="questionRegistration" placeholder="Ex: Quel était mon surnom à l'université ? / Comment s'appellait mon chien lorsque j'avais 15 ans ? / Quel est le prénom de la personne que j'aime le plus ?" required>

                    <label for="answerRegistration">Réponse à la question secrète</label><?php if(isset($answerCheck) AND !$answerCheck){echo 'Veuillez saisir une réponse secrète';}?>
                    <input type="text" name="answerRegistration" placeholder="Ex: Bogosse / Rex / Aïden" required>


                    <div>
                        <input type="submit" value="S'inscrire">
                    </div>
                </fieldset>
            </form>
        </section>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/pageTemplate.php'); ?>