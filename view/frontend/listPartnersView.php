<?php $css = 'style.css'; ?>
<?php $title = 'GBAF | Acceuil'; ?>

<?php ob_start(); ?>
    	<section class="sections-partersPage" id="section-presentation">
            <div>
        		<h1>Le Groupement Banque Assurance Français​</h1>
        		<p>Représentant de la profession bancaire et des assureurs sur tous les axes de la réglementation financière française, nous gérons près de 80 millions de comptes sur le territoire national.<br>Le GBAF représente les 6 grands groupes français : BNP Paribas, BPCE, Crédit Agricole, Crédit Mutuel-CIC, Société Générale et La Banque Postale.<br>Notre mission est de promouvoir l'activité bancaire à l’échelle nationale. Nous sommes également un interlocuteur privilégié des pouvoirs publics. Nous sommes fiers de vous accueillir sur notre extranet mettant à disposition des ressources pour les salariés des différentes banques de notre groupe.</p>
            </div>
            <div id="master"></div>	
    	</section>

    	<section class="sections-partersPage" id="section-partner">
            <div>
        		<h2>Nos acteurs et partenaires</h2>
        		<p>Retrouver toutes les informations sur nos acteurs et partenaires</p>
        		<div id="listpartners-block">
<?php
while ($partners = $data->fetch()) 
{
?>
                    <div id="partner_block">
                        <p>
                            <img src="data:image/png;base64,<?=htmlspecialchars(base64_encode($partners['logo']))?>" alt="Logo des acteurs et partenaires" title="<?=htmlspecialchars($partners['partner'])?>" class="logo"/>
                        </p>
                        <div id="partner-content">
            				<h3><?=htmlspecialchars($partners['partner'])?></h3>
            				<p><?=cutString(nl2br(htmlspecialchars($partners['description'])))?></p>
                            <a href="#" title="<?=htmlspecialchars($partners['partner'])?>"><?=htmlspecialchars($partners['partner'])?></a>
                        </div>
        				<a href="index.php?action=comments&amp;partner=<?=htmlspecialchars($partners['id_partner'])?>" title="Lire la suite...">Lire la suite</a>
        			</div>
<?php
}
$data->closecursor();
?>
                </div>
            </div>
        </section>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/pageTemplate.php'); ?>