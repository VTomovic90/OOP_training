<?php 
require_once("Tables.php");


class News extends Tables{
	
	/**
	 * String variable that shows class name
	 * Value is set in constructor
	 * @var $className
	 */
	public $className = null;
	
	/**
	 * Number of items to display per page
	 * Value is set in constructor
	 * @var $className
	 */
	public $items = null;
	
	/**
	 * Limits displayed numbers in paginator
	 * Value is set in constructor
	 * @var $displayNum
	 */
	public $displayNum = 5;
	
	
	
	/**
	 *
	 * @param Object $db
	 * @param number $items
	 */
	public function __construct($db,$items=10){
	
		$this->className = strtolower(get_class($this));
	
		$this->items = $items;
	
		$conf = array('table'=>$this->className , 'items'=>$this->items , 'displayNum'=>$this->displayNum);
	
		parent::__construct($db, $conf);
	}
	
	
	
	
	
}