<?php include_once 'header.html'; ?>
	<div class="border-form">
		<label class="col-sm-2"><h2><b>Autorization</b></h2></label><br><br><br><br>
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
<?php include_once 'footer.html';

include_once('library/db.php');
include_once ('library/checkAgent.php');
include_once ('library/userList.php');

if ($_POST['login'] && $_POST['password'] && checkAgent(getConnect(), $_POST['login'] , $_POST['password']))
    echo "true";
$users = getUserList(getConnect());
var_dump($users);
?>
	
