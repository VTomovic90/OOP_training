<?php

require_once("Paginate.php");

class Tables extends Paginate{
	
	/**
	 * If error happens, this property whill get value of that error
	 * @see $this->error()
	 * @var unknown
	 */
	private $errorMsg = null;
	
	
	/**
	 * constructor recieves Database class object so connection in Database class could be made,
	 * and $conf array 
	 * @param Object $db
	 * @param unknown $conf
	 */
	public function __construct($db,$conf){
	
		$this->className = $conf['table'];
		parent::__construct($db, $conf);
	}

	/**
	 *Returns all rows that corespond to Limited query in pagination
	 */
	public function getAllPage($selection = "*"){

		$sql = "SELECT ".$this->makeSelection($selection)." FROM ".$this->className.$this->limitQuery();
		return $this->dbHandler->selectAll($sql);
	}
	
	
	/**
	 * Returns row with specified id
	 * @param Int $id
	 */
	public function getRowById($id, $selection = '*'){
		
		if(!is_numeric($id)){
			$this->errorMsg = "Parameter id must be typeof int.";
			return false;
		}

		
		$sql = "SELECT ".$this->makeSelection($selection)." FROM ".$this->className." WHERE id=".$id;
		
		if($this->dbHandler->selectAll($sql) == null){
			$this->errorMsg = "Row with this id doesnt exist.";
			return false;
		}
		return $this->dbHandler->selectAll($sql);
	}
	
	/**
	 * Returns complete table
	 * @param $selection
	 */
	public function getAll($selection = "*"){
		
		$sql = "SELECT ".$this->makeSelection($selection)." FROM ".$this->className;
		return $this->dbHandler->selectAll($sql);
	}
	
	
	/**
	 * Gets id and returns next and previous row to that id
	 * @param Int $id
	 * @param $selection
	 * @throws Exception
	 */
	public function getNextPrevious($id, $selection = "*") {
		
		if(!is_numeric($id)){
			$this->errorMsg = "Id parameter myst be typeof int";
			return false;
		}
		
		//gets row of previous id in table
		$min = "SELECT ".$this->makeSelection($selection)." FROM ".$this->className." WHERE id<".$id." ORDER BY id DESC";
		$s = $this->dbHandler->selectAll($min);
		if(empty($s)){
			$rezult['previous']['title']  = "You are curently on first row!";
		}else{
			$rezult['previous'] = $s[0];
		}

		//gets row of next id in table
		$max = "SELECT ".$this->makeSelection($selection)." FROM ".$this->className." WHERE id>".$id." ORDER BY id ASC";
		$s = $this->dbHandler->selectAll($max);
		if(empty($s)){
			$rezult['next']['title'] = "You are curently on last row!";
		}else{
			$rezult['next'] = $s[0];
		}

		
		return $rezult;
	}
	
	/**
	 * Metgod gets id and checks if row with that id exist
	 * @param Int $id
	 * @return boolean
	 */
	public function exists($id) {
		
		if($this->getRowById($id) == null){
			return false;
		}
		return true;
	}
	
	
	/**
	 * Returns $limit random rows from list
	 * @param string $selection
	 * @param int $limit - number of rows to be selected from table
	 */
	public function getRandomList($limit = 10,$selection = "*"){
		
		if(!is_numeric($limit)){
			$this->errorMsg = "Limit must be typeof Int.";
			return false;
		}

		$sql = "SELECT ".$this->makeSelection($selection)." FROM ".$this->className." ORDER BY RAND() LIMIT ".$limit;
		
		return $this->dbHandler->selectAll($sql);
	}
	
	/**
	 * Parameter $selection can be string or array, 
	 * if it is array this method makes it string so it can be included in mysql statement
	 * @param unknown $selection
	 * @return string
	 */
	private function makeSelection($selection){
		
		if(is_array($selection)){
			$selection = implode($selection, ",");
		}
		return $selection;
	}
	
	/**
	 * Returns error message in case it happened
	 * @return string
	 */
	public function error(){
		if($this->errorMsg!=null){
			return $this->errorMsg;
		}
	}
	
}