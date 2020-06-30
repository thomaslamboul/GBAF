<?php $css = 'style.css'; ?>
<?php $title = ''.$partner['partner'].'- GBAF'; ?>

<?php ob_start(); ?>
    	
        <section>

            <div id="block_partner_comments_page">
                <p>
                    <img src="data:image/png;base64,<?=htmlspecialchars(base64_encode($partner['logo']))?>" alt="Logo des acteurs et partenaires" title="<?=htmlspecialchars($partner['partner'])?>" class="logo"/>
                </p>
                <h2><?=htmlspecialchars($partner['partner'])?></h2>
                <a href="#" title="<?=htmlspecialchars($partner['partner'])?>"><?=htmlspecialchars($partner['partner'])?></a>
                <p><?=nl2br(htmlspecialchars($partner['description']))?></p>
            </div>

            <div id="comments_block">
                <div id="header_comments_block">
                    <h3><?=htmlspecialchars($totalPosts)?> Commentaires</h3>
                    <div>
                        <div>
                            <a href="" id="new_com_button">Nouveau<br>commentaire</a>
                        </div>
                        <div id="like_dislike_block">
                            <a href="" ><img src="public/images/like_blue.png" alt="like" class="logo"></a>
                            <a href="" ><img src="public/images/dislike_red.png" alt="dislike" class="logo"></a>
                            <!--<a href="" ><img src="public/images/like.png" alt="like" class="logo"></a>
                            <a href="" ><img src="public/images/dislike.png" alt="dislike" class="logo"></a>-->
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
                    <p><?=htmlspecialchars($comments['first_name'])?></p>
                    <p><?=htmlspecialchars($comments['formated_date'])?></p>
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

        </section>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/pageTemplate.php'); ?>