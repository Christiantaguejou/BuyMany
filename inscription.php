<?php require 'includes/functions.php' ?>

<?php
session_start();
	if(!empty($_POST)){

		$errors = array();
		require_once'includes/db.php';

		if(empty($_POST['nom']) || !preg_match('/^[a-zA-Z]+$/', $_POST['nom'])){
			$errors['nom'] = "Votre nom n'est pas valide ! (alphabetique)";
		} 

		if(empty($_POST['prenom']) || !preg_match('/^[a-zA-Z]+$/', $_POST['prenom'])){
			$errors['prenom'] = "Votre prénom n'est pas valide ! (alphabetique)";
		}
		if(empty($_POST['pseudo']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['pseudo'])){
			$errors['pseudo'] = "Votre pseudo n'est pas valide ! (alphanumérique)";
		}else{
			$req = $pdo->prepare('SELECT id FROM users WHERE pseudo = ?');
			$req->execute([$_POST['pseudo']]);
			$pseudo = $req->fetch();
			if($pseudo){
				$errors['pseudo'] = 'Ce pseudo est déjà pris';
			}
		}

		if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
			$errors['email'] = "Votre email n'est pas valide !";
		} else{
			$req = $pdo->prepare('SELECT id FROM users WHERE email = ?');
			$req->execute([$_POST['email']]);
			$email = $req->fetch();
			if($email){
				$errors['email'] = 'Cet email est déjà utilisé par un autre compte';
			}
		}

		if(empty($_POST['mdp']) || $_POST['mdp'] != $_POST['mdpConfirm']){
			$errors['mdp'] = "Votre devez rentrer un mot de passe valide !";
		}

		if(empty($errors)){
			$req = $pdo->prepare("INSERT INTO users SET nom = ?, prenom = ?, email = ?, pseudo = ?, mdp = ? , confirm_token= ?");
			$mdp = password_hash($_POST['mdp'], PASSWORD_BCRYPT);
			$token = str_random(60);
			debug($token);
			$req->execute([$_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['pseudo'], $mdp, $token]);
			$user_id = $pdo->lastInsertId();
			var_dump($user_id);
			var_dump($_POST['email']);
			$headers =  'MIME-Version: 1.0' . "\r\n"; 
			$headers .= 'From: Christian TAGUEJOU <christiantaguejou@gmail.com>' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
			//ini_set('SMTP','smtp.free.fr');
			ini_set('SMTP', 'smtp.free.fr');
			ini_set('smtp_port', '25');
		  	ini_set('Christian TAGUEJOU', 'christiantaguejou@gmail.com');
			mail($_POST['email'], 'Confirmation de la création de votre compte sur BuyMany', "Afin de valider votre compte, merci de cliquer sur ce lien\n\nhttp://localhost:8012/BuyMany/confirm.php?id=$user_id&token=$token", $headers);
			$_SESSION['flash']['success'] = "Un email de confirmation vous a été envoyé ! ";
			header('Location: login.php');
			exit();
		}
		//debug($errors);
	}
?>

<?php include 'includes/header.php'?>
<?php if(isset($errors)):?>
<?php if(empty(!$errors)):?>
	<div class="alert alert-danger">
		<p>Vous n'avez pas rempli le formulaire correctement</p>
		<?php foreach($errors as $error):?>
			<ul>
				<li><?= $error; ?></li>
			</ul>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
<?php endif; ?>

 <form action="" method="POST">
  	<div class="form-group row">
      <label for="inputNom" class="col-sm-2 col-form-label">Nom</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="nom" placeholder="Nom" >
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPrenom" class="col-sm-2 col-form-label">Prenom</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="prenom" placeholder="Prenom">
      </div>
    </div>
    <div class="form-group row">
      <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
      <div class="col-sm-10">
        <input type="email" class="form-control" name="email" placeholder="Email">
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPseudo" class="col-sm-2 col-form-label">Pseudo</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="pseudo" placeholder="Pseudo">
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label">Mot de passe</label>
      <div class="col-sm-10">
        <input type="password" class="form-control" name="mdp" placeholder="Password">
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label">Confirmez votre mot de passe</label>
      <div class="col-sm-10">
        <input type="password" class="form-control" name="mdpConfirm" placeholder="Password">
      </div>
    </div>
    <div class="form-group">
	    <div class="col-md-6 col-md-offset-3">
	        <button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-log-in"></span> Valider</button>
	    </div>
	</div>
  </form>

<?php include 'includes/footer.php'?>