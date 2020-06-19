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

		//On vérifie que le nom envoyé contient au moins 1 lettres (maximum 30 lettres)
		if (preg_match('#^[a-zéèàùç-]{1,30}$#i', $lastname))
		{
			$lastnameCheck = true;
		}

		//On vérifie que le prénom envoyé contient au moins 2 lettres (maximum 30 lettres)
		if (preg_match('#^[a-zéèçàù-]{2,30}$#i', $firstname))
		{
			$firstnameCheck = true;
		}

		//On vérifie que le username envoyé contient au moins 3 caractères et jusqu'à 25 caractères max (lettres, chiffres, -, _)
		if (preg_match('#^[a-z0-9_-éèçàù]{3,25}$#i', $username))
		{
				$usernameCheck = true;
		}

		//On vérifie que le username ne soit pas déjà utilisé
		if($usernameCheck)
		{
			$result = checkPostUsername($username);
			if ($result) 
			{
				$usernameNotUsed = true;
			}
		}

		//On contrôle le mot de passe : au moins 8 caractères, max 20 caractères, au moins 1 caractère spécial, au moins 1 majuscule, au moins un chiffre
		if (checkPassword($password))
		{
			$passwordCheck = true;
		}	

		//On compare le mot de passe à confirmer avec le mot de passe
		if (checkPasswordConfirm($password, $passwordConfirmation))
		{
			$passwordConfirmationCheck = true;
			//Les 2 mots sont identiques, on hash donc le mot de passe
			$password = password_hash($password, PASSWORD_DEFAULT);
		}

		//On vérifie que la question contient au moins un caractère
		if (preg_match('#^[a-z0-9éèçàù&@=+,.;:/!*%?$-_]+#i', $question))
		{
			$questionCheck = true;
		}

		//On vérifie que la réponse contient au moins un caractère
		if (preg_match('#^[a-z0-9éèçàù&@=+,.;:/!*%?$-_]+#i', $answer))
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

function checkPassword($password)
{
	if (preg_match('#^[&@=+,.;:/!*%?$-_a-z0-9éèçàù]{8,20}$#i', $password) AND preg_match('#[&@=+,.;:/!*%?$-_]+#', $password) AND preg_match('#[A-Z]+#', $password) AND preg_match('#[0-9]+#', $password))
	{
		return true;
	}
	else 
	{
		return false;
	}	
}

function checkPasswordConfirm($password, $passwordConfirmation)
{
	if ($passwordConfirmation == $password)
	{
		return true;	
	}
	else
	{
		return false;
	}
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

function forgotPassword()
{
	$step = 1;
	if (isset($_POST['usernameForgotPsw']))
	{	
		$username = htmlspecialchars($_POST['usernameForgotPsw']);

		$loginNotExist = checkPostUsername($username);
		if (!$loginNotExist)
		{
			$userQuestion = getUserQuestion($username);
			$step = 2;
		}
	}
	elseif (isset($_POST['answerForgotPsw']) AND isset($_GET['username']))
	{
		$answer = htmlspecialchars($_POST['answerForgotPsw']);
		$username = htmlspecialchars($_GET['username']);

		$answerCheck = checkUserAnswer($answer, $username);

		if ($answerCheck) 
		{
			$step = 3;
		}
	}
	elseif (isset($_POST['passwordForgot']) AND isset($_POST['passwordConfirmationForgot']) AND isset($_GET['username'])) 
	{
		$passwordForgot = htmlspecialchars($_POST['passwordForgot']);
		$passwordConfirmationForgot = htmlspecialchars($_POST['passwordConfirmationForgot']);
		$username = htmlspecialchars($_GET['username']);

		$passwordCheck = false;
		$passwordConfirmationCheck = false;

		$passwordCheck = checkPassword($passwordForgot);
		$passwordConfirmationCheck = checkPasswordConfirm($passwordForgot, $passwordConfirmationForgot);

		if ($passwordCheck AND $passwordConfirmationCheck) 
		{
			$passwordForgot = password_hash($passwordForgot, PASSWORD_DEFAULT);
			changeUserPassword($username, $passwordForgot);
			header('Location: index.php');
		}

	}
	require('view/frontend/forgotPasswordView.php');

}

function listPartners()
{
	require('view/frontend/listPartnersView.php');
}

function listComments()
{

}