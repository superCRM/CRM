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
    public $pack_object;

    public abstract function pack();

    public abstract function unpack($pack_object);

    public function insert()
    {
        $this->pack();
        $class = get_called_class();
        $string_query = 'insert into ' . $class::TABLE_NAME . ' set ';
        foreach($this->pack_object as $key=>$value)
        {
            $string_query.="`$key`=$value,";
        }
        $string_query = trim($string_query, ',');
        /*$db = DB::getConnect();
        $query = $db->prepare($string_query);
        return $query->execute();*/
    }

    public function update()
    {
        $this->pack();
        $class = get_called_class();
        $string_query = 'update ' . $class::TABLE_NAME . ' set ';
        foreach($this->pack_object as $key=>$value)
        {
            $string_query.="`$key`=$value,";
        }
        $string_query = trim($string_query, ',');
        $string_query .= "where id = " . $this->id;
        /*$db = DB::getConnect();
        $query = $db->prepare($string_query);
        return $query->execute();*/
    }

    public static function select($table, $conditional)
    {
        $result = array();
        $string_query = 'select * from ' . $table;
        if(count($conditional)>0)
            $string_query .= ' where';
        foreach($conditional as $key=>$value)
        {
            $string_query .= " `$key` = '$value' and";
        }
        $string_query = trim($string_query, 'and');
        /*$db->DB::getConnect();
        $query = $db->prepare($string_query);
        $query->execute();
        while($row=$query->fetch(PDO::FETCH_ASSOC))
        {
            $result[] = $row;
        }
        return $result;*/
    }
} 