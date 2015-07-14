<?php
/**
 * Created by PhpStorm.
 * User: unevmerzhuzkiy
 * Date: 7/13/15
 * Time: 7:10 PM
 */

namespace Plagins;


class CustomFlash extends \Phalcon\Flash\Session
{
    public function message($type, $message)
    {
        $message = '<a href="#" class="close" data-dismiss="alert">&times;</a><strong>!!!</strong>' . $message;
        parent::message($type, $message);
    }
}