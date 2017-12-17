<?php require 'includes/autoloader.php';
require 'includes/functions.php';
require 'includes/db.php';
$db = App::getDatabase();
$auth = new User();


if($auth->confirm($db, $_GET['id'], $_GET['token'], Session::getInstance())){
	Session::getInstance()->setFlash('success', "Votre compte a bien été validé ! ");
	App::redirect('compte.php');
} else {
	Session::getInstance()->setFlash('danger', "Ce token n'est plus valide");
	App::redirect('login.php');
}