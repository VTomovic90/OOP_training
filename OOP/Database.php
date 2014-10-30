<?php
/**
 *
 * @author Actiontrip1
 * @since 30.10.2014.
 * @example
 * $db = new Database();
 * $allRows = $db->selectAll("SELECT * FROM $table");
 *
 */

class Database {


    /**
     * Object that sets connection to database
     * @var Connection $connection
     * @access private
     */
    private $connection = null;


    /**
     *
     * @var Array $config
     * @see config.php
     * @access private
     */
    private $config = null;


    /**
     * Variables value changes only after insert method is called
     * @var Int $lastId
     * @see $this->insert();
     * @access private
     */
    private $lastId = null;


    /**
     * This variable shows us message if error that is not sql happenned
     * @var String $errorMsg
     * @see $this->getLastError
     * @access private
     */
    private $errorMsg = null;



    /**
     * Constructor creates database connection
     * @param Array $config - array('host'=>'', 'username'=>'', 'pass'=>'')
     */
    public function __construct($config){

        $this->config = $config;
        $this->connect();
    }


    /**
     * @see $this->connection;
     */
    private function connect(){

        $this->connection = mysqli_connect($this->config['host'],$this->config['user'],$this->config['password'],$this->config['db']);
        if(!$this->connection){
            die('Could not connect: ' . mysqli_error($this->connection));
        }
    }


    /**
     * Does sql query on sql expresion
     * @param String $sql - sql expresion
     */
    public function query($sql){

        return mysqli_query($this->connection, $sql);
    }


    /**
     * This method takes sql expresion, does "select all" query and returns array
     * @param String $sql
     * @return Array $niz
     */
    public function selectAll($sql){

        $resource = $this->query($sql);
        $niz = array();
        while($row =  mysqli_fetch_assoc($resource)){

            $niz[] = $row;
        }
        mysqli_free_result($resource);
        return $niz;
    }


    /**
     * Selects first row from table
     * @param String $sql
     * @return mysql row
     */
    public function selectFirst($sql){

        $rezult = $this->selectAll($sql);
        return $rezult[0];
    }


    /**
     * Counts number of rows in table
     * @param String $table
     * @return sql query
     * @see $this->query()
     */
    public function count($table){

        $sql = "SELECT COUNT(*)FROM $table";

        $row = mysqli_fetch_array($this->query($sql));
        $rezult = $row[0];
        return $rezult;
    }


    /**
     * This method inserts data from Array into table
     * @param Array $data
     * @param String $table
     * @return boolean		-if true Insert id done, if falce foes to $this->getLastError
     */
    public function insert($data,$table){
        if(!is_array($data)){
            //sets error
            $this->errorMsg = 'First argument need to be typeof array.';
            return false;
        }

        if(!is_string($table)){
            //sets error
            $this->errorMsg = 'Second argument need to be typeof string.';
            return false;
        }

        if(empty($data)){
            //sets error
            $this->errorMsg = 'Bad input data.';
            return false;
        }

        if(count(array_keys($data)) != count(array_values($data))){
            //sets error
            $this->errorMsg = 'Number of fields in table must be equal as number of values for those fields.';
            return false;
        }


        $data = $this->sanitize($data);

        /*
         * sets Array values to corespond to mysql syntax
         */
        foreach ($data as $key=>$value){
            $value = "'".$value."'";
            $data[$key] = $value;
        }

        $date = array("created"=>'NOW()', "modified"=>'NOW()');

        $data = array_merge($data,$date);

        $sql = "INSERT INTO ".$table."(".implode(array_keys($data),",").") VALUES (".implode(array_values($data),",").")";

        $result = $this->query($sql);
        if($result) { //true,false or resource id
            $this->lastId = mysqli_insert_id($this->connection);
        }
        return $result;
    }


    /**
     * This method sets 1 value to 1 column in table
     * @param String $table
     * @param String $column
     * @param Mixed $value
     * @param Int $id
     * @return boolean - if true Insert id done, if falce foes to $this->getLastError
     */
    //@todo : da li u nizu moze da mi bude samo jedan key->value par ili vise? ----> uradio sam za jedan
    public function insertOneVal($table,$data,$id){

        if(!is_string($table)){
            $this->errorMsg = 'First parameter must be typeof string.';
            return false;
        }

        if(!is_array($data)){
        	$this->errorMsg = 'Second parameters must be typeof array.';
        	return false;
        }
        
        if(empty($data)){
        	$this->errorMsg = 'Array must not be empty.';
        	return false;
        }
        
        if(count($data)>1){
        	$this->errorMsg = 'Only one element alowed in array.';
        	return false;
        }

        if(!is_int($id)){
            $this->errorMsg = 'Fourth parameter must be typeof int.';
            return false;
        }

        $data = $this->sanitize($data);
        
        $sql = "UPDATE ".$table." SET ".array_keys($data)[0]." = "."'".array_values($data)[0]."'"." WHERE id=".$id;

        return $this->query($sql);
    }


    /**
     * This method updates table row whit selected $id
     * @param String $table
     * @param Array $data	- associative array : key = (column name) , value = (variable that goes into that column)
     * @param Int $id
     * @return boolean		-if true Insert id done, if falce foes to $this->getLastError
     */
    public function update($table, $data, $id){

        if(!is_string($table)){
            //sets error
            $this->errorMsg = 'First argument need to be typeof string.';
            return false;
        }

        if(!is_array($data)){
            //sets error
            $this->errorMsg = 'Second argument need to be typeof array.';
            return false;
        }

        if(empty($data)){
            //sets error
            $this->errorMsg = 'Bad input data.';
            return false;
        }

        if(!is_int($id)){
            //sets error
            $this->errorMsg = 'Third argument must be typeof int.';
            return false;
        }

        if(count(array_keys($data)) != count(array_values($data))){
            //sets error
            $this->errorMsg = 'Number of fields in table must be equal as number of values for those fields.';
            return false;
        }

        $data = $this->sanitize($data);

        /*
         * sets Array values to corespond to mysql syntax
        */
        foreach ($data as $key => $value){
            $value = "'$value'";
            $data[$key] = "$key = $value";
        }

        $date = "modified = NOW()";
        $final = implode($data,",");
        $sql = "UPDATE ".$table." SET ".$final.",".$date." WHERE id = ".$id;

        return $this->query($sql);
    }


    /**
     * This method sanitizes every value from Array
     * @param Array $data
     * @return Array $data
     */
    public function sanitize($data){

        foreach($data as $key => $value){
            $data [$key] = mysqli_real_escape_string($this->connection, stripslashes($value));
        }
        return $data;
    }

    /**
     * Takes table name and id number and deletes from table row that coresponds to given id
     * @param unknown $table
     * @param unknown $id
     * @return sql query
     * @see $this->query()
     */
    public function delete($table, $id){
        $sql = "DELETE FROM $table WHERE id=".$id;
        $rezult = $this->query($sql);
        return $rezult;
    }

    /**
     * After insert method is called it saves id value, this method returns that values
     * @return number
     * @see $this->insert()
     */
    public function getLastInsertedId(){
        if ($this->lastId!= null){
            return $this->lastId;
        }else {
            return 0;
        }
    }


    /**
     * If error happened this method will return it
     * @return string $errorMsg
     */
    public function getLastError(){

        $error = ($this->errorMsg!=null) ? $this->errorMsg : 'Mysql error:'.mysqli_error($this->connection);
        return '<b>Error: </b>'.$error;
    }


    /**
     * closes connection with database
     */
    public function closeConnection(){

        return mysqli_close($this->connection);
    }

}


