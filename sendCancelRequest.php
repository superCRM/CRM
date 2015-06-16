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
include_once "library/sendJsonData.php";

$address = "http://10.55.33.21/billing_v1/test_get_refunds.php";
$cancelRequest = array();
if(isset($_GET['id'])){
    $cancelRequest = getRefundItem(getConnect(), $_GET['id']);

}
if(count($cancelRequest)>0)
{
    $jsonCancelRequest = json_encode($cancelRequest);
    sendData("cancelRequest",$jsonCancelRequest,$address);
    session_start();
    updateCancelRequest(getConnect(), $_GET['id'], $_SESSION['id'], $_GET['finalSum'],1);

    header("Location: cancelRequestList.php");
}

?>