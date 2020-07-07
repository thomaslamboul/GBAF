<?php

require('model/frontend.php');

//Page d'inscription
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

		//Contrôle mot de passe : au moins 8 caractères, au moins 1 caractère spécial, au moins 1 majuscule, au moins un chiffre
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
			addAccount($lastname, $firstname, $username, $password, $question, $answer);
			$registrationStatus = true;
			header('Location: index.php?registration='.$registrationStatus);
		}
	}		
	require('view/frontend/registrationView.php');
}

//Vérifie si la chaine de caractère contient au moins 1 caractère et maximum 30 caractères
function checkLastname($string)
{
	if (preg_match('#^[a-zéèàùç-]{1,30}$#i', $string))
	{
		return true;
	}
	else 
	{
		return false;
	}	
}

//Vérifie si la chaine de caractère contient au moins 2 caractères et maximum 30 caractères
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

//Vérifie si la chaine de caractère contient au moins 3 caractères et jusqu'à 25 caractères maximum
function checkUsername($username)
{
	if (preg_match('#^[-a-z0-9_éèçàù]{3,25}$#i', $username))
	{
		return true;
	}
	else
	{
		return false;
	}
}

//Vérifie si la chaine de caractère contient au moins : 8 caractères, 1 caractère spécial, 1 majuscule, 1 chiffre
function checkPassword($password)
{
	if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{8,}$#', $password))
	{
		return true;
	}
	else 
	{
		return false;
	}	
}

//Vérifie si 2 chaines de caractères sont identiques
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

//Vérifie si la chaine de caractère contient au moins 1 caractère
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

//Page de connexion
function connection()
{
	if (isset($_POST['usernameConnection']) AND isset($_POST['passwordConnection']))
	{	
		$username = htmlspecialchars($_POST['usernameConnection']);
		$password = htmlspecialchars($_POST['passwordConnection']);

		$loginExist = checkLogins($username, $password);
		if ($loginExist)
		{
			$_SESSION['username'] = $username;
			$_SESSION['password'] = $password;
			$data = getUserInfos($_SESSION['username']);
			$_SESSION['lastname'] = $data['last_name'];
			$_SESSION['firstname'] = $data['first_name'];

			//On vérifie si la case "connexion auto" optionnelle à été cochée et si oui on crée des cookies pour username et mdp
			if (isset($_POST['autoConnect']) AND !empty($_POST['autoConnect']))
			{
				setcookie('username', $username, time() + 14*24*3600, null, null, false, true);
				setcookie('password', $password, time() + 14*24*3600, null, null, false, true);
				setcookie('lastname', $data['last_name'], time() + 14*24*3600, null, null, false, true);
				setcookie('firstname', $data['first_name'], time() + 14*24*3600, null, null, false, true);
			}
		header('Location: index.php');
		}
	}
	require('view/frontend/connectionView.php');
}

//fonction de déconnexion
function logout()
{
	$_SESSION = array();
	session_destroy();
	setcookie('username');
	unset($_COOKIE['username']);
	setcookie('password');
	unset($_COOKIE['password']);
	setcookie('firstname');
	unset($_COOKIE['firstname']);
	setcookie('lastname');
	unset($_COOKIE['lastname']);
	header('Location: index.php');
}

//Page de modification du mot de passe
//Modification en 3 étapes (1-demande du username | 2-réponse à la question secrète | 3-nouveau mot de passe)
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
			$data = getUserInfos($usernameForgotPsw);
			$userQuestion = $data['question'];
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
			updateUserPassword($username, $newPassword);
			$updatePswStatus = true;
			header('Location: index.php?updatePswStatus='.$updatePswStatus);
		}
	}
	//Affichage
	require('view/frontend/forgotPasswordView.php');
}

//Page d'accueil, liste des partenaires
function listPartners()
{

	$data = getPartners();
	require('view/frontend/listPartnersView.php');
}

//retourne la 1ère phrase d'une chaîne de cractères suivi de points de suspension
function cutString($string/*, $length = 150*/) 
{
	$sentence = explode(".", $string);
	/*if(strlen($string) <= $length)
	{
		return $txt;
	}
 	$string = substr($string, 0, $length);*/

 	/*return substr($string, 0, strrpos($string, ' ')).'...';*/
 	return $sentence[0].'...';
}

//Page de la liste des commentaires des partenaires
function listComments()
{
	$idPartner= htmlspecialchars($_GET['partner']);

	$totalPartners = countPartners();

	if (!ctype_digit($idPartner) AND $idPartner < $totalPartners OR $idPartner > $totalPartners OR $idPartner == 0) 
	{
		header('Location: index.php');
	}
	else
	{
		$partner = getPartnerInfos($idPartner); //récupère les données des partenaires
		$data = getComments($idPartner); //récupère les données des commentaires
		$totalComments = countComments($idPartner); //compte le nombre total de commentaires
		$userInfos = getUserInfos($_SESSION['username']); //récupère les données de l'utilisateur connecté

		$req = checkAlreadyVoted($userInfos['id_user'], $idPartner); //vérifie si l'utilisateur connecté à déjà voté
		$dataVote = $req->fetch();
		$req->closecursor();

		if (isset($_GET['like'])) 
		{
			$voteValue = (int) htmlspecialchars($_GET['like']);
		
			if($dataVote['already_voted'] == 0)
			{
				addVote($userInfos['id_user'], $idPartner, $voteValue);
				/*header('Location: index.php?action=comments&amp;partner='.htmlspecialchars($partner['id_partner']));*/
			}
			elseif($dataVote['already_voted'] == 1 AND $dataVote['vote'] != 1)
			{
				updateVote($userInfos['id_user'], $idPartner, $voteValue);
			}

			$req = checkAlreadyVoted($userInfos['id_user'], $idPartner);
			$dataVote = $req->fetch();
			$req->closecursor();
		}
		elseif (isset($_GET['dislike'])) 
		{
			$voteValue = (int) htmlspecialchars($_GET['dislike']);

			if($dataVote['already_voted'] == 0)
			{
				addVote($userInfos['id_user'], $idPartner, $voteValue);
				$alreadyVoted = 1;
				/*header('Location: index.php?action=comments&amp;partner='.htmlspecialchars($partner['id_partner']));*/
			}
			elseif($dataVote['already_voted'] == 1 AND $dataVote['vote'] != 2)
			{
				updateVote($userInfos['id_user'], $idPartner, $voteValue);
				$alreadyVoted = 1;
			}

			$req = checkAlreadyVoted($userInfos['id_user'], $idPartner);
			$dataVote = $req->fetch();
			$req->closecursor();
		}

		$likeVotes = countLikeVotes($idPartner);
		$dislikeVotes = countDislikeVotes($idPartner);

		//On vérifie si l'utilisateur à déjà commenté
		$alreadyCommented = checkAlreadyCommented($idPartner, $userInfos['id_user']);

		require('view/frontend/listCommentsView.php');
	}
}

//Page d'ajout de commentaire
function addComment()
{
	$idPartner = htmlspecialchars($_GET['partner']);

	$totalPartners = countPartners();

	if (!ctype_digit($idPartner) AND $idPartner < $totalPartners OR $idPartner > $totalPartners OR $idPartner == 0) 
	{
		header('Location: index.php');
	}
	
	$partner = getPartnerInfos($idPartner);

	if (isset($_POST['newComment'])) 
	{	
		$userInfos = getUserInfos($_SESSION['username']);
		$alreadyCommented = checkAlreadyCommented($idPartner, $userInfos['id_user']);

		$newComment = htmlspecialchars($_POST['newComment']);
		$checkCommentNotEmpty = checkQuestionAnswer($newComment);

		if(!$alreadyCommented AND $checkCommentNotEmpty)
		{
			addCommentDB($userInfos['id_user'], $idPartner, $newComment);
			$ancre='#comments_block';
			header('Location: index.php?action=comments&partner='.$idPartner.$ancre);
		}
	}
		
	require('view/frontend/addCommentView.php');
}