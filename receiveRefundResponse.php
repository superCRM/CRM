<?php
/**
 * Created by PhpStorm.
 * User: unevmerzhuzkiy
 * Date: 6/24/15
 * Time: 6:49 PM
 */

include_once 'library/changeRefundStatus.php';
include_once 'library/db.php';
include_once 'library/changeKeyStatus.php';
include_once 'library/getPercent.php';

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
                changeRefundStatus(getConnect(),$id_refund,2);
                if(isset($response['id_keys']))
                {
                    $keys = $response['id_keys'];
                    decrementKeysPercent($id_refund,$keys);
                }

            }
            else
            {
                changeRefundStatus(getConnect(),$id_refund,3);
                $keys = getKeyList(getConnect(),$id_refund);

                decrementKeysPercent($id_refund,$keys);
                /*if(isset($response['id_keys']))
                {
                    foreach($response['id_keys'] as $key=>$value)
                    {
                        switch($value)
                        {
                            case 'notexists':
                                changeKeyStatus(getConnect(),$id_key,2);
                                break;
                            case 'canceled':
                                changeKeyStatus(getConnect(),$id_key,1);
                                break;
                        }
                    }
                }*/
            }
        }
    }
}

function decrementKeysPercent($refund_id, $keys)
{
    $percent = getPercent(getConnect(),$refund_id);
    foreach($keys as $key)
    {
        decrementKeyPercent(getConnect(),$key,$percent);
    }
}