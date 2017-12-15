<?php include 'includes/header.php';?>

<?php 
include 'includes/functions.php';?>

<h1>Votre compte</h1>

<?php 
if(session_status() == PHP_SESSION_NONE){
		session_start(); 
	}

if(!empty($_POST)){
	if(empty($_POST['mdp']) || $_POST['mdp'] != $_POST['mdp2']){
		$_SESSION['flash']['danger'] = "Les mots de passes ne correspondent pas";
		header('Location: compte.php');
		die('ok');
	}
	else{
		$user_id = $_SESSION['auth']->id;
		$mdp = password_hash($_POST['mdp'], PASSWORD_BCRYPT);
		include 'includes/db.php';
		$req = $pdo->prepare('UPDATE users SET mdp = ? 	WHERE id = ?');
		$req->execute([$mdp, $user_id]);
		$_SESSION['flash']['success'] = "Votre mot de passe a bien été mis à jour"; 
	}
}

?>


<h5>Modifier votre mot de passe</h5>
  <form action='' method="POST">
    <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label">Mot de passe</label>
      <div class="col-sm-10">
        <input type="password" class="form-control" name="mdp" placeholder="Changer de mot de passe">
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label">Confirmation du mot de passe</label>
      <div class="col-sm-10">
        <input type="password" class="form-control" name="mdp2" placeholder="Password">
      </div>
    </div>
    <div class="form-group">
	    <div class="col-md-6 col-md-offset-3">
	        <button type="submit" class="btn btn-default btn-primary"> Changer de mot de passe</button>
	    </div>
	</div>
  </form>

  <?php include 'includes/footer.php';?>