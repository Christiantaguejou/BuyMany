<?php require 'includes/functions.php';
require 'includes/autoloader.php'; 
?>

<?php
session_start();
	if(!empty($_POST)){
		$errors = array();
		require_once'includes/db.php';

		$db = App::getDatabase();
		$validation = new Validation($_POST);
		$validation->isAlpha('nom', "Votre nom n'est pas valide ! (alphabetique)");
		$validation->isAlphanumeriq('pseudo', "Votre pseudo n'est pas valide ! (alphanumérique)");
		
		$validation->isPseudoUniq('pseudo',$db, 'users', "Ce pseudo est déjà pris ");			
		
		$validation->isAlpha('prenom', "Votre prénom n'est pas valide ! (alphabetique)");

		$validation->isEmail('email',"Votre email n'est pas valide ! ");
		
		$validation->isEmailUniq('email',$db, 'users', "Cet email est déjà utilisé par un autre compte");		
		
		$validation->isConfirmed('mdp', "Vous devez rentrer un mot de passe valide");

		if($validation->isValid()){

			$user = new User();
			$user->inscription($db, $_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['pseudo'], $_POST['mdp']);
			Session::getInstance()->setFlash('success','Un email de confirmation vous a été envoyé pour valider votre compte' );

			App::redirect('login.php');
			exit();
		} else {
			$errors = $validation->getErrors();
		}
		//debug($errors);
	}
?>

<?php include 'includes/header.php';?>
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