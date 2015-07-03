<?php
/**
 * Created by PhpStorm.
 * User: pkoval
 * Date: 23.06.15
 * Time: 20:23
 */
function getConnect() {
    $config = parse_ini_file('/var/www/dev.school-server/www/dev/config/db.ini');
    $db = new PDO ("mysql:host={$config['host']}; dbname={$config['db_name']}", $config['user'], $config['password']);

    return $db;
}