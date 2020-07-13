<?php

//Connexion à la BDD
function dbConnect()
{
    $db = new PDO('mysql:host=localhost;dbname=GBAF;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    return $db;
}

//Vérification de la correspondance du username et du mot de passe saisis avec ceux de la BDD dans la table 'accounts'
function checkLogins($username, $password)
{
	$db=dbConnect();

	$req = $db -> query('SELECT username, password FROM accounts');

	if(!preg_match('#^\$2y\$10#', $password))
	{
		while ($data = $req->fetch()) 
		{
			if ($username == $data['username'] AND password_verify($password, $data['password'])) 
	    	{
				$req->closecursor();
				return true;
				break;	
	    	}
	    }
	}
	else
	{
		while ($data = $req->fetch()) 
		{
			if ($username == $data['username'] AND $password == $data['password'])
	    	{
				$req->closecursor();
				return true;
				break;	
	    	}
		}
	}
	$req->closecursor();
	return false;
}

//Vérification de la correspondance du mot de passe saisis avec celui de la BDD dans la table 'accounts'
function PasswordVerify($idUser, $password)
{
	$db=dbConnect();

	$req = $db -> prepare('SELECT password FROM accounts WHERE id_user=?');
	$req->execute(array($idUser));
	$data = $req->fetch();
	$req->closecursor();

	if (password_verify($password, $data['password']))
	{
		return true;
	}
	else
	{
		return false;
	}
}

//Vérification
function checkPostUsername($username)
{
	$db=dbConnect();

	//On compare chaque username de la BDD avec le username envoyé pour voir s'il existe déjà 
	$req = $db -> query('SELECT username FROM accounts');
	while ($data = $req->fetch()) 
	{
		if ($username == $data['username']) 
		{
			$req->closecursor();
			return false;
			break;
		}
	}
	$req->closecursor();

	return true;
}

function addAccount($lastname, $firstname, $username, $password, $question, $answer)
{
	$db=dbConnect();

	$req=$db->prepare('INSERT INTO accounts(last_name, first_name, username, password, question, answer, registration_date) VALUES(:last_name, :first_name, :username, :password, :question, :answer, CURDATE())');
		$req->execute(array(
            	'last_name' => $lastname,
            	'first_name' => $firstname,
            	'username' => $username, 
            	'password' => $password,
            	'question' => $question,
            	'answer' => $answer,
            ));
}

function getUserInfosByUsername($username)
{
	$db=dbConnect();

	$req = $db->prepare('SELECT * FROM accounts WHERE username=?');
	$req->execute(array($username));
	$data = $req->fetch();
	$req->closecursor();

	return $data;
}

function getUserInfosByID($idUser)
{
	$db=dbConnect();

	$req = $db->prepare('SELECT * FROM accounts WHERE id_user=?');
	$req->execute(array($idUser));
	$data = $req->fetch();
	$req->closecursor();

	return $data;
}

function checkUserAnswer($answer, $username)
{
	$db=dbConnect();

	$req = $db->prepare('SELECT answer FROM accounts WHERE username=?');
	$req->execute(array($username));
	$data = $req->fetch();
	$req->closecursor();

	if ($answer == $data['answer']) 
	{
		return true;
	}
	else
	{
		return false;
	}

	return $answer;
}

function updateUserPassword($username, $password)
{
	$db=dbConnect();

	$req=$db->prepare('UPDATE accounts SET password= :newPassword WHERE username= :username');
		$req->execute(array(
            	'newPassword' => $password,
            	'username' => $username
            ));
}

function getPartners()
{
	$db=dbConnect();

	$req = $db -> query('SELECT * FROM partners');

	return $req;
}

function getPartnerInfos($idPartner)
{
	$db=dbConnect();

	$req=$db->prepare('SELECT * FROM partners WHERE id_partner=?');
	$req->execute(array($idPartner));
	$data = $req->fetch();
	$req->closecursor();

	return $data;
}

function countPartners()
{
	$db=dbConnect();

	$req=$db->query('SELECT count(id_partner) AS total_partners FROM partners');
	$data = $req->fetch();
	$req->closecursor();

	return $data['total_partners'];
}

function getComments($idPartner)
{
	$db=dbConnect();

	$req=$db->prepare('SELECT *, DATE_FORMAT(date_add, "Le %d/%m/%Y à %Hh%i") AS formated_date, accounts.first_name FROM posts INNER JOIN accounts ON posts.id_user=accounts.id_user WHERE id_partner=? ORDER BY date_add DESC');
	$req->execute(array($idPartner));

	return $req;
}

function countComments($idPartner)
{
	$db=dbConnect();

	$req=$db->prepare('SELECT count(id_post) AS total_comments FROM posts WHERE id_partner=?');
	$req->execute(array($idPartner));
	$data = $req->fetch();
	$req->closecursor();

	return $data['total_comments'];
}

function countLikeVotes($idPartner)
{
	$db=dbConnect();

	$req=$db->prepare('SELECT count(id_user) AS total_votes FROM votes WHERE id_partner=? AND vote=1');
	$req->execute(array($idPartner));
	$data = $req->fetch();
	$req->closecursor();

	return $data['total_votes'];
}

function countDislikeVotes($idPartner)
{
	$db=dbConnect();

	$req=$db->prepare('SELECT count(id_user) AS total_votes FROM votes WHERE id_partner=? AND vote=2');
	$req->execute(array($idPartner));
	$data = $req->fetch();
	$req->closecursor();

	return $data['total_votes'];
}

function checkAlreadyVoted($idUser, $idPartner)
{
	$db=dbConnect();

	$req=$db->prepare('SELECT vote, count(*) AS already_voted FROM votes WHERE id_user=? AND id_partner=?');
	$req->execute(array($idUser,$idPartner));

	return $req;
}

function addVote($idUser, $idPartner, $voteValue)
{
	$db=dbConnect();

	$req=$db->prepare('INSERT INTO votes VALUES(:id_user, :id_partner, :vote)');
		$req->execute(array(
            	'id_user' => $idUser,
            	'id_partner' => $idPartner,
            	'vote' => $voteValue, 
            ));
}

function updateVote($idUser, $idPartner, $voteValue)
{
	$db=dbConnect();

	$req=$db->prepare('UPDATE votes SET vote= :voteValue WHERE id_user= :idUser AND id_partner= :idPartner');
	$req->execute(array(
        	'voteValue' => $voteValue,
        	'idUser' => $idUser,
        	'idPartner' => $idPartner
        ));
}

function checkAlreadyCommented($idPartner, $idUser)
{
	$db=dbConnect();

	$req=$db->prepare('SELECT count(id_post) AS count_comment FROM posts INNER JOIN accounts ON posts.id_user=accounts.id_user INNER JOIN partners ON posts.id_partner=partners.id_partner WHERE posts.id_user= :idUser AND posts.id_partner= :idPartner');
	$req->execute(array(
			'idUser' => $idUser,
			'idPartner' => $idPartner,
	));
	$data = $req->fetch();
	$req->closecursor();

	if ($data['count_comment'] == 0) 
	{
		return false;
	}
	else
	{
		return true;
	}
}

//Insertion du commentaire dans la table 'posts'
function addCommentDB($idUser, $idPartner, $comment)
{
	$db=dbConnect();

    $req=$db->prepare('INSERT INTO posts(id_user, id_partner, date_add, post) VALUES(?, ?, NOW(), ?)');
    $req->execute(array($idUser, $idPartner, $comment));
}

//Mise à jour du nom dans la table accounts
function updateUserLastname($idUser, $lastname)
{
	$db=dbConnect();

    $req=$db->prepare('UPDATE accounts SET last_name= :newlastname WHERE id_user= :idUser');
		$req->execute(array(
            	'newlastname' => $lastname,
            	'idUser' => $idUser
            ));
}

//Mise à jour du prénom dans la table accounts
function updateUserFirstname($idUser, $firstname)
{
	$db=dbConnect();

    $req=$db->prepare('UPDATE accounts SET first_name= :newfirstname WHERE id_user= :idUser');
		$req->execute(array(
            	'newfirstname' => $firstname,
            	'idUser' => $idUser
            ));
}

//Mise à jour du username dans la table accounts
function updateUserUsername($idUser, $username)
{
	$db=dbConnect();

    $req=$db->prepare('UPDATE accounts SET username= :newUsername WHERE id_user= :idUser');
		$req->execute(array(
            	'newUsername' => $username,
            	'idUser' => $idUser
            ));
}

//Mise à jour du mot de passe dans la table accounts
function updateUserPasswordByID($idUser, $password)
{
	$db=dbConnect();

    $req=$db->prepare('UPDATE accounts SET password= :newPassword WHERE id_user= :idUser');
		$req->execute(array(
            	'newPassword' => $password,
            	'idUser' => $idUser
            ));
}

//Mise à jour de la question dans la table accounts
function updateUserQuestion($idUser, $question)
{
	$db=dbConnect();

    $req=$db->prepare('UPDATE accounts SET question= :newQuestion WHERE id_user= :idUser');
		$req->execute(array(
            	'newQuestion' => $question,
            	'idUser' => $idUser
            ));
}

//Mise à jour de la réponse dans la table accounts
function updateUserAnswer($idUser, $answer)
{
	$db=dbConnect();

    $req=$db->prepare('UPDATE accounts SET answer= :newAnswer WHERE id_user= :idUser');
		$req->execute(array(
            	'newAnswer' => $answer,
            	'idUser' => $idUser
            ));
}