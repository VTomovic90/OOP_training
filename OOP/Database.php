<?php
//Svaka klasa ide u poseban fajl
//Sve sto je vezano za klasu koju pravis treba biti u toj klasi (izuztetak su konfig varijable)

//$this->NAME;          -- Property
//$this->NAME();        -- Method

class Database {

    private $connection = null;

    private $config = null;


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

    public function query($sql){

        return mysqli_query($this->connection, $sql);

    }

    //OVO RADI
    public function SelectFirst($table, $sql){


        $this->query($sql);
        $row = mysqli_fetch_array($q);
        foreach($row as $r){
            $rezult[] = $r;
        }
        return $rezult;
    }

    //OVO RADI
    public function Count($table){

        $sql = "SELECT COUNT(*)FROM $table";


        $this->query($sql);
        $row = mysqli_fetch_array($q);
        $rezult = $row[0];
        return $rezult;

    }


    //OVO RADI
    public function getLastInsertedId($table,$con){

        $sql = "SELECT * FROM $table ORDER BY id DESC LIMIT 1";

        //print_r($sql);
        $q = mysqli_query($con, $sql);
        $rezult = mysqli_fetch_array($q);
        return $rezult[0];
    }
}


