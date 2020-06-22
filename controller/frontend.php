<?php

require('model/frontend.php');
	
//Inscription en 3 étapes (1-demande nom/prénom/username | 2-demande question/réponse secrètes | 3-demande mdp)
function registration()
{	
	//Initialisation de la variable $step
	if(!isset($_POST['lastnameRegistration']) AND !isset($_POST['firstnameRegistration']) AND !isset($_POST['usernameRegistration']) AND !isset($_POST['questionRegistration']) AND !isset($_POST['$answerRegistration']) AND !isset($_POST['passwordRegistration']) AND !isset($_POST['passwordConfirmationRegistration']))
	{
		$step = 1;
	}
	//Traitement des données de l'étape 1 - vérification des saisis nom, prénom et username
	elseif (isset($_POST['lastnameRegistration']) AND isset($_POST['firstnameRegistration']) AND isset($_POST['usernameRegistration']))
	{
		$step = 1;

		$lastname = htmlspecialchars($_POST['lastnameRegistration']);
		$firstname = htmlspecialchars($_POST['firstnameRegistration']);
		$username = htmlspecialchars($_POST['usernameRegistration']);

		$lastnameCheck = false;
		$firstnameCheck = false;
		$usernameCheck = false;
		$usernameNotUsed = false;

		//On vérifie que le nom envoyé contient au moins 1 lettres (maximum 30 lettres)
		if (checkLastname($lastname))
		{
			$lastnameCheck = true;
		}

		//On vérifie que le prénom envoyé contient au moins 2 lettres (maximum 30 lettres)
		if (checkFirstname($firstname))
		{
			$firstnameCheck = true;
		}

		//On vérifie que le username envoyé contient au moins 3 caractères et jusqu'à 25 caractères max (lettres, chiffres, -, _)
		if (checkUsername($username)) 
		{
			$usernameCheck = true;
		}

		//On vérifie que le username ne soit pas déjà utilisé
		if($usernameCheck)
		{
			if (checkPostUsername($username)) 
			{
				$usernameNotUsed = true;
			}
		}

		if ($lastnameCheck AND $firstnameCheck AND $usernameCheck AND $usernameNotUsed) 
		{
			$step = 2;
		}
	}
	//Traitement des données de l'étape 2 - vérification des saisis question/réponse secrètes
	elseif (isset($_POST['questionRegistration']) OR isset($_POST['$answerRegistration']))
	{
		$step = 2;

		$lastname = htmlspecialchars($_POST['lastname']);
		$firstname = htmlspecialchars($_POST['firstname']);
		$username = htmlspecialchars($_POST['username']);
		$question = htmlspecialchars($_POST['questionRegistration']);
		$answer = htmlspecialchars($_POST['answerRegistration']);

		$questionCheck = false;
		$answerCheck = false;

		//On vérifie que la question contient au moins un caractère
		if (checkQuestionAnswer($question))
		{
			$questionCheck = true;
		}

		//On vérifie que la réponse contient au moins un caractère
		if (checkQuestionAnswer($answer))
		{
			$answerCheck = true;
		}

		//On ajoute le membre
		if ($questionCheck AND $answerCheck) 
		{	
			$step = 3;
		}
	}
	//Traitement des données de l'étape 3 - vérification des saisis mots de passe
	elseif (isset($_POST['passwordRegistration']) AND isset($_POST['passwordConfirmationRegistration']))
	{
		$step = 3;

		$lastname = htmlspecialchars($_POST['lastname']);
		$firstname = htmlspecialchars($_POST['firstname']);
		$username = htmlspecialchars($_POST['username']);
		$question = htmlspecialchars($_POST['question']);
		$answer = htmlspecialchars($_POST['answer']);
		$password = htmlspecialchars($_POST['passwordRegistration']);
		$passwordConfirmation = htmlspecialchars($_POST['passwordConfirmationRegistration']);

		$passwordCheck = false;
		$passwordConfirmationCheck = false;

		//Contrôle mot de passe : au moins 8 caractères, max 20 caractères, au moins 1 caractère spécial, au moins 1 majuscule, au moins un chiffre
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

		if ($passwordCheck AND $passwordConfirmationCheck) 
		{
			addMember($lastname, $firstname, $username, $password, $question, $answer);
			header('Location: index.php'); 
		}
	}		
	require('view/frontend/registrationView.php');
}

function checkLastname($lastname)
{
	if (preg_match('#^[a-zéèàùç-]{1,30}$#i', $lastname))
	{
		return true;
	}
	else 
	{
		return false;
	}	
}

function checkFirstname($firstname)
{
	if(preg_match('#^[a-zéèçàù-]{2,30}$#i', $firstname))
	{
		return true;
	}
	else 
	{
		return false;
	}
}

function checkUsername($username)
{
	if (preg_match('#^[a-z0-9_-éèçàù]{3,25}$#i', $username))
	{
		return true;
	}
	else
	{
		return false;
	}
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

function checkQuestionAnswer($string)
{
	if (preg_match('#^[a-z0-9éèçàù@=+,.;:/!*%?$-_]+#i', $string))
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
	$_SESSION = array();
	session_destroy();
	setcookie('username', '');
	setcookie('password', '');
	header('Location: index.php');
}

//Modification du mot de passe en 3 étapes (1-demande du username | 2-réponse à la question secrète | 3-nouveau mot de passe)
function forgotPassword()
{
	//Initialisation de la variable $step
	if (!isset($_POST['usernameForgotPsw']) AND !isset($_POST['answerForgotPsw']) AND !isset($_POST['newPsw']) AND !isset($_POST['newPswConfirmation']))
	{
		$step = 1;
	}
	//Traitement des données de l'étape 1 - vérification du username saisi avec celui la BDD
	elseif (isset($_POST['usernameForgotPsw']) AND !isset($_POST['answerForgotPsw']) AND !isset($_POST['newPsw']) AND !isset($_POST['newPswConfirmation']))
	{	
		$step = 1;

		$usernameForgotPsw = htmlspecialchars($_POST['usernameForgotPsw']);

		$loginNotExist = checkPostUsername($usernameForgotPsw);
		if (!$loginNotExist)
		{
			$userQuestion = getUserQuestion($usernameForgotPsw);
			$step = 2;
		}
	}
	//Traitement des données de l'étape 2 - vérification de la réponse saisie avec celle de la BDD
	elseif (isset($_POST['answerForgotPsw']) AND isset($_POST['usernameForgotPsw']) AND isset($_POST['userQuestion']) AND !isset($_POST['newPsw']) AND !isset($_POST['newPswConfirmation']))
	{
		$step = 2;

		$answerForgotPsw = htmlspecialchars($_POST['answerForgotPsw']);
		$usernameForgotPsw = htmlspecialchars($_POST['usernameForgotPsw']);
		$userQuestion = htmlspecialchars($_POST['userQuestion']);

		$answerCheck = checkUserAnswer($answerForgotPsw, $usernameForgotPsw);

		if ($answerCheck) 
		{
			$step = 3;
		}
	}
	//Traitement des données de l'étape 3 - vérification des mots de passe saisis puis mise à jour dans la BDD
	elseif (isset($_POST['newPsw']) AND isset($_POST['newPswConfirmation']) AND isset($_POST['usernameForgotPsw'])) 
	{
		$step = 3;

		$newPassword = htmlspecialchars($_POST['newPsw']);
		$newPasswordConfirmation = htmlspecialchars($_POST['newPswConfirmation']);
		$username = htmlspecialchars($_POST['usernameForgotPsw']);

		$passwordCheck = checkPassword($newPassword);
		$passwordConfirmationCheck = checkPasswordConfirm($newPassword, $newPasswordConfirmation);

		if ($passwordCheck AND $passwordConfirmationCheck) 
		{
			$newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
			changeUserPassword($username, $newPassword);
			$changePsw = true;
			header('Location: index.php?changePsw='.$changePsw);
		}
	}
	//Affichage
	require('view/frontend/forgotPasswordView.php');
}

function listPartners()
{
	require('view/frontend/listPartnersView.php');
}

function listComments()
{

}