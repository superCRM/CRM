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
    public $packObject;

    public abstract function pack();

    public abstract function unpack($packObject);

    public function insert($table, $conditional=null)
    {
        $this->pack();
       // $class = get_called_class();
        $stringQuery = 'insert into ' . $table . ' set ';

        if($conditional == null)
            foreach($this->packObject as $key=>$value)
            {
                $stringQuery.="$key='$value', ";
            }
        else
            foreach($conditional as $key=>$value)
            {
                $stringQuery.="$key='$value', ";
            }
        $stringQuery = trim($stringQuery, ',');
        $db = DB::getConnect();
        $query = $db->prepare($stringQuery);
        return $db->lastInsertId();
    }

    public function update($conditional,$connector='and')
    {
        $this->pack();
        $class = get_called_class();
        $stringQuery = 'update ' . $class::TABLE_NAME . ' set ';
        foreach($this->packObject as $key=>$value)
        {
            $stringQuery.="$key='$value', ";
        }
        $stringQuery = trim($stringQuery, ',');
        if(count($conditional)>0)
            $stringQuery .= ' where';

        foreach($conditional as $key=>$value)
        {
            var_dump($key);
            if($value!=null)
                $stringQuery .= " $key = '$value' $connector";
            else
            {
                $stringQuery .= " $key $connector";
            }

        }

        $stringQuery = trim($stringQuery, $connector);
        $db = DB::getConnect();
        $query = $db->prepare($stringQuery);
        return $query->execute();
    }


    /**
     * @param $conditional
     * @return array
     */
    public static function select($conditional,$connector='and', $additionalTable=null)
    {
        $class = get_called_class();
        $result = array();
        $stringQuery = "select " . $class::TABLE_NAME . ".* from " . $class::TABLE_NAME;
        if($additionalTable!=null)
            $stringQuery .=', ' . $additionalTable;
        if(count($conditional)>0)
            $stringQuery .= ' where';



        foreach($conditional as $key=>$value)
        {
            var_dump($key);
            if($value!=null)
                $stringQuery .= " $key = '$value' $connector";
            else
            {
                $stringQuery .= " $key $connector";
            }

        }

        $stringQuery = trim($stringQuery, $connector);
        $db=DB::getConnect();
        $query = $db->prepare($stringQuery);
        echo($stringQuery);
        $query->execute();
        while($row=$query->fetch(\PDO::FETCH_ASSOC))
        {
            $item = new $class();
            $item->unpack($row);
            $result[] = $item;
        }
        return $result;
    }
} 