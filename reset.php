 <?php include 'includes/header.php';
 include 'includes/functions.php';
 ?>

 <?php if(isset($_GET['id']) && isset($_GET['token'])){
      include 'includes/db.php';

      $req = $pdo->prepare('SELECT * FROM users WHERE id = ? AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE )');
      $req->execute([$_GET['id'], $_GET['token']]);
      $user = $req->fetch();

      if($user){
        if(!empty($_POST)){
          if(!empty($_POST['mdp']) && $_POST['mdp2'] == $_POST['mdp']){
            $mdp = password_hash($_POST['mdp'], PASSWORD_BCRYPT);
            $pdo->prepare('UPDATE users SET mdp = ?, reset_at = NULL, reset_token = NULL')->execute([$mdp]);
             if(session_status() == PHP_SESSION_NONE){
              session_start(); 
            }
            $_SESSION['flash']['success'] = "Votre mot de passe a été modifié ! ";
            $_SESSION['auth'] = $user;
            header('Location: compte.php');
            exit();
           }
        }
      } else{
        session_start();
        $_SESSION['flash']['danger'] = "Ce token n'est pas valide";
        header('Location: login.php');
        exit();
      }
 } else{
    header('Location: login.php');
    exit();
 }
?>

<h1>Réinitilialisation du mot de passe</h1>

  <form action='' method="POST">
    <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label">Mot de Passe</label>
      <div class="col-sm-10">
        <input type="password" class="form-control" name="mdp" placeholder="Password" required>
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label">Confirmer mot de passe </label>
      <div class="col-sm-10">
        <input type="password" class="form-control" name="mdp2" placeholder="Password" required>
      </div>
    </div>
    <div class="form-group">
	    <div class="col-md-6 col-md-offset-3">
	        <button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-log-in"></span> Réinitialiser </button>
	    </div>
	</div>
  </form>

<?php include 'includes/footer.php'?>