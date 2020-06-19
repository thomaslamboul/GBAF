<?php $css = 'style.css'; ?>
<?php $title = 'Inscription - GBAF'; ?>

<?php ob_start(); ?>
    	<section>
            <form method="post" action="index.php?action=registration">
                <fieldset>

                    <legend><strong>Inscription</strong></legend>                    

                    <div class="blocFormsFormat">
                        <div class="formsFormat">
                            <label for="lastnameRegistration"><?php if(isset($lastnameCheck) AND !$lastnameCheck){?><span class="error">Format de nom incorrect</span><?php }else{?>Nom<?php }?></label>
                            <input type="text" name="lastnameRegistration" placeholder="Ex: John" value="<?php if(isset($lastnameCheck) AND $lastnameCheck){echo "$lastname";}?>" autofocus required>
                        </div>

                        <div class="formsFormat">  
                            <label for="firstnameRegistration"><?php if(isset($firstnameCheck) AND !$firstnameCheck){?><span class="error">Format de prénom incorrect</span><?php }else{?>Prénom<?php }?></label>
                            <input type="text" name="firstnameRegistration" placeholder="Ex: Smith" value="<?php if(isset($firstnameCheck) AND $firstnameCheck){echo "$firstname";}?>" required>
                        </div>
                    </div>

                    <div class="blocWithTooltip">
                        <label for="usernameRegistration"><?php if(isset($usernameCheck) AND !$usernameCheck){?><span class="error">Format de nom d'utilisateur incorrect</span><?php }elseif(isset($usernameNotUsed) AND !$usernameNotUsed){?><span class="error">Nom d'utilisateur déjà utilisé</span><?php }else{?>Nom d'utilisateur<?php }?></label>
                        <a class="toolTip">
                            <img src="public/images/infobulle_aide_icon.png" alt=" ? " />
                            <ul>
                                <li>Au moins 3 caractères</li>
                                <li>25 caractères max</li>
                                <li>Caractères spéciaux autorisés : "-" et "_"</li>
                            </ul>
                        </a>
                    </div>
                    <input type="text" name="usernameRegistration" placeholder="Ex: JohnS-58" value="<?php if(isset($usernameCheck) AND $usernameCheck){echo "$username";}?>" required>
                    
                    <div class="blocFormsFormat">
                        <div class="formsFormat">
                            <div class="blocWithTooltip">
                                <label for="passwordRegistration"><?php if(isset($passwordCheck) AND !$passwordCheck){?><span class="error">Format de mot de passe incorrect</span><?php }else{?>Mot de passe<?php }?></label>
                                <a class="toolTip">
                                <img src="public/images/infobulle_aide_icon.png" alt=" ? " />
                                <ul>
                                    <li>Au moins 8 caractères</li>
                                    <li>Au moins 1 caractère spécial</li>
                                    <li>Au moins 1 majuscule</li>
                                    <li>Au moins 1 chiffre</li>
                                    <li>20 caractères max</li>
                                </ul>
                                </a>
                            </div>
                            <input type="password" name="passwordRegistration" required>
                        </div>

                        <div class="formsFormat">
                            <label for="passwordConfirmationRegistration"><?php if(isset($passwordConfirmationCheck) AND !$passwordConfirmationCheck AND $passwordCheck){?><span class="error">Les mots de passe ne correspondent pas</span><?php }else{?>Confirmation du mot de passe<?php }?></label>
                            <input type="password" name="passwordConfirmationRegistration" required>
                        </div>
                    </div>

                    <div class="blocWithTooltip">
                        <label for="questionRegistration"><?php if(isset($questionCheck) AND !$questionCheck){?><span class="error">Veuillez saisir une question secrète</span><?php }else{?>Question secrète<?php }?></label>
                        <a class="toolTip">
                            <img src="public/images/infobulle_aide_icon.png" alt=" ? " />
                            <ul>
                                <li>En cas d'oubli de votre mot de passe cette question vous sera posée</li>
                                <li>Choisissez une question très personnelle dont vous seul connait la réponse</li>
                                <li>Choisissez une question qui attend une réponse courte avec un seul mot</li>
                            </ul>
                        </a>
                    </div>
                        <input type="text" name="questionRegistration" placeholder="Ex: Quel était mon surnom à l'université ? / Comment s'appellait mon chien lorsque j'avais 15 ans ? / Quel est le prénom de la personne que j'aime le plus ?" value="<?php if(isset($questionCheck) AND $questionCheck){echo "$question";}?>" required>

                    <div class="blocWithTooltip">
                        <label for="answerRegistration"><?php if(isset($answerCheck) AND !$answerCheck){?><span class="error">Veuillez saisir une réponse secrète</span><?php }else{?>Réponse à votre question secrète<?php }?></label>
                        <a class="toolTip">
                            <img src="public/images/infobulle_aide_icon.png" alt=" ? " />
                            <ul>
                                <li>En cas d'oubli de votre mot de passe la réponse à votre question vous sera demandée</li>
                                <li>Choisissez une réponse courte avec un seul mot</li>
                            </ul>
                        </a>
                    </div>
                    <input type="text" name="answerRegistration" placeholder="Ex: Bogosse / Rex / Aïden" value="<?php if(isset($answerCheck) AND $answerCheck){echo "$answer";}?>" required>

                    <div>
                        <input type="submit" value="S'inscrire">
                    </div>

                </fieldset>
            </form>
        </section>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/pageTemplate.php'); ?>