<?php include_once 'header.html'; ?>
    <div class="col-md-4"></div>
	<div class="border-form col-md-4">
		<label class="col-sm-2"><h2><b>Authorization</b></h2></label><br><br><br><br>
		<form class="form-horizontal" method="POST">
			 <div class="form-group">
			    <label for="inputEmail3" class="col-sm-5 control-label">Login</label>
			    <div class="col-sm-5">
			      <input type="text" class="form-control" name="login" id="inputEmail3" placeholder="Login">
			    </div>
			  </div>
			  <div class="form-group">
			    <label for="inputPassword3" class="col-sm-5 control-label">Password</label>
			    <div class="col-sm-5">
			      <input type="password" class="form-control" name="password" id="inputPassword3" placeholder="Password">
			    </div>
			  </div>
			  <div class="form-group">
                  <div class="center-block">
			        <button style="margin:5px;" type="submit" class="btn btn-primary">Sign in</button>
                    <a href="regForm.php" style="margin:5px;" type="submit" class="btn btn-success">Sign up</a>
                  </div>
              </div>
		</form>	
	</div>
    <div class="col-md-4"></div>
<?php

include_once 'footer.html';
include_once('library/db.php');
include_once ('library/checkAgent.php');
include_once ('library/userList.php');
include_once ('library/validate.php');
include_once ('library/createRefundItem.php');

if (isset($_POST['login']) && isset($_POST['password'])){

    $id = checkAgent(getConnect(), $_POST['login'] , $_POST['password']);

    if($id != false){
        session_start();
        $_SESSION['login'] = $_POST['login'];
        $_SESSION['id'] = $id;
        header("Location: cancelRequestList.php");
    }

}

?>
	
