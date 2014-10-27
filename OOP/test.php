<?php
/**
 * Created by PhpStorm.
 * User: Actiontrip1
 * Date: 27-Oct-14
 * Time: 18:59
 */

$x = array("Prvi","Drugi","Treci");

echo '</br>';
echo '</br>';

foreach($x as $y){

//    $y = stripslashes($y);
//    $y = mysqli_real_escape_string($this->,$y);

    $g[] = "'".$y."',";
}

$nj = (implode($g))."NOW(),NOW()";
$sql = "INSERT INTO users (username, password, groupes_id, created, modified) VALUES (".$nj.")";
print_r($sql);

?>