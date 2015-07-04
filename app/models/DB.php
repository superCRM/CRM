<?php
/**
 * Created by PhpStorm.
 * User: nmakarenko
 * Date: 26.06.15
 * Time: 18:58
 */
namespace CRM;
class DB {
    private static $db;
    
	private function __construct(){}
	
    public static function getConnect(){
        if (!self::$db) {
            $config = parse_ini_file('./../config/db.ini');
            self::$db = new \PDO ("mysql:host={$config['host']}; dbname={$config['db_name']}", $config['user']);//, $config['password']);
        }
        return self::$db;
    }
}
