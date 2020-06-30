<?php

function dbConnect()
{
    $db = new PDO('mysql:host=localhost;dbname=GBAF;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    return $db;
}

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

function getUserInfos($username)
{
	$db=dbConnect();

	$req = $db->prepare('SELECT * FROM accounts WHERE username=?');
	$req->execute(array($username));
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

function countPosts($idPartner)
{
	$db=dbConnect();

	$req=$db->prepare('SELECT count(id_post) AS total_posts FROM posts WHERE id_partner=?');
	$req->execute(array($idPartner));
	$data = $req->fetch();
	$req->closecursor();

	return $data['total_posts'];
}
//Fonction en cour