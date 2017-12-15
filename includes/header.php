<?php 
	if(session_status() == PHP_SESSION_NONE){
		session_start(); 
	}?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <title>Buy Many</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="asset/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
	<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
	  	<a class="navbar-brand" href="#">BuyMany</a>
	  	<div class="collapse navbar-collapse" id="navbarNavDropdown">
		    <ul class="navbar-nav">
		      <li class="nav-item active">
		        <a class="nav-link" href="index.php">Accueil <span class="sr-only">(current)</span></a>
		      </li>
		      	<li class="nav-item">
		        <a class="nav-link" href="compte.php">Mon Compte</a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="#">Menu 3</a>
		      </li>
		      <li class="nav-item dropdown">
		        <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          A supprimé
		        </a>
		        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
		          <a class="dropdown-item" href="#">Action</a>
		          <a class="dropdown-item" href="#">Another action</a>
		          <a class="dropdown-item" href="#">Something else here</a>
		        </div>
		      </li>
		    </ul>

 		
	 	</div>
	   <ul class="nav navbar-nav navbar-right" >
	   	<?php if(isset($_SESSION['auth'])):?>
			<li class="nav-item">
	      	<a class="nav-link" href="logout.php" >Déconnexion</a>
	      </li>
	   	<?php else:?>
	      <li class="nav-item">
	      	<a class="nav-link" href="login.php" >Connexion</a>
	      </li>
	      <li class="nav-item">
	      	<a class="nav-link" href="inscription.php" >Inscription</a>
	      </li>
	    <?php endif;?>
	    </ul>
	</nav>
	<div class="container">
		<div style="margin-bottom: 30px"></div>

		<?php if(isset($_SESSION['flash'])): ?>
			<?php foreach($_SESSION['flash']  as $type => $message):?>
				<div class="alert alert-<?= $type?>">
					<?= $message; ?>
				</div>
			<?php endforeach; ?>
			<?php unset($_SESSION['flash']) ;?>
		<?php endif;?>