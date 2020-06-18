<?php

require('model/frontend.php');

function connection()
{
	if (isset($_POST['usernameConnection']) AND isset($_POST['passwordConnection']))
	{	
		$username = htmlspecialchars($_POST['usernameConnection']);
		$password = htmlspecialchars($_POST['passwordConnection']);

		$login_exist = checkPostsConnection($username, $password);
		if ($login_exist)
		{
			$_SESSION['username'] = $username;
			$_SESSION['password'] = $password;

			//On vérifie si la case "connexion auto" optionnelle à été cochée et si oui on crée des cookies pour username et mdp
			if (isset($_POST['autoConnect']) AND !empty($_POST['autoConnect']))
			{
				setcookie('username', $username, time() + 14*24*3600, null, null, false, true);
				setcookie('password', $password, time() + 14*24*3600, null, null, false, true);
			}
			header('Location: index.php');
		}
	}
	require('view/frontend/connectionView.php');
}

function registration()
{	

}

function logout()
{
	session_start();
	$_SESSION = array();
	session_destroy();
	setcookie('username', '');
	setcookie('password', '');
	header('Location: index.php');
}

function listPartners()
{

}

function listComments()
{

}