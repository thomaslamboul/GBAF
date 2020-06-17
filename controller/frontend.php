<?php

require('model/frontend.php');

function connection()
{

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

function list_partners()
{

}

function list_comments()
{

}