<?php include 'includes/header.php';
 include 'includes/functions.php';
 ?>

<?php debug($_SESSION);
	if(!empty($_POST) && !empty($_POST['email'])){
		require_once 'includes/db.php';
		$req = $pdo->prepare('SELECT * FROM users WHERE email = ?  AND confirm_at IS NOT NULL');
		$req->execute([$_POST['email']]);
		
		$user = $req->fetch();
		debug($user->id);
		if($user){
			 if(session_status() == PHP_SESSION_NONE){
				session_start(); 
			}
			$reset_token = str_random(60);
			$pdo->prepare('UPDATE users SET reset_token = ?, reset_at = NOW() WHERE id = ?')->execute([$reset_token, $user->id]);
			$_SESSION['flash']['success'] = "Les instructions du rappel de mot de passe vous ont été envoyé par email";

			$headers =  'MIME-Version: 1.0' . "\r\n"; 
			$headers .= 'From: Christian TAGUEJOU <christiantaguejou@gmail.com>' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
			ini_set('SMTP','smtp.free.fr');
			debug($_POST['email']);
			mail($_POST['email'], 'Réinitialisation de votre mot de passe', "Afin de réinitilialiser votre mot de passe, merci de cliquer sur ce lien\n\nhttp://localhost:8012/BuyMany/reset.php?id={$user->id}&token=$reset_token", $headers);

			header('Location: login.php');
			exit();
		} else {
			$_SESSION['flash']['danger'] = "Aucun compte ne correspond à cet adresse";
		}
	
	}

?>
<h1>Mot de passe oublié</h1>

  <form action='' method="POST">
    <div class="form-group row">
      <label for="inputPseudo" class="col-sm-2 col-form-label">Email</label>
      <div class="col-sm-10">
        <input type="email" class="form-control" name="email" placeholder="email">
      </div>
    </div>
    <div class="form-group">
	    <div class="col-md-6 col-md-offset-3">
	        <button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-log-in"></span> Valider</button>
	    </div>
	</div>
  </form>


<?php include 'includes/footer.php'?>