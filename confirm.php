<?php

$user_id = $_GET['id'];
$token = $_GET['token'];
require 'includes/db.php';
//On recupere les infos de l'utilisateur
$req = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$req->execute([$user_id]);
$user = $req->fetch();

session_start();
if($user && $user->confirm_token == $token){
	
	//Reset du token
	$req = $pdo->prepare('UPDATE users SET confirm_token = NULL, confirm_at = NOW() WHERE id = ?');
	$req->execute([$user_id]);
	//On sauvegarde les données de l'utilisateur dans la variable de session
	$_SESSION['auth'] = $user;
	var_dump($req);
	header('Location: compte.php');
	die('ok');

} else {
	//Message flash = message qui s'affiche une fois puis se supprime de $_SESSION
	$_SESSION['flash']['danger'] = "Ce token n'est plus valide";
	header('Location: login.php');
}