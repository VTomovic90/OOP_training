<?php

class Paginate extends database {


	
	/**
	 * 
	 * @param int $action1	- if  $_GET['s']  is set properly method will return   $_GET['s']+$action1
	 * @param int $action2	- if  $_GET['s']  is not set method will return $action2	
	 * @param string $table - name of table witch walues we want to paginate
	 * @param int $limit 	- number of elements that can be shown on page
	 * @return 
	 */
	
    public function checkS($action1, $action2, $table, $limit) {
        if(isset($_GET['s'])) {
            if((is_numeric($_GET['s'])) && ($_GET['s']>=$this->firstPage($table,$limit)) && ($_GET['s']<=$this->lastPage($table,$limit))) {
            	return $_GET['s'] + $action1;
            }else{
                return "Undefined value of page";
            }
        }else{
            return $action2;
        }


    }
	/*
	 * Returns index of first page
	 */
    public function firstPage(){

      return 1;
    }

    
    /*
     * Returns index of last page
     */
    public function lastPage($table, $limit){

        $x = parent::Count($table);

        return ceil($x/$limit);
    }

    
    /*
     * Returns indexes of all pages, and underlines current page
     */
    public function number($table,$limit){

         //  $this->checkS($_GET['s'] / $limit, 1, $table,$limit);

        $f = $this->firstPage($table,$limit);
        $l = $this->lastPage($table,$limit);

        for($i = $f; $i<=$l; $i++){
            if($i == $this->currentPage($table,$limit)){
                echo '<b><u>'.$i.'</u></b>'." ";
            }else {
                echo $i." ";
            }
        }

    }
    
    
	/*
	 * Returns index if current page
	 */
    public function currentPage($table,$limit){

      return $this->checkS(0, 1, $table, $limit);
//        if(isset($_GET['s'])){
//            return $_GET['s'];
//        }else{
//            return 1;
//        }
    }

    
    /*
     * Returns index of page that comes before current
     */
    public function previousPage($table, $limit){

       return $this->checkS(-1, 1, $table, $limit);

//        if(isset($_GET['s']) && $_GET['s']>$this->firstPage()){
//            return $_GET['s']-1;
//        }else{
//            return 1;
//        }
    }

    
    /*
     * Returns index of next page
     */
    public function nextPage($table, $limit){
        return $this->checkS(1, $this->currentPage($table,$limit)+1,$table,$limit);

//        if(isset($_GET['s']) && $_GET['s']<$this->lastPage($table, $limit)){
//            return $_GET['s']+1;
//        }else{
//            return $_GET['s'];
       }

    }
