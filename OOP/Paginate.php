<?php

class Paginate extends database {


    private function checkS($action1, $action2) {

        if(isset($_GET['s']) && is_numeric($_GET['s']) && ($_GET['s']!=0)) {
           return $action1;
        }else{
           return $action2;
        }

    }

    public function firstPage(){

      return 0;

    }

    public function lastPage($table, $limit){

        $x = parent::Count($table);

        return ceil($x/$limit);
    }

    public function number($limit){

            $this->checkS($_GET['s'] / $limit, 0);
    }

    public function previousPage($limit){

        $this->checkS($_GET['s'] / $limit - 1, 0);
    }

    public function nextPage(){


    }


} 