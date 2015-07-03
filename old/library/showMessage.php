<?php
function successMessage($text) {
?>
	<div class="container">
		<div class="col-md-3"></div>
		<div class="col-md-6  alert alert-success">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			<strong>Success!</strong> <?=$text?>
		</div>
		<div class="col-md-3"></div>
	</div>
<?php
}

function warningMessage($text) {
?>
	<div class="container">
		<div class="col-md-3"></div>
		<div class="col-md-6  alert alert-warning">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			<strong>Warning!</strong> <?=$text?>
		</div>
		<div class="col-md-3"></div>
	</div>


<?php
}