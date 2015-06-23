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



session_start();

if (!isset($_POST['email']) &&  !isset($_POST['addButton']) && !isset($_POST['deleteButton'])) {
?>

<div class="col-md-3"></div>
<div class="col-md-6 border-form" style="height: 800px;">
    <div class="center-block">
        <form class="form-inline" method="post">
            <input type="email" name="email" placeholder="Email">
            <!--<button style="margin:5px;" type="submit" class="btn btn-primary" name="searchButton" value="searchButton">Search</button>-->
            <button style="margin:5px;" type="submit" class="btn btn-primary" name="submitEmail" value="submitEmail">
                Submit
            </button>
        </form>
    </div>
    <br>

    <?php

    }
    if (isset($_POST['email'])) $_SESSION['user_email'] = $_POST['email'];

    if (isset($_SESSION['refundList'])) {

        $refundList = $_SESSION['refundList'];
    }
  //  else $refundList = array();

    if (isset($_POST['email']) || isset($_POST['addButton']) || isset($_POST['deleteButton'])) {

    echo "Adding cancel request to user {$_SESSION['user_email']}.<br>";


        //   $orderList = getOrderList(getConnect(), $_POST['email']);
        ?>

        <form class="form-inline border-form col-md-8" action="setCancelRequest.php" method="post">


            <table class="table table-hover">
                <?php if (isset($_SESSION['refundList'])) { ?>
                <thead>
                <tr>

                    <th>Key id</th>
                    <th>Deactivate?</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                    foreach($refundList as $refund) : ?>

                        <tr class="success">
                            <td><?= $refund ?></td>
                            <td><input type="checkbox" name="keyToCancel[]" value="<?= $refund ?>"/></td>

                            <td>
                                <button style="margin:5px;" type="submit" class="btn btn-primary" name="deleteButton"
                                        value="<?= $refund  ?>">
                                    Delete
                                </button>
                            </td>

                        </tr>
                    <?php endforeach;
                } ?>
                </tbody>
            </table>
            </form>
        <br>
            <input type="text" name="key_id" placeholder="Key_id">
                        <button style="margin:5px;" type="submit" class="btn btn-primary" name="addButton"
                                value="addButton">
                            Add
                        </button>
            <br>

            <input type="text" name="percent" placeholder="Percent">%
            <button style="margin:5px;" type="submit" class="btn btn-primary" name="submitButton" value="submitButton">
                Submit
            </button>


    <?php

}
if (isset($_POST['submitButton'])) {
    $_POST['refundList'] = $_SESSION['refundList'];
    unset($_SESSION['refundList']);
}
   var_dump($_POST);
    var_dump($_SESSION);
//    var_dump(in_array( $_POST['key_id'], $refundList));
if (isset($_POST['deleteButton'])) {
    $refundList = array_diff($refundList, array($_POST['deleteButton']));
    $_SESSION['refundList'] = $refundList;
}
else
    if (isset($_POST['key_id']) && $_POST['key_id'] != "" && !in_array($_POST['key_id'], $refundList)) {
         array_push($refundList, $_POST['key_id']);
//        $number = count($refundList);
//        echo "$number";
//        $refundList[$number] = $_POST['key_id'];
        var_dump($refundList);
        $_SESSION['refundList'] = $refundList;
        unset($_POST['key_id']);

     //   header("Location: setCancelRequest.php");
    }

?>

</div>
<div class="col-md-3"></div>