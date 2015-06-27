<?php
/**
 * Created by PhpStorm.
 * User: nmakarenko
 * Date: 26.06.15
 * Time: 18:58
 */
namespace CRM;
class DB {
    private $db;
    
	private function __construct(){}
	
    public function getConnect(){
        if (!$this->db) {
            $config = parse_ini_file('/var/www/dev.school-server/www/CRM/config/db.ini');
            $this->db = new \PDO ("mysql:host={$config['host']}; dbname={$config['db_name']}", $config['user'], $config['password']);
        }
        return $this->db;
    }
}
