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
	elseif(isset($_GET['action']) AND $_GET['action'] == 'registration' AND !isset($_SESSION['username']) AND !isset($_SESSION['password']))
	{
		registration();
	}
	//page "mot de passe oublié""
	elseif(isset($_GET['action']) AND $_GET['action'] == 'forgotPsw' AND !isset($_SESSION['username']) AND !isset($_SESSION['password']))
	{
		forgotPassword();
	}
	//accès au site
	elseif (isset($_SESSION['username']) AND isset($_SESSION['password']) AND isset($_SESSION['firstname']) AND isset($_SESSION['lastname']))
	{
		//page principal (liste des acteurs)
		if(isset($_GET['action']) AND $_GET['action'] == 'comments' AND isset($_GET['partner'])) 
		{
			listComments();
		}
		//page des commentaires
		else
		{
			listPartners();
		}
	}
	//Si des cookies existent, on les compare avec la BDD. S'il y a bien une correspondance dans la BDD on crée les variables de session
	elseif (isset($_COOKIE['username']) AND isset($_COOKIE['password']) AND isset($_COOKIE['firstname']) AND isset($_COOKIE['lastname'])AND checkLogins($_COOKIE['username'], $_COOKIE['password'])) 
	{
			$_SESSION['username'] = $_COOKIE['username'];
			$_SESSION['password'] = $_COOKIE['password'];
			$_SESSION['firstname'] = htmlspecialchars($_COOKIE['firstname']);
			$_SESSION['lastname'] = htmlspecialchars($_COOKIE['lastname']);

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