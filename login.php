<?php include 'includes/header.php';
 include 'includes/functions.php';
  include 'includes/db.php';


if(!empty($_POST) && !empty($_POST['pseudo']) && !empty($_POST['mdp'])){

    $req = $pdo->prepare('SELECT * FROM users WHERE (pseudo = :pseudo OR email = :pseudo) AND confirm_at IS NOT NULL');
    $req->execute(['pseudo'=>$_POST['pseudo']]);
    $user = $req->fetch();

    if($user == null){
          $_SESSION['flash']['danger'] = 'Identifiant ou mot de passe incorrect';
          header('Location: login.php');
          //On de-hash le mot de passe de l'utilisateur
      }elseif(password_verify($_POST['mdp'], $user->mdp)){
      
      $_SESSION['auth'] = $user;
      $_SESSION['flash']['success'] = "Vous êtes maintenant connecté à BuyMany!";

      if($_POST['remember']){
        $remember_token = str_random(250);
        $pdo->prepare('UPDATE users SET remember_token = ? WHERE id = ?')->execute([$remember_token, $user->id]);
        //cookie qui tiendra 7 jours
        setcookie('remember',$user->id.'--'.$remember_token.sha1('$user->id'.'buybuymany'), time() + 60 * 60 * 24 * 7);
      }
      header('Location: compte.php');
      exit();
    } else {
      $_SESSION['flash']['danger'] = "Pseudo ou mot de passe incorrect";
    }
  
  } 

?>

  <form action='' method="POST">
    <div class='form-group row'>
      <label for='inputPseudo' class="col-sm-2 col-form-label">Pseudo ou email</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="pseudo" placeholder="Pseudo" required>
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label">Mot de Passe <a href="forget.php"><br/>Mot de passe oublié !</a></label>
      <div class="col-sm-10">
        <input type="password" class="form-control" name="mdp" placeholder="Password" required>
      </div>
      <div class="form-group">
        <label> 
          <input type="checkbox" name="remember" value="1"/> Se souvenir de moi 
        </label>
      </div>
    </div>
    <div class="form-group">
      <div class="col-md-6 col-md-offset-3">
          <button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-log-in"></span> Valider</button>
      </div>
  </div>
  </form>


<?php include 'includes/footer.php'?>