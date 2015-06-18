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

?>
    <div class="col-md-3"></div>
    <div class="border-form col-md-6">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>User email</th>
                    <th>Product</th>
                    <th>Sum</th>
                    <th>Final sum</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>
            <?php foreach($cancelRequestList as $request):?>
                <tbody>
                    <tr class="success">
                        <td><?=$request['email_us']?></td>
                        <td><?=$request['product']?></td>
                        <td><?=$request['sum']?></td>
                        <td><input   type="text" name="finalSum" value="<?=$request['sum']?>"></td>
                        <td><?=$request['date']?></td>
                        <td><a href="sendCancelRequest.php?id=<?=$request['id']?>">Send</a> </td>
                    </tr>
                </tbody>
            <?php endforeach ?>
        </table>
    </div>
    <div class="col-md-3"></div>

<?php include_once 'footer.html'; ?>
