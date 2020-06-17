<?php $css = 'style.css'; ?>
<?php $title = 'GBAF - Groupement Banque Assurance Français'; ?>

<?php ob_start(); ?>
    	<section id="section1">
    		<h1>Le Groupement Banque Assurance Français​</h1>
    		<p>Représentant de la profession bancaire et des assureurs sur tous les axes de la réglementation financière française, nous gérons près de 80 millions de comptes sur le territoire national. Le GBAF représente les 6 grands groupes français : BNP Paribas, BPCE, Crédit Agricole, Crédit Mutuel-CIC, Société Générale et La Banque Postale. Notre mission est de promouvoir l'activité bancaire à l’échelle nationale. Nous sommes également un interlocuteur privilégié des pouvoirs publics. Nous sommes fiers de vous accueillir sur notre extranet mettant à disposition des ressources pour les salariés des différentes banques de notre groupe.</p>
    		<img src="">
    	</section>
    	<section>
    		<h2>Nos acteurs et partenaires</h2>
    		<p>Retrouver toutes les informations sur nos acteurs et partenaires</p>
    		<div>
    			<div>
    				<img src="">
    				<h3></h3>
    				<p></p>
    				<a href=""></a>
    			</div>
    		</div>
    	</section>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/page_template.php'); ?>