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
/*updateCancelRequest(getConnect(), $_GET['id'], $_SESSION['id'], $_GET['finalPercent'], $_GET['keyToCancel']);
*/
$address = "http://10.55.33.38/billing_v1/get_test/test_get_refunds.php";


/*$cancelRequest = array();*/
var_dump($_GET);
var_dump($_SESSION);
if(isset($_GET['id']) && isset($_SESSION['id']) && isset($_GET['finalPercent']) && isset($_GET['keyToCancel'])){

    updateCancelRequest(getConnect(), $_GET['id'], $_SESSION['id'], $_GET['finalPercent'], $_GET['keyToCancel']);

    $cancelRequest = getRefundInfo(getConnect(), $_GET['id']);
    $keys = getKeyStatus(getConnect(), getKeyList(getConnect(), 70));
    $percent = getPercent(getConnect(), 70);

    $cancelRequest = array(
        'refund_id'=>10,
        'keys'=>$keys,
        'percent'=>$percent
    );

    var_dump($jsonCancelRequest = json_encode($cancelRequest));
    echo(sendData("refund",$jsonCancelRequest,$address));
}
/*if(count($cancelRequest)>0)
{
    $jsonCancelRequest = json_encode($cancelRequest);
    sendData("cancelRequest",$jsonCancelRequest,$address);
    session_start();
    updateCancelRequest(getConnect(), $_GET['id'], $_SESSION['id'], $_GET['finalPercent'],1);

    header("Location: cancelRequestList.php");
}*/
