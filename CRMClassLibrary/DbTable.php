<?php
/**
 * Created by PhpStorm.
 * User: unevmerzhuzkiy
 * Date: 6/26/15
 * Time: 6:49 PM
 */

namespace CRM;


abstract class DbTable {

    const TABLE_NAME='undefined';
    public $id;
    public $table;
    public $packObject;

    public abstract function pack();

    public abstract function unpack($packObject);

    public function insert()
    {
        $this->pack();
        $class = get_called_class();
        $stringQuery = 'insert into ' . $class::TABLE_NAME . ' set ';
        foreach($this->packObject as $key=>$value)
        {
            $stringQuery.="`$key`=$value,";
        }
        $stringQuery = trim($stringQuery, ',');
        /*$db = DB::getConnect();
        $query = $db->prepare($stringQuery);
        return $query->execute();*/
    }

    public function update()
    {
        $this->pack();
        $class = get_called_class();
        $stringQuery = 'update ' . $class::TABLE_NAME . ' set ';
        foreach($this->packObject as $key=>$value)
        {
            $stringQuery.="`$key`=$value,";
        }
        $stringQuery = trim($stringQuery, ',');
        $stringQuery .= "where id = " . $this->id;
        /*$db = DB::getConnect();
        $query = $db->prepare($stringQuery);
        return $query->execute();*/
    }

    public static function select($table, $conditional)
    {
        $result = array();
        $stringQuery = 'select * from ' . $table;
        if(count($conditional)>0)
            $stringQuery .= ' where';
        foreach($conditional as $key=>$value)
        {
            $stringQuery .= " `$key` = '$value' and";
        }
        $stringQuery = trim($stringQuery, 'and');
        /*$db->DB::getConnect();
        $query = $db->prepare($stringQuery);
        $query->execute();
        while($row=$query->fetch(PDO::FETCH_ASSOC))
        {
            $result[] = $row;
        }
        return $result;*/
    }
} 