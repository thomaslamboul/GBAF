<?php
session_start();

require('controller/frontend.php');

try
{
	if(isset($_GET['action']) AND $_GET['action'] == 'logout')
	{
		logout();
	}
	elseif(isset($_GET['action']) AND $_GET['action'] == 'registration')
	{
		registration();
	}
	elseif(isset($_GET['action']) AND $_GET['action'] == 'forgotPsw')
	{
		forgotPassword();
	}
	elseif (isset($_SESSION['username']) AND isset($_SESSION['password']))
	{
		if(isset($_GET['action']) AND $_GET['action'] == 'comments') 
		{
			listComments();
		}
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
	else
	{
		connection();
	}
}
catch(Exception $e)
{
	echo 'Erreur : ' . $e->getMessage();
}