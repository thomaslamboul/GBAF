<?php $css = 'style.css'; ?>
<?php $title = 'GBAF | '.$partner['partner'].''; ?>

<?php ob_start(); ?>
    	
        <section id="section_partner_comments_page">
            <a href="index.php#partner_block" class="back_button"><img src="public/images/back_icon.png" alt="Back icon" class="logo"> Retour</a>
            <div id="block_partner_comments_page">
                <p id="logo_partner_comments_page">
                    <img src="data:image/png;base64,<?=htmlspecialchars(base64_encode($partner['logo']))?>" alt="Logo des acteurs et partenaires" title="<?=htmlspecialchars($partner['partner'])?>" class="logo"/>
                </p>
                <h2><?=htmlspecialchars($partner['partner'])?></h2>
                <a href="#" title="<?=htmlspecialchars($partner['partner'])?>"><?=htmlspecialchars($partner['partner'])?></a>
                <p><?=nl2br(htmlspecialchars($partner['description']))?></p>
            </div>

            <div id="comments_block">
                <div id="header_comments_block">
                    <h3><?=htmlspecialchars($totalComments)?> commentaire<?php if(htmlspecialchars($totalComments) != 0){?>s<?php }?></h3>
                    <div>
                        <div>
                            <a href="index.php?action=addComment&amp;partner=<?=htmlspecialchars($partner['id_partner'])?>" id="new_com_button">Nouveau<br>commentaire</a>
                        </div>
                        <div id="like_dislike_block">
                    
                            <a href="index.php?action=comments&amp;partner=<?=htmlspecialchars($partner['id_partner'])?>&amp;like=1#comments_block" <?php if($dataVote['vote'] == 1){?>class="disabled_link"<?php }?>><img src="public/images/like_blue.png" alt="like" class="logo"></a>
                            <p><?=htmlspecialchars($likeVotes)?></p>
                            <a href="index.php?action=comments&amp;partner=<?=htmlspecialchars($partner['id_partner'])?>&amp;dislike=2#comments_block" <?php if($dataVote['vote'] == 2){?>class="disabled_link"<?php }?>><img src="public/images/dislike_red.png" alt="dislike" class="logo"></a>
                            <p><?=htmlspecialchars($dislikeVotes)?></p>
                      
                            <!--<img src="public/images/like_blue.png" alt="like" class="logo">
                            <p><?=htmlspecialchars($likeVotes)?></p>
                            <img src="public/images/dislike_red.png" alt="dislike" class="logo">
                            <p><?=htmlspecialchars($dislikeVotes)?></p>-->
                      
                        </div> 
                    </div>
                </div>

         
<?php 
if ($comments = $data->fetch())
{
    do
    {
?>
                <div class="comment">
                    <p><strong><?=htmlspecialchars($comments['first_name'])?></strong></p>
                    <p class="date_comments"><?=htmlspecialchars($comments['formated_date'])?></p>
                    <p><?=htmlspecialchars($comments['post'])?></p>
                </div>
<?php
    }
    while ($comments = $data->fetch());
}
else
{
?>
                <div class="comment">
                    <p>Soyez le premier à écrire un commentaire !</p>
                </div>
<?php
}
$data->closecursor();
?>
                
            </div>
            <a href="index.php#partner_block" class="back_button"><img src="public/images/back_icon.png" alt="Back icon" class="logo"> Retour</a>
        </section>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/pageTemplate.php'); ?>