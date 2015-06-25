<?php
/**
 * Created by PhpStorm.
 * User: pkoval
 * Date: 25.06.15
 * Time: 18:14
 */
include_once 'header.html';
include_once 'library/getRefundList.php';

$responses = getRefundList(getConnect(), array(2,3));
?>