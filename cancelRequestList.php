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

$cancelRequestList = getRefundList(getConnect(),0);
?>

    <div class="border-form">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Order number</th>
                    <th>User email</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>
            <?php foreach($cancelRequestList as $request):?>
                <tbody>
                    <tr class="success">
                        <td><?=$request['order_num']?></td>
                        <td><?=$request['email_us']?></td>
                        <td><?=$request['date']?></td>
                        <td><a href="cancelRequestItem.php?id=<?=$request['id']?>">Details</a> </td>
                    </tr>
                </tbody>
            <?php endforeach ?>
        </table>
    </div>
