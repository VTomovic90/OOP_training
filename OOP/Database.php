<?php
//Svaka klasa ide u poseban fajl
//Sve sto je vezano za klasu koju pravis treba biti u toj klasi (izuztetak su konfig varijable)

//$this->NAME;          -- Property
//$this->NAME();        -- Method

class Database {

    private $connection = null;

    private $config = null;

    private $lastId = null;


    public function __construct($config){

        $this->config = $config;
        $this->connect();
    }

    private function connect(){

        $this->connection = mysqli_connect($this->config['host'],$this->config['user'],$this->config['password'],$this->config['db']);
        if(!$this->connection){
            die('Could not connect: ' . mysqli_error($this->connection));
        }
    }
    /*
     * Returns FALSE on failure. For successful SELECT, SHOW, DESCRIBE or EXPLAIN queries mysqli_query() will return a mysqli_result object.
     * For other successful queries mysqli_query() will return TRUE.
     */
    public function query($sql){

        return mysqli_query($this->connection, $sql);

    }

    //OVO RADI
    public function selectAll($sql){

        $resource = $this->query($sql);
        $niz = array();
        while($row =  mysqli_fetch_assoc($resource)){

            $niz[] = $row;
        }
        mysqli_free_result($resource);
        return $niz;
    }

    //OVO RADI
    public function selectFirst($sql){


//        $this->query($sql);
//        $row = mysqli_fetch_array($sql);
//        foreach($row as $r){
//            $rezult[] = $r;
//        }

        $rezult = $this->selectAll($sql);
        return $rezult[0];
    }

    //OVO RADI
    public function count($table){

        $sql = "SELECT COUNT(*)FROM $table";

        $row = mysqli_fetch_array($this->query($sql));
        $rezult = $row[0];
        return $rezult;

    }

    /**
     * @param Sring $sql Mysql query string
     * @return bool|mysqli_result
     */
    public function insert($rows,$values,$table){
        //Execute insert query

        foreach($rows as $row){
            $row = stripslashes($row);
            $row = mysqli_real_escape_string($this->connection,$row);

            $newRows [] = $row.",";
        }
        $rw = rtrim(implode($newRows),",");

        foreach($values as $value){
            $value = stripslashes($value);
            $value = mysqli_real_escape_string($this->connection,$value);

            $newVal [] = "'".$value."',";
        }

        $val = implode($newVal)."NOW(),NOW()";
        $sql = "INSERT INTO ".$table."(".$rw.") VALUES (".$val.")";

        print_r($sql); die();
        $result = $this->query($sql);
        if($result) { //true,false or resource id
            $this->lastId = mysqli_insert_id($this->connection);
        return $result;
        }else{
            return $this->getLastError();
        }
    }

    public function update($sql){
        if($this->query($sql)){
            return true;
        }else {
            return $this->getLastError();
        }
    }

    public function delete($table, $id){
        $sql = "DELETE FROM $table WHERE id=".$id;
        if($this->query($sql)){
            return true;
        }else {
            return $this->getLastError();
        }
    }


    public function getLastInsertedId(){

        if ($this->lastId!= NULL){
            return $this->lastId;
        }else {
            return 0;
        }
    }

    public function getLastError(){
        return mysqli_error($this->connection);
    }

}


