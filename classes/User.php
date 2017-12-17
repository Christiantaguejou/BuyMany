<?php

class User{


	public function __construct(){
	}

	public function inscription($db,$nom, $prenom, $email, $pseudo, $mdp){
		$mdp = password_hash($mdp, PASSWORD_BCRYPT);
		$token = Str::random(60);
		$db->query("INSERT INTO users SET nom = ?, prenom = ?, email = ?, pseudo = ?, mdp = ? , confirm_token= ?",[
			$nom, 
			$prenom, 
			$email, 
			$pseudo, 
			$mdp, 
			$token
		]);


		$user_id = $this->db->lastInsertId();

		$headers =  'MIME-Version: 1.0' . "\r\n"; 
		$headers .= 'From: Christian TAGUEJOU <christiantaguejou@gmail.com>' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
		ini_set('SMTP','smtp.free.fr');
		mail($email, 'Confirmation de la création de votre compte sur BuyMany', "Afin de valider votre compte, merci de cliquer sur ce lien\n\nhttp://localhost:8012/BuyMany/confirm.php?id=$user_id&token=$token", $headers);
			
	}

	public function confirm($db,$user_id, $token, $session){
		$user = $db->query('SELECT * FROM users WHERE id = ?',[$user_id])->fetch();
		//Session::getInstance()->setFlash('success', $user);
		/**debug($user);
		debug($token);
		die();*/
		if($user && $user->confirm_token == $token){
			
			//Reset du token
			$this->db->query('UPDATE users SET confirm_token = NULL, confirm_at = NOW() WHERE id = ?',[$user_id]);
			$session->write('auth', $user);
			return true;

		} else {
			return false;
		}
	}

	public function restrict($session){
		if(!$session->read('auth')){
			$session->setFlash('danger', "Vous n'avez pas le droit d'acceder à cette page");
			header('Location: login.php');
			exit();
		}
	}
}