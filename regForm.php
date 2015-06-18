<?php include_once 'header.html'; ?>
    <div class="col-md-3"></div>
    <div class="border-form  col-md-6">
        <label class="col-sm-2"><h2><b>Registration</b></h2></label><br><br><br><br>
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
                <label for="inputPassword3" class="col-sm-5 control-label">Email</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="email" id="inputPassword3" placeholder="Email">
                </div>
            </div>
            <div class="form-group">
                <div class="center-block">
                    <a href="autForm.php" style="margin:5px;" class="btn btn-default">Back</a>
                    <button style="margin:5px;" type="submit" class="btn btn-success">Sign up</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-3"></div>

<?php
include_once 'footer.html';
include_once('library/db.php');
include_once ('library/createAgent.php');
include_once('library/validate.php');
include_once 'library/showMessage.php';

if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['email'])){
    $status = createAgent(getConnect(), $_POST["login"], $_POST["password"], $_POST["email"]);
    if($status===true)
    {
        successMessage("You are registered!");
    }
    elseif($status===-1)
    {
        warningMessage("Enter correct data!");
    }
    else
    {
        warningMessage("User with login " . $_POST['login'] . " is already exist!");
    }
}
?>
