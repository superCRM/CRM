<?php
/**
 * Created by PhpStorm.
 * User: unevmerzhuzkiy
 * Date: 6/24/15
 * Time: 6:49 PM
 */

include_once 'library/changeRefundStatus.php';
include_once 'library/db.php';
include_once 'library/cancelKey.php';

if(isset($_POST['refunds']))
{
    $jsonResponse = $_POST['refunds'];
    $response = json_decode($jsonResponse,true);
    if(isset($response['id_refund'])){
        $id_refund = $response['id_refund'];
        if(isset($response['success']))
        {
            if($response['success']===true)
            {
                changeRefundStatus(getConnect(),$id_refund);
                if(isset($response['id_keys']))
                {
                    foreach($response['id_keys'] as $key)
                    {
                        cancelKey(getConnect(),$key);
                    }
                }
            }
            else
                if(isset($response['status']))
                {
                    $id_key = null;
                    if(isset($response['id_key']))
                    {
                        $id_key = $response['id_key'];
                    }
                    switch($response['status'])
                    {
                        case 'exists':
                            cancelKey(getConnect(),$id_key);
                            break;
                        case 'canceled':
                            cancelKey(getConnect(),$id_key);
                            break;
                    }

                    changeRefundStatus(getConnect(),$id_refund,0);
                }
                else
                {
                    changeRefundStatus(getConnect(),$id_refund);
                }
        }
    }
}