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


$cancelRequestList = getRefundList(getConnect(), array(0));
$keysList = array();

if ($_POST) {
    echo '<pre>';
    echo htmlspecialchars(print_r($_POST, true));
    echo '</pre>';
}

?>
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <?php include_once 'navBar.html';?>
        <form action = "sendCancelRequest.php" method = "post">
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
                    $keysList = getAliveKeyList(getConnect(), $request['id']); ?>
                    <tbody>
                        <tr class="success">
                            <td><?=$request['email_us']?></td>
                            <td><?=$request['key_num']?></td>
                            <td>
                                <?php $i = 0;
                                foreach($keysList as $key):
                                    $i++;?>
                                    <input type="checkbox" name="keyToCancel[<?= $request['id'] ?>][<?= $i ?>]" value="<?=$key['key_id']?>" />  <?=$key['key_id']?><br>
                                <?php endforeach ?>
                            </td>
                            <td><?=$request['percent']?></td>
                            <td><input   type="text" name="finalPercent" value="<?=$request['final_percent']?>"></td>
                            <td><?=$request['data']?></td>
                            <td><button type="submit" name="id_refund" value="<?= $request['id'] ?>">Send</button></td>
                        </tr>
                    </tbody>
                <?php endforeach ?>
            </table>
        </form>
    </div>
    <div class="col-md-2"></div>
<script>
    document.getElementById("main").classList.add("active");
</script>
<?php
include_once 'footer.html';?>
