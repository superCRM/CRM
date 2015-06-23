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
//    $_SESSION['refundList'] = $refundList;
}
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
    }
    if (isset($_POST['email'])) $_SESSION['user_email'] = $_POST['email'];
    if (isset($_POST['addButton'])) {
        $refundList = $_SESSION['refundList'];
    }
    //  else $refundList = array();
    if (isset($_POST['email']) || isset($_POST['addButton'])) {
        echo "Adding cancel request to user {$_SESSION['user_email']}.";
        if (isset($_SESSION['refundList'])) {
            //   $orderList = getOrderList(getConnect(), $_POST['email']);
            ?>

            <form action="" method="post">


            <table class="table table-hover">
            <thead>
            <tr>

                <th>Key id</th>
                <th>Deactivate?</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php for ($i = 0; $i < count($refundList); $i++) { ?>

                <tr class="success">
                    <td><?= $refundList[$i] ?></td>
                    <td><input type="checkbox" name="keyToCancel[]" value="<?= $refundList[$i] ?>"/></td>

                    <td>
                        <button style="margin:5px;" type="submit" class="btn btn-primary" name="deleteButton"
                                value="deleteButton">
                            Del
                        </button>
                    </td>

                </tr>
            </tbody>
            </table>
            <?php }
        }?>
        <br><input class="col-md-1" type="text" name="key_id" placeholder="Key_id">
        <input class="col-md-2 col-md-offset-1" type="text" name="percent" placeholder="Percent">
        <button class="col-md-1 col-md-offset-6" style="margin:5px;" type="submit" class="col-md-10 btn btn-primary" name="addButton" value="addButton">
                Add
        </button><br>
        <button style="margin:5px;" type="submit" class="btn btn-primary" name="submitButton" value="submitButton">
            Submit
        </button>
        </form>

    <?php
    }
    if (isset($_POST['submitButton'])) unset($_SESSION['refundList']);
    var_dump($_POST);
    if (isset($_POST['key_id']) && $_POST['key_id'] != "") {
        // array_push($refundList, array('key_id' => $_POST['key_id'], 'percent' => $_POST['percent']));
        $number = count($refundList);
        echo "$number";
        $refundList[$number] = $_POST['key_id'];
        var_dump($refundList);
        $_SESSION['refundList'] = $refundList;
        $_POST['key_id'] = null;
    }
    ?>

</div>
<div class="col-md-3"></div>