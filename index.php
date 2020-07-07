<?php
session_start();

require('controller/frontend.php');

try
{
	//condition de routage vers fonction de déconnexion
	if(isset($_GET['action']) AND $_GET['action'] == 'logout')
	{
		logout();
	}
	//condition de routage vers page de d'inscription
	elseif(isset($_GET['action']) AND $_GET['action'] == 'registration' AND !isset($_SESSION['username']) AND !isset($_SESSION['password']))
	{
		registration();
	}
	//condition de routage vers page 'mot de passe oublié''
	elseif(isset($_GET['action']) AND $_GET['action'] == 'forgotPsw' AND !isset($_SESSION['username']) AND !isset($_SESSION['password']))
	{
		forgotPassword();
	}
	//condition d'accès au site
	elseif (isset($_SESSION['username']) AND isset($_SESSION['password']) AND isset($_SESSION['firstname']) AND isset($_SESSION['lastname']))
	{
		//condition de routage vers page des commentaires
		if(isset($_GET['action']) AND $_GET['action'] == 'comments' AND isset($_GET['partner'])) 
		{
			listComments();
		}
		//condition de routage vers page 'ajouter un commentaire'
		elseif (isset($_GET['action']) AND $_GET['action'] == 'addComment' AND isset($_GET['partner'])) 
		{
			addComment();
		}
		//condition de routage vers page d'acceuil (liste des acteurs)
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
	//routage vers page de connexion
	else
	{
		connection();
	}
}
catch(Exception $e)
{
	echo 'Erreur : ' . $e->getMessage();
}