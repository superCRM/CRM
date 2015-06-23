<?php
include_once('library/db.php');
include_once ('library/getRefundItem.php');
$items = array();
if (isset($_GET['id'])) $items = getRefundInfo(getConnect(), $_GET['id']);
//        var_dump($items);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Item Refund</title>
	<link rel='stylesheet' href='css/style.css'>
	<link rel='stylesheet' href='css/bootstrap.min.css' type='text/css'>
	<script src="js/addEvent.js"></script>

</head>
    <body>
	    <div class="col-md-3"></div>
            <div class="border-form col-md-6">
                <table class="table table-hover">
                    <thead>
                        <th>Product name</th>
                        <th>Refund sum</th>
                    </thead>
                    <tbody>
                        <?php for($i = 0; $i < count($items); $i++) {?>
                            <tr class="success">
                            <th><?=$items[$i]['product_name']?></th>
                            <th><?=$items[$i]['sum']?></th>
                            </tr>
                        <?php } ?>
                    <tbody>
                </table>
                <div >
                    <button style="margin:5px;" type="submit" class="btn btn-success">Send</button>
                    <a href="cancelRequestList.php" style="margin:5px;" class="btn btn-default">Back</a>

                </div>
		    </div>
        <div class="col-md-3"></div>
		<script src="js/jquery-1.11.3.min.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/timer.js"></script>
		<script src="js/addEvent.js"></script>
	</body>
</html>