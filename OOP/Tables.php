<?php

require_once("Paginate.php");

class Tables extends Paginate{
	
	
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
	 *
	 */
	public function getAllPage($selection = "*"){
		
		if(is_array($selection)){
			$selection = implode($selection, ",");
		}
		$sql = "SELECT ".$selection." FROM ".$this->className.$this->limitQuery();
		return $this->dbHandler->selectAll($sql);
	}
	
	
	/**
	 * Returns row with specified id
	 * @param Int $id
	 */
	public function getRowById($id, $selection = '*'){
		
		if(is_array($selection)){
			$selection = implode($selection, ",");
		}
		$sql = "SELECT ".$selection." FROM ".$this->className." WHERE id=".$id;
		return $this->dbHandler->selectAll($sql);
	}
	
	/**
	 * Returns complete table
	 * @param $selection
	 */
	public function getAll($selection = "*"){
	
		if(is_array($selection)){
			$selection = implode($selection, ",");
		}
		
		$sql = "SELECT ".$selection." FROM ".$this->className;
		return $this->dbHandler->selectAll($sql);
	}
	
	
	/**
	 * Gets id and returns next and previous row to that id
	 * @param Int $id
	 * @param $selection
	 * @throws Exception
	 */
	public function getNextPrevious($id, $selection = "*") {
		
		//gets value of first id
		$min = "SELECT id FROM ".$this->className;
		$s = $this->dbHandler->selectAll($min);
		$smallest = $s[0]['id'];

		//gets value of last id
		$max = "SELECT id FROM ".$this->className." ORDER BY id DESC";
		$s = $this->dbHandler->selectAll($max);
		$largest = $s[0]['id'];
		
		//checks if id is greater than smallest id in table
		if($id<=$smallest){
			throw new Exception("Can't get previous row.");
		}
		
		//checks if id is lesser than last id in table
		if($id>=$largest){
			throw new Exception("Can't get next row.");
		}
		
		if(is_array($selection)){
			$selection = implode($selection, ",");
		}
		
		$i = 1; 
		$j = 1;
		
		
		while($this->exists($id + $i) != true){
			$i++;
		}
		
		while($this->exists($id - $j) != true){
			$j++;
		}
		
		$sql = "SELECT ".$selection." FROM ".$this->className." WHERE id in (".($id-$j).", ".($id+$i).")";
		
		return $this->dbHandler->selectAll($sql);
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
	 * Returns 10 random rows from list
	 * @param string $selection
	 */
	public function getRandomList($selection = "*"){
		
		if(is_array($selection)){
			$selection = implode($selection, ",");
		}
		
		$sql = "SELECT ".$selection." FROM ".$this->className." ORDER BY RAND() LIMIT 10";
		
		return $this->dbHandler->selectAll($sql);
	}
	
}