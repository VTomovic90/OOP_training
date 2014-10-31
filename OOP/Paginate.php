<?php

require_once("Database.php");

class Paginate extends Database {
	
	/**
	 * Number of rows from table to be displayed on page
	 * @var Int $itemsPerPage
	 * @see $this->itemsPerPage()
	 */
	private $itemsPerPage = 10;
	
	/**
	 * Number of pages to be shown in paginator at once
	 * Value is taken from $conf array
	 * @var Int $itemsPerPage
	 */
	private $displayPages = null;
	
	/**
	 * Name of the mysql table that is being paginated
	 * Value is taken from $conf array
	 * @var unknown
	 */
	private $table = null;
	
	/**
	 * Number of rows in table
	 * @var Int $count
	 * @see $this->lastPage()
	 */
	private $count = null;
	
	/**
	 * Current page on paginator, takes value from querystring
	 * If querystring is not set, it has default value of 1
	 * @var Int $currentPage
	 * @see $this->currentPage()
	 */
	private $currentPage = 1;
	
	
	/**
	 * 
	 * @param Array $config
	 * @see config.php
	 * @param Array $conf - $conf = Array ('table'=>'tablename', 'items' => number, 'displayNum' => number)
	 * @return boolean
	 */
	public function __construct($config, $conf) {
		if(!is_array($conf) || empty($conf)){
				
			echo 'Second parameter of this object myst be array, and it must NOT be empty.';
		}
		
		if(!isset($conf['table'])) {
			echo 'You havent specified table to paginate.';
		}
		
		parent::__construct($config);
		
		$this->table = $conf['table'];
		
		$this->itemsPerPage = $conf['items'];
		
		$this->displayPages = $conf['displayNum'];
		
		$this->setup();
	}
	
	
	/**
	 * Checks if page number has been set in querystring, and if its value is valid
	 */
	private function setup(){
		
		$currentPage = isset($_GET['s']) ? intval($_GET['s']) : 1;
		
		if((is_numeric($currentPage)) && ($currentPage>=1) && ($currentPage<=$this->lastPage())) {
			 
			$this->currentPage = $currentPage;
	
		}
		
	}
	/**
	 * Sets index of first page(it will always be 1)
	 * @return 1
	 */
    public function firstPage(){

      return 1;
    }

    
    /**
     * Sets index of last page
     * @return number
     */
    public function lastPage(){
	
    	//Ispali upit
    	if($this->count==null){
    		//Store COUNT() query result
    		$this->count = $this->count($this->table);
    	}
        
        return ceil($this->count/$this->itemsPerPage);
    }

    /**
     * Sets indexes of all pages that should be displayed in paginator and puts them in array
     * @return Array $pages
     */
    public function number(){
		// number of pages to be shown left of current page
        $left = floor($this->displayPages/2);
        // number of pages to be shown right of current page
        $right = ceil($this->displayPages/2)-1;
        
        
        //what happens if there is not enough available pages on left
        if(($this->currentPage() - $left) < 1){
        	$right += ($left - $this->currentPage + 1);
        	$left -= ($left - $this->currentPage + 1);
        }
        
        //what happens if there is not enough available pages on right
        if(($this->currentPage + $right) > $this->lastPage()){
        	$left += $right - ($this->lastPage() - $this->currentPage);
        	$right = $this->lastPage() - $this->currentPage;
        }
        
        //Filling the array with indexes that should be shown in paginator
		$pages = array();
        for($i = $this->currentPage - $left; $i<= $this->currentPage + $right; $i++){
             $pages[] = $i;
        }
        return $pages;
    }
    
    
	/**
	 * Checks for querystring and if it is set gives its value to @var $this->currentPage
	 * @see $this->currentPage
	 * @return number
	 */
    public function currentPage(){
		if(isset($_GET['s'])){
			$this->currentPage = $_GET['s'];
		}
      return $this->currentPage;
    }

    
    /**
     * Sets value ti index of previous page
     * @return number
     */
    public function previousPage(){

    	if($this->currentPage() != $this->firstPage()){
       		return $this->currentPage() - 1;
    	}else{
    		return $this->currentPage();
    	}
    }

    
    /**
     * Returns id of next page
     * @return number
     */
    public function nextPage(){
    	
    	if($this->currentPage() != $this->lastPage()){
       		return $this->currentPage()+1;
       }else{
       		return $this->lastPage();
       }

    }
    
    
    /**
     * Returns array of all values from previous methods so they can be printed together
     * @return Array $pretty
     * @example $pretty = $pages->pretty();
     * @tutorial : tutorial.txt
		
     */
    public function pretty(){
    	 
    	$pretty = array(
    			'first'=> $this->firstPage(),
    			'previous'=> $this->previousPage(),
    			'numbers'=> $this->number(),
    			'next' => $this->nextPage(),
    			'last' => $this->lastPage()
    	);
    	 
    	return $pretty;
    }
}
