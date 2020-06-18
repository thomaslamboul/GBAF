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