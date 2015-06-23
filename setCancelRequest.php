<?php
/**
 * Created by PhpStorm.
 * User: unevmerzhuzkiy
 * Date: 6/15/15
 * Time: 4:26 PM
 */
include_once 'header.html';
include_once "library/db.php";
include_once "library/getOrder.php";
include_once "library/getKeysOrder.php";
include_once "library/getOrderList.php";
include_once 'library/createRefundItem.php';

if (!isset($_SESSION['refundList'])) {
    $refundList = array();
    $_SESSION['refundList'] = $refundList;
}

$orderList = array();
$ordr = array();
$sum = 0;
$numb = 0;

$keys = array();

session_start();

if (!isset($_POST['email']) &&  !isset($_POST['addButton'])) {
?>

<div class="col-md-3"></div>
<div class="col-md-6 border-form" style="height: 800px;">
    <div class="center-block">
        <form class="form-inline" method="post">
            <input type="email" name="email" placeholder="Email">
            <!--<button style="margin:5px;" type="submit" class="btn btn-primary" name="searchButton" value="searchButton">Search</button>-->
            <button style="margin:5px;" type="submit" class="btn btn-primary" name="submitEmail" value="submitButton">
                Submit
            </button>
        </form>
    </div>
    <br>

    <?php
    if (isset($_POST['email'])) $_SESSION['user_email'] = $_POST['email'];
    }

    if (isset($_POST['addButton'])) {

        $refundList = $_SESSION['refundList'];
    }
    else $refundList = array();

    if (isset($_POST['email']) || isset($_POST['addButton'])) {

    echo "Adding cancel request to user {$_SESSION['user_email']}.";
 //   $orderList = getOrderList(getConnect(), $_POST['email']);
?>

    <form action = "" method = "post">


        <table class="table table-hover">
            <thead>
            <tr>

                <th>Key id</th>
                <th>Percent</th>
                <th>Deactivate?</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php for ($i = 0; $i < count($refundList); $i++) { ?>

                <tr class="success">
                    <td><?= $refundList[$i]['key_id'] ?></td>
                    <td><?= $refundList[$i]['percent'] ?>%</td>
                    <td><input type="radio" name="deactiv" value="<?= $refundList[$i]['deactivate'] ?>"></td>

                    <td>
                        <button style="margin:5px;" type="submit" class="btn btn-primary" name="deleteButton" value="deleteButton">
                            Del
                        </button>
                    </td>

                </tr>
            <?php } ?>
            <tr>
                <td><input type="text" name="key_id" placeholder="Key_id"></td>
                <td><input type="text" name="percent" placeholder="Percent">%</td>
                <td></td>
                <td>
                    <button style="margin:5px;" type="submit" class="btn btn-primary" name="addButton" value="addButton">
                        Add
                    </button>
                </td>
            </tr>

            </tbody>
        </table>
        <button style="margin:5px;" type="submit" class="btn btn-primary" name="submitButton" value="submitButton">
            Submit
        </button>
    </form>

    <?php

}
    var_dump($_POST);

if (isset($_POST['key_id']) && isset($_POST['percent'])) {
    // array_push($refundList, array('key_id' => $_POST['key_id'], 'percent' => $_POST['percent']));
    $number = count($refundList);
    echo "$number";
    $refundList[$number]['key_id'] = $_POST['key_id'];
    $refundList[$number]['percent'] = $_POST['percent'];
    $refundList[$number]['deactivate'] = $number;
    var_dump($refundList);
    $_SESSION['refundList'] = $refundList;
    $_POST['key_id'] = null;
    $_POST['percent'] = null;
}

?>

</div>
<div class="col-md-3"></div>