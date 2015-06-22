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
    <div class="col-md-2"></div>
    <div class="border-form col-md-8">
        <form method = "post">
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
                    <form method = "post">
                    <tbody>
                        <tr class="success">
                            <td><?=$request['email_us']?></td>
                            <!--<td><input type="checkbox" name="formDoor[]" value="off" />Acorn Building<br /></td>-->
                            <td><?=$request['key_num']?></td>
                            <td>
                                <?php $i = 0;
                                foreach($keysList as $key):
                                    $i++;?>
                                    <input type="checkbox" name="keyToCancel[<?= $i ?>]" value="off" /><?=$key['key_id']?>  <?=$key['key_id']?>
                                <?php endforeach ?>
                            </td>
                            <td><?=$request['percent']?></td>
                            <td><input   type="text" name="finalPercent" value="<?=$request['final_percent']?>"></td>
                            <td><?=$request['data']?></td>
                            <td><a href="sendCancelRequest.php?id=<?=$request['id']?>&finalPercent=<?=$request['final_percent']?>">Send</a> </td>
                        </tr>
                    </tbody>
                    </form>
                <?php endforeach ?>
            </table>
        </form>
    </div>
    <div class="col-md-2"></div>

<?php
var_dump($_POST);
include_once 'footer.html'; ?>
