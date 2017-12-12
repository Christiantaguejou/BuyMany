<?php include 'header.php'?>

 <form>
  	<div class="form-group row">
      <label for="inputNom" class="col-sm-2 col-form-label">Nom</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="inputNom" placeholder="Nom">
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPrenom" class="col-sm-2 col-form-label">Prenom</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="inputPrenom" placeholder="Prenom">
      </div>
    </div>
    <div class="form-group row">
	  <label for="example-date-input" class="col-2 col-form-label">Date de Naissance</label>
	  <div class="col-10">
	    <input class="form-control" type="date" value="2017-12-11" id="example-date-input">
	  </div>
	</div>
    <div class="form-group row">
      <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
      <div class="col-sm-10">
        <input type="email" class="form-control" id="inputEmail" placeholder="Email">
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPseudo" class="col-sm-2 col-form-label">Pseudo</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="inputPseudo" placeholder="Pseudo">
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
      <div class="col-sm-10">
        <input type="password" class="form-control" id="inputPassword" placeholder="Password">
      </div>
    </div>
    <div class="form-group">
	    <div class="col-md-6 col-md-offset-3">
	        <button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-log-in"></span> Valider</button>
	    </div>
	</div>
  </form>

<?php include 'footer.php'?>