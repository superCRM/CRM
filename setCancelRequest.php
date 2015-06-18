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
include_once "library/getOrderList.php";
include_once ('library/createRefundItem.php');

$orderList = array();
$ordr = array();
$sum = 0;
$numb = 0;

session_start();

?>

<div class="col-md-3"></div>
<div class="col-md-6 border-form" style="height: 800px;">
    <div class="center-block">
        <form class="form-inline">
            <input type="email" placeholder="Email">
            <input type="number" class="input input-small" placeholder="order_id">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>
    <br>

<?php
        if(array_key_exists('searchButton',$_POST) || array_key_exists('addButton',$_POST)) {
if (isset($_POST['email']))
    $orderList = getOrderList(getConnect(), $_POST['email']);
?>

        <table class="table table-hover">
            <thead>
            <tr>
                <th></th>
                <th>Order number</th>
                <th>Product</th>
                <th>Sum</th>
                <th>Already refunded sum</th>
                <th></th>
            </tr>
            </thead>
            <?php for ($i = 0;
            $i < count($orderList);
            $i++) { ?>


            <tbody>
            <tr class="success">
                <td><input type="radio" name="ordr_num" value="<?= $orderList[$i]['order_num'] ?>"></td>
                <td><?= $orderList[$i]['order_num'] ?></td>
                <td><?= $orderList[$i]['product'] ?></td>
                <td><?= $orderList[$i]['sum'] ?></td>
                <td><?= $orderList[$i]['refunded_sum'] ?></td>
            </tr>
            <?php } ?>
            <td><input type="text" class="form-control" name="sum" id="inputPassword3" placeholder="Sum"></td>
            <td>
                <button style="margin:5px;" type="submit" class="btn btn-primary" name="addButton" value="addButton">
                    Add
                </button>
            </td>
            </tbody>
        </table>
    </form>


    <?php
    if (isset($_POST['ordr_num'])) $ordr = getOrder(getConnect(), $_POST['ordr_num']);
    global $sum;
    global $numb;
    if (isset($_POST['sum'])) $sum = $_POST['sum'];
    if (isset($_POST['ordr_num'])) $numb = $_POST['ordr_num'];

    }

if(array_key_exists('addButton',$_POST)) {
var_dump($ordr);
    if (createRefund(getConnect(), $ordr[0]['email_us'], $ordr[0]['product'], $sum, $numb, $_SESSION['id'])) {
        echo "Added";
        header("Location: setCancelRequest.php");
    }

}
?>

</div>
<div class="col-md-3"></div>