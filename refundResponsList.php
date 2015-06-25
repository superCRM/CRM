<?php
/**
 * Created by PhpStorm.
 * User: pkoval
 * Date: 25.06.15
 * Time: 18:14
 */
include_once 'header.html';
include_once 'navBar.html';
include_once 'library/getRefundList.php';
include_once 'library/getKeyList.php';

$responses = getRefundList(getConnect(), array(1,0));

if(isset($_POST['all'])){
    unset($_POST['email']);
}

if(isset($_POST['email'])&& ($_POST['email'] != '')){
    foreach($responses as $k=>$v){
        if($v['email_us'] != $_POST['email'])
            unset($responses[$k]);
    }
}

if(isset($_POST['del'])){
    unset($responses[$_POST['del']]);
}

?>

    <div class="col-md-3 col col-sm-3"></div>
    <div  style=" "class="col-md-6 col-sm-6">
        <form method="post">
            <?php
            include_once 'navBar.html';
            ?>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-offset-0 col-sm-5 col-md-5">
                                <input type="email" class="form-control" placeholder="Email" name="email"/>
                            </div>
                            <div class="col-md-offset-4 col-sm-offset-4 col-sm-2 col-md-2">
                                <button type="submit" name="add" class="btn btn-primary">
                                    Search <span class=""></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>id_refund</th>
                                <th>us_email</th>
                                <th>keys</th>
                                <th>data</th>
                                <th>    </th>
                            </tr>
                            </thead>
                            <tbody>
                        <?php foreach($responses as $key=>$value) :
                                if($value['status'] == 1) {
                                    ?><tr class="success"><?php
                                } else {
                                    ?><tr class="danger"><?php
                                } ?>
                                <td><?=$value['id']?></td>
                                <td><?=$value['email_us']?></td>
                                <td>
                                    <?php foreach(getKeyList(getConnect(),$value['id']) as $k=>$v): ?>
                                            <span><?=$v['key_id']?></span><br>
                                    <?php endforeach ?>
                                </td>
                                <td><?=$value['data']?></td>
                                <td>
                                    <button type="submit" name="del" value="<?= $key ?>" class="btn btn-primary">
                                        del <span class=""></span>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if(isset($_POST['email']) && ($_POST['email'] != '')){ ?>
                    <div class="col-md-4 col-sm-4">
                        <button type="submit" name="all" class="btn btn-primary">
                            All responses<span class=""></span>
                        </button>
                    </div>
                <?php } ?>
        </form>
    </div>
    <div class="col-md-3 col-sm-3"></div>
    <script>
        document.getElementById("refund").classList.add("active");
    </script>
<?php

include_once 'footer.html';
