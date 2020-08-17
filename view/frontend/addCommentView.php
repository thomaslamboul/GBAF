<?php $css = 'style.css'; ?>

<?php $title = 'GBAF | Commentaire'; ?>

<?php ob_start(); ?>
    	
<!-- Affichage du formulaire d'ajout d'un commentaire -->
<section id="section_add_comment">

    <a href="index.php?action=comments&partner=<?=htmlspecialchars($idPartner)?>" id="addcomment_back_button" class="back_button"><img src="public/images/back_icon.png" alt="Back icon" class="logo"> Retour</a>

    <div id="block_add_comment">

        <h2>
            <img src="data:image/png;base64,<?=htmlspecialchars(base64_encode($partner['logo']))?>" alt="Logo des acteurs et partenaires" title="<?=htmlspecialchars($partner['partner'])?>" class="logo"/>
        </h2>

        <form method="post" action="index.php?action=addComment&partner=<?=htmlspecialchars($idPartner)?>" id="form_add_comment">
            <fieldset>                  

                <div>
                    <label for="newComment"><?php if(isset($checkCommentNotEmpty) AND !$checkCommentNotEmpty){?><span class="error">Veuillez écrire un commentaire</span><?php }else{?>Commentaire:<?php }?></label>

                    <textarea name="newComment" id="newComment" rows="5" cols="10" placeholder="Votre commentaire..." required></textarea>
                </div>
                
                <input type="hidden" name="lastname" value="<?=$lastname?>">
                <input type="hidden" name="firstname" value="<?=$firstname?>">
                <input type="hidden" name="username" value="<?=$username?>">
   
                <div>
                    <input type="submit" value="Valider">
                </div>

            </fieldset>
        </form>
        
    </div>

    <a href="index.php?action=comments&partner=<?=htmlspecialchars($idPartner)?>" class="back_button"><img src="public/images/back_icon.png" alt="Back icon" class="logo"> Retour</a>

</section>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/pageTemplate.php'); ?>