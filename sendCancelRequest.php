<?php
/**
 * Created by PhpStorm.
 * User: unevmerzhuzkiy
 * Date: 6/11/15
 * Time: 8:05 PM
 */
include_once "library/db.php";
include_once "library/updateCancelRequest.php";
include_once "library/getRefundItem.php";
include_once "library/getKeyList.php";
include_once "library/getKeyStatus.php";
include_once "library/getPercent.php";
include_once "library/sendJsonData.php";

session_start();

$address = "http://10.55.33.38/billing_v1/get_test/test_get_refunds.php";
/*$cancelRequest = array();
if(isset($_GET['id'])){
    $cancelRequest = getRefundItem(getConnect(), $_GET['id']);

$address = "http://10.55.33.38/billing_v1/get_test/test_get_refunds.php";

/*$cancelRequest = array();*/
var_dump($_POST);
var_dump($_GET);
var_dump($_SESSION);

if(isset($_POST['id_refund']) && isset($_SESSION['id']) && isset($_POST['finalPercent']) && isset($_POST['keyToCancel'])){

    $cancelKeys = $_POST['keyToCancel'][$_POST['id_refund']];
    var_dump($cancelKeys);
    updateCancelRequest(getConnect(), $_POST['id_refund'], $_SESSION['id'], $_POST['finalPercent'], $cancelKeys);

    //$cancelRequest = getRefundInfo(getConnect(), $_POST['id_refund']);
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
/*if(count($cancelRequest)>0)
{
    $jsonCancelRequest = json_encode($cancelRequest);
    sendData("cancelRequest",$jsonCancelRequest,$address);
    session_start();
    updateCancelRequest(getConnect(), $_GET['id'], $_SESSION['id'], $_GET['finalPercent'],1);

    header("Location: cancelRequestList.php");

}*/

/*$keys = array(13,15,7,20);

$cancel = array(
    'email'=>'ty@gmail.com',
    'amount'=>30,
    'key_id'=>$keys
);
$address = "http://10.55.33.27/dev/addRefund.php";
$jsonOrder = json_encode($cancel);
echo sendData("cancel_info",$jsonOrder,$address);*/


