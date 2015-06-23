<?php
include_once "library/db.php";
include_once "library/updateCancelRequest.php";
include_once "library/getRefundItem.php";
include_once "library/getKeyList.php";
include_once "library/getKeyStatus.php";
include_once "library/getPercent.php";
include_once "library/sendJsonData.php";

session_start();
$address = "http://10.55.33.38/billing_v1/get_test/test_get_refunds.php";

if(isset($_POST['id_refund']) && isset($_SESSION['id']) && isset($_POST['finalPercent']) && isset($_POST['keyToCancel'])){
    $cancelKeys = $_POST['keyToCancel'][$_POST['id_refund']];
    var_dump($cancelKeys);
    updateCancelRequest(getConnect(), $_POST['id_refund'], $_SESSION['id'], $_POST['finalPercent'], $cancelKeys);
    $keys = getKeyStatus(getConnect(), getKeyList(getConnect(), $_POST['id_refund'])); //70 id_refund
    $percent = getPercent(getConnect(), $_POST['id_refund']);
    $cancelRequest = array(
        'refund_id'=>$_POST['id_refund'],
        'keys'=>$keys,
        'percent'=>$percent
    );
    var_dump($jsonCancelRequest = json_encode($cancelRequest));
    sendData("refund",$jsonCancelRequest,$address);
}