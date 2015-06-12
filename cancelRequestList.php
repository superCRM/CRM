<?php
/**
 * Created by PhpStorm.
 * User: unevmerzhuzkiy
 * Date: 6/11/15
 * Time: 5:27 PM
 */
include_once 'header.html';
include_once 'library/db.php';
include_once 'library/getRefundList.php';
include_once ('library/createRefundItem.php');

$cancelRequestList = getRefundList(getConnect(), 0);


var_dump($_POST);

if(array_key_exists('but',$_POST)) {
    if (isset($_POST['email']) && isset($_POST['product']) && isset($_POST['quantity']) &&
        createRefund(getConnect(), $_POST['email'], $_POST['product'], $_POST['quantity'], 0)) {
        header("Location: cancelRequestList.php");
        echo "67";
        //   exit();
    }
}

?>
    <div class="border-form">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>User email</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>
            <?php foreach($cancelRequestList as $request):?>
                <tbody>
                    <tr class="success">
                        <td><?=$request['email_us']?></td>
                        <td><?=$request['product']?></td>
                        <td><?=$request['product_num']?></td>
                        <td><?=$request['date']?></td>
                        <td><a href="cancelRequestItem.php?id=<?=$request['id']?>">Send</a> </td>
                    </tr>
                </tbody>
            <?php endforeach ?>
            <form class="form-horizontal" method = post>
                <td><input type="text" class="form-control" name="email" id="inputPassword3" placeholder="Email"></td>
                <td><input type="text" class="form-control" name="product" id="inputPassword3" placeholder="Product"></td>
                <td><input type="text" class="form-control" name="quantity" id="inputPassword3" placeholder="Quantity"></td>
                <td></td>
                <td><button style="margin:5px;" type="submit" class="btn btn-primary" name="but" value="addButton">Add</button></td>
            </form>
        </table>

    </div>