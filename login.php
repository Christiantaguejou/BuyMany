<?php include 'header.php'?>

  <form>
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