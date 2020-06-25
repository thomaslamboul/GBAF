<?php $css = 'style.css'; ?>
<?php $title = ''.$partner['partner'].'- GBAF'; ?>

<?php ob_start(); ?>
    	
        <section>

            <div>
                <p>
                    <img src="data:image/png;base64,<?=htmlspecialchars(base64_encode($partner['logo']))?>" alt="Logo des acteurs et partenaires" title="<?=htmlspecialchars($partner['partner'])?>" class="logo"/>
                </p>
                <h2><?=htmlspecialchars($partner['partner'])?></h2>
                <a href="#" title="<?=htmlspecialchars($partner['partner'])?>"><?=htmlspecialchars($partner['partner'])?></a>
                <p><?=nl2br(htmlspecialchars($partner['description']))?></p>
            </div>

            <div>
                <div>
                    <h3>X Commentaires</h3>
                    <button type="button"></button>
                    <button type="button"></button>
                </div>

            </div>

        </section>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/pageTemplate.php'); ?>