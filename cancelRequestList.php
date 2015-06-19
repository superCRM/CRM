<?php
/**
 * Created by PhpStorm.
 * User: unevmerzhuzkiy
 * Date: 6/11/15
 * Time: 5:27 PM
 */
include_once 'header.html';
include_once 'library/db.php';
include_once 'library/getKeyList.php';
include_once 'library/getRefundList.php';
include_once ('library/createRefundItem.php');

$cancelRequestList = getRefundList(getConnect(), 0);
$keysList = array();

?>
    <div class="col-md-3"></div>
    <div class="border-form col-md-6">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>User email</th>
                    <th>Num of keys</th>
                    <th>Keys id</th>
                    <th>Percent</th>
                    <th>Final percent</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>
            <?php foreach($cancelRequestList as $request):
                $keysList = getKeyList(getConnect(), $request['id']); ?>
                <tbody>
                    <tr class="success">
                        <td><?=$request['email_us']?></td>
                        <td><?=$request['key_num']?></td>
                        <td>
                            <?php foreach($keysList as $key):?>
                            <input type="checkbox" name="keyToCancel[]" value="<?=$key['key_id']?>" />  <?=$key['key_id']?>
                            <?php endforeach ?>
                        </td>
                        <td><?=$request['percent']?></td>
                        <td><input   type="text" name="finalPercent" value="<?=$request['final_percent']?>"></td>
                        <td><?=$request['data']?></td>
                        <td><a href="sendCancelRequest.php?id=<?=$request['id']?>">Send</a> </td>
                    </tr>
                </tbody>
            <?php endforeach ?>
        </table>
    </div>
    <div class="col-md-3"></div>

<?php include_once 'footer.html'; ?>
