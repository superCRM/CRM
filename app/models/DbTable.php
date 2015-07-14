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
    protected $packObject;

    public abstract function pack();

    public abstract function unpack($packObject);

    public function insert($table, $conditional=null)
    {
        $this->pack();
       // $class = get_called_class();
        $stringQuery = "insert into `" . $table . "` set ";

        if($conditional == null)
            foreach($this->packObject as $key=>$value)
            {
                if($key == "data") $stringQuery.="$key=now(), ";
                else $stringQuery.="$key='$value', ";

            }
        else
            foreach($conditional as $key=>$value)
            {
                $stringQuery.="$key='$value', ";
            }
        $stringQuery = trim($stringQuery, ', ');
        $db = DB::getConnect();
        $query = $db->prepare($stringQuery);
        $query->execute();
        return $db->lastInsertId();
    }

    public function update($conditional,$connector='and')
    {
        $this->pack();
        $class = get_called_class();
        $stringQuery = 'update `' . $class::TABLE_NAME . '` set ';
        foreach($this->packObject as $key=>$value)
        {
            if($value != '') $stringQuery.="$key='$value', ";
        }
        $stringQuery = trim($stringQuery, ', ');
        if(count($conditional)>0)
            $stringQuery .= ' where';

        foreach($conditional as $key=>$value)
        {
            //var_dump($key);
            if($value!=null){
                $stringQuery .= " $key = '$value' $connector";
            }
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
    public static function select($conditional,$connector='and', $additionalTable=null, $order = null)
    {
        $class = get_called_class();
        $result = array();

        $rows = self::selectRows($class::TABLE_NAME,$conditional,$connector,$additionalTable, $order);
        foreach($rows as $row)
        {
            $item = new $class();
            $item->unpack($row);
            $result[] = $item;
        }
        return $result;
    }

    public static function selectRows($table,$conditional,$connector, $additionalTable, $order)
    {

        $stringQuery = "select `" . $table . "`.* from `" . $table. '`';
        if($additionalTable!=null)
            $stringQuery .=', `' . $additionalTable . '`';
        if(count($conditional)>0)
            $stringQuery .= ' where';

        foreach($conditional as $key=>$value)
        {
            if($value===null)
                $stringQuery .= " $key $connector";
            else
            {
                $stringQuery .= " $key = '$value' " . " $connector";
            }

        }

        $stringQuery = trim($stringQuery, $connector);
        if ($order != null) $stringQuery .= $order;
        $db=DB::getConnect();
        $query = $db->prepare($stringQuery);
        $query->execute();
        $result = array();
        while($row=$query->fetch(\PDO::FETCH_ASSOC))
        {
            $result[] = $row;
        }
        return $result;
    }



    public static function getNumberOfRows(){
        $class = get_called_class();

        $stringQuery = "SELECT COUNT(*) as count FROM ".$class::TABLE_NAME;

        $db = DB::getConnect();
        $query = $db->prepare($stringQuery);

        if($query->execute()){
            return $query->fetch(\PDO::FETCH_ASSOC)['count'];
        }

        return false;
    }
} 