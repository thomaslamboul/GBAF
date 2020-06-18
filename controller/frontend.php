<?php

require('model/frontend.php');

function registration()
{
	if (isset($_POST['lastnameRegistration']) OR isset($_POST['firstnameRegistration']) OR isset($_POST['usernameRegistration']) OR isset($_POST['passwordRegistration']) OR isset($_POST['passwordConfirmationRegistration']) OR isset($_POST['questionRegistration']) OR isset($_POST['$answerRegistration']))
	{
		//On désactive les éventuelles injections de code HTML
		$lastname = htmlspecialchars($_POST['lastnameRegistration']);
		$firstname = htmlspecialchars($_POST['firstnameRegistration']);
		$username = htmlspecialchars($_POST['usernameRegistration']);
		$password = htmlspecialchars($_POST['passwordRegistration']);
		$passwordConfirmation = htmlspecialchars($_POST['passwordConfirmationRegistration']);
		$question = htmlspecialchars($_POST['questionRegistration']);
		$answer = htmlspecialchars($_POST['answerRegistration']);

		//On initilise toutes les variables de vérification à "false"
		$lastnameCheck = false;
		$firstnameCheck = false;
		$usernameCheck = false;
		$passwordCheck = false;
		$passwordConfirmationCheck = false;
		$questionCheck = false;
		$answerCheck = false;

		$usernameNotUsed = false;

		//On vérifie que le nom envoyé contient au moins une lettre et qu'il ne contient pas de chiffre
		if (preg_match('#^[a-z^0-9]+#i', $lastname))
		{
			$lastnameCheck = true;
		}

		//On vérifie que le prénom envoyé contient au moins une lettre et qu'il ne contient pas de chiffre
		if (preg_match('#^[a-z^0-9]+#i', $firstname))
		{
			$firstnameCheck = true;
		}

		//On vérifie que le username envoyé contient au moins un caractère
		if (preg_match('#^[a-z0-9]#i', $username))
		{
			$usernameCheck = true;
		}

		//On vérifie que le username ne soit pas déjà utilisé
		if($usernameCheck)
		{
			$result = checkPostsRegistration($username);
			if ($result) 
			{
				$usernameNotUsed = true;
			}
		}

		//On contrôle le mot de passe avec au moins une lettre ou chiffre (à améliorer)
		if (preg_match('#[a-z0-9]#i', $password))
		{
			$passwordCheck = true;
		}	

		//On compare le mot de passe à confirmer avec le mot de passe
		if ($passwordConfirmation == $password)
		{
			$passwordConfirmationCheck = true;
			//Les 2 mots sont identiques, on hash donc le mot de passe
			$password = password_hash($password, PASSWORD_DEFAULT);
		}

		//On vérifie que la question contient au moins un caractère
		if (preg_match('#^[a-z0-9]#i', $question))
		{
			$questionCheck = true;
		}

		//On vérifie que la réponse contient au moins un caractère
		if (preg_match('#^[a-z0-9]#i', $answer))
		{
			$answerCheck = true;
		}

		//Si tout est bon on ajoute le membre
		if ($lastnameCheck AND $firstnameCheck AND $usernameCheck AND $passwordCheck AND $passwordConfirmationCheck AND $questionCheck AND $answerCheck AND $usernameNotUsed)
		{	
			addMember($lastname, $firstname, $username, $password, $question, $answer);
			header('Location: index.php');
		}  
	}
	require('view/frontend/registrationView.php');
}

function connection()
{
	if (isset($_POST['usernameConnection']) AND isset($_POST['passwordConnection']))
	{	
		$username = htmlspecialchars($_POST['usernameConnection']);
		$password = htmlspecialchars($_POST['passwordConnection']);

		$loginExist = checkPostsConnection($username, $password);
		if ($loginExist)
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
	require('view/frontend/listPartnersView.php');
}

function listComments()
{

}