<?php
/**
 * Created by PhpStorm.
 * User: unevmerzhuzkiy
 * Date: 6/15/15
 * Time: 4:26 PM
 */
include_once "library/db.php";
include_once "/library/getOrderList.php";
$orderList = array();
if(isset($_POST['email']))
$orderList= getOrderList(getConnect(),$_POST['email']);

?>
<div class="border-form">
    <form class="form-horizontal" method = post>
        <td><input type="text" class="form-control" name="email"  placeholder="Email"></td>
        <td></td>
        <td><button style="margin:5px;" type="submit" class="btn btn-primary" name="but" value="search">Search</button></td>

    <table class="table table-hover">
        <thead>
        <tr>
            <th>Order number</th>
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

    </table>
    </form>

</div>