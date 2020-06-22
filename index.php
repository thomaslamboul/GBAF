<?php
session_start();

require('controller/frontend.php');

try
{
	//page de déconnexion
	if(isset($_GET['action']) AND $_GET['action'] == 'logout')
	{
		logout();
	}
	//page de d'inscription
	elseif(isset($_GET['action']) AND $_GET['action'] == 'registration')
	{
		registration();
	}
	//page "mot de passe oublié""
	elseif(isset($_GET['action']) AND $_GET['action'] == 'forgotPsw')
	{
		forgotPassword();
	}
	//accès au site
	elseif (isset($_SESSION['username']) AND isset($_SESSION['password']))
	{
		//page principal (liste des acteurs)
		if(isset($_GET['action']) AND $_GET['action'] == 'comments') 
		{
			listComments();
		}
		//page des commentaires
		else
		{
			listPartners();
		}
	}
	//Si des cookies existent, on les compare avec la BDD. S'il y a bien une correspondance dans la BDD on effectue la connexion auto
	elseif (isset($_COOKIE['username']) AND isset($_COOKIE['password']) AND check_cookies($_COOKIE['username'], $_COOKIE['password'])) 
	{
			$_SESSION['username'] = $_COOKIE['username'];
			$_SESSION['password'] = $_COOKIE['password'];

			header('Location: index.php');
	}
	//page de connexion
	else
	{
		connection();
	}
}
catch(Exception $e)
{
	echo 'Erreur : ' . $e->getMessage();
}