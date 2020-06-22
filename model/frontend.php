<?php

function dbConnect()
{
    $db = new PDO('mysql:host=localhost;dbname=GBAF;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    return $db;
}

function checkPostsConnection($username, $password)
{
	$db=dbConnect();

	$req = $db -> query('SELECT username, password FROM members');
	while ($data = $req->fetch()) 
	{
	    if ($username == $data['username'] AND password_verify($password, $data['password'])) 
	    {
			$req->closecursor();
			return true;
			break;	
	    }
	}
	$req->closecursor();
	return false;
}

function checkPostUsername($username)
{
	$db=dbConnect();

	//On compare chaque username de la BDD avec le username envoyé pour voir s'il existe déjà 
	$req = $db -> query('SELECT username FROM members');
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

function addMember($lastname, $firstname, $username, $password, $question, $answer)
{
	$db=dbConnect();

	$req=$db->prepare('INSERT INTO members(last_name, first_name, username, password, question, answer, registration_date) VALUES(:last_name, :first_name, :username, :password, :question, :answer, CURDATE())');
		$req->execute(array(
            	'last_name' => $lastname,
            	'first_name' => $firstname,
            	'username' => $username, 
            	'password' => $password,
            	'question' => $question,
            	'answer' => $answer,
            ));
}

function getUserQuestion($username)
{
	$db=dbConnect();

	$req = $db->prepare('SELECT question FROM members WHERE username=?');
	$req->execute(array($username));
	$data = $req->fetch();
	$req->closecursor();

	return $data['question'];
}

function checkUserAnswer($answer, $username)
{
	$db=dbConnect();

	$req = $db->prepare('SELECT answer FROM members WHERE username=?');
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

function changeUserPassword($username, $password)
{
	$db=dbConnect();

	$req=$db->prepare('UPDATE members SET password= :newPassword WHERE username= :username');
		$req->execute(array(
            	'newPassword' => $password,
            	'username' => $username
            ));
}