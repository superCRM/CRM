<?php
/**
 * Created by PhpStorm.
 * User: pashka
 * Date: 24.06.15
 * Time: 0:23
 */

include_once 'header.html';

var_dump($_POST);
session_start();

if(isset($_SESSION['keys'])){
    $keys = $_SESSION['keys'];
} else {
    $keys = array();
}

if(isset($_POST['key_id']) && isset($_POST['add']) && ($_POST['key_id'] != "")){
    $keys[$_POST['key_id']] = 0;
}

if(isset($_POST['email'])){
    $_SESSION['email'] = $_POST['email'];
}

if(isset($_POST['delete'])){
       unset($keys[$_POST['delete']]);
}

if(isset($_POST['cancelKeys'])){
    $cancelKeys = $_POST['cancelKeys'];
    foreach($cancelKeys as $key=>$value){
        $keys[$value] = 1;
    }
}

$_SESSION['keys'] = $keys;
var_dump($keys);
?>
<div class="col-md-3"></div>
<div class="col-md-6">
    <form method="post">

    <?php
        if(!isset($_SESSION['email'])) {
    ?>
    <!--search by email--->
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-offset-0 col-md-5">
                    <input type="email" class="form-control" placeholder="Email" name="email"/>
                </div>
                <div class="col-md-offset-4 col-md-2">
                    <button type="submit" name="add" class="btn btn-primary">
                        Enter <span class=""></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
        }
        else {
            ?>

            <div class="row">
                <div><h3>Refund for user <?= $_SESSION['email'] ?></h3></div>
            </div>
            <!---add end key_id--->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-offset-0 col-md-3">
                            <input type="text" class="form-control" placeholder="key_id" name="key_id"/>
                        </div>
                        <div class="col-md-offset-5 col-md-2">
                            <button type="submit" name="add" class="btn btn-primary">
                                Add <span class=""></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            if (!empty($keys)) {
                ?>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="col-md-3">Deactivate?</th>
                                <th>Key id</th>
                            </tr>
                            </thead>
                        </table>
                        <?php foreach($keys as $key=>$value) : ?>
                        <div class="row">
                            <div class="col-md-6 checkbox">
                                <input class="col-md-5" id="<?= $key ?>" value="<?= $key ?>" name="cancelKeys[]"  type="checkbox"/>
                                <label class="col-md-2 col-md-offset-6" for="<?= $key ?>"><?= $key ?></label>
                            </div>
                            <div class="col-md-offset-2 col-md-2">
                                <button type="submit" class="btn btn-primary" name="delete" value="<?= $key ?>">
                                    Del <span class=""></span>
                                </button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!--sent and percent---->
                <div class="row">
                    <div class="col-md-offset-0 col-md-3">
                        <input type="text" class="form-control" placeholder="percent" name="percent"/>
                    </div>
                    <div class="col-md-offset-1 col-md-3">
                        <button type="submit" class="btn btn-primary">
                            Send <span class=""></span>
                        </button>
                    </div>
                </div>

            <?php
            }
        }
    ?>
    </form>
</div>

<div class="col-md-3"></div>

<?php

include_once 'footer.html';