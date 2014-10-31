<center>
<?php
//require_once("connect.php");
require_once("Paginate.php");
echo "Welcome to index page";
echo '</br>';

//$db = new Database($dbConfig);

//SELECT ALL
// $sql = "Select * from users";
// $users = $db->selectAll($sql);
// print_r($users);
// echo '</br>';

//SELECT FIRST
// $sql = "Select * from users";
// $users2 = $db->selectFirst($sql);
// print_r ($users2);
// echo '</br>';

//COUNT
// $users3 = $db->count('users');
// echo $users3;
// echo '</br>';

//INSERT

//$sql2 = "INSERT INTO users (username, password, created, modified, groups_id)VALUES('$username','$password',NOW(),NOW(),$groupid)";

// $values = array('username'=>'xxxxxxxxxxx','password'=>'yyyyyyyyy','groups_id'=>'4');

// $table = 'users';
// if($db->insert($values, $table)){
//    echo 'success: ->'.$db->getLastInsertedId();
// }else{
//    echo $db->getLastError();
// }
// 	echo '</br>';
// $column = 'username';
// $value = 'Mille3';
// $id = 17;
// $usersx = $db->insertOneVal($table, $column, $value, $id);
// $usersx = $db->update($table, $values, $id);
// if($usersx){
// 	echo 'SUCCESS';
// }else{
// 	echo $db->getLastError();
// }

//LAST INSERTED ID
// $lastid = $db->getLastInsertedId();
// echo 'Last insert id:'.$lastid;
// echo '</br>';

//UPDATE
//$username2 = 'zzzzzzzzzzzzz';
//$username2 = mysqli_real_escape_string($db->connect(),$username2);
//$sql3 = "UPDATE users SET username=".$username2." WHERE id=".$lastid;
// print_r($sql3);die();
// $id = 65;
// if($db->update('users',$values,$id)){
//    echo 'Success:';
// }else{
//    echo $db->getLastError();
// }
// echo '</br>';

 //INSERT ONE VALUE
//  $g = array('username'=>'RockyBalboa');
//  $x = $db->insertOneVal('users', $g, 66);
//  if($x){
//  	echo 'uradjeno';
//  }else{
//  	echo $db->getLastError();
//  }


//DELETE
// $users6 = $db->delete('users',65);
// echo $users6;

$conf = array('table'=>'users', 'items' => 10, 'displayNum' => 5);
$pages = new Paginate($dbConfig, $conf);

// echo "Number of users is: ". $pages->Count('users');

// echo '</br>';

/*LAST PAGE
 *
 * Takes 2 values, table name and limit and returns index of last page
 */
// 	$p1 = $pages->firstPage();
// 	echo "First page: ".$p1;
// 	echo '</br>';
// 	$p2 = $pages->lastPage();
// 	echo "Last page: ".$p2;
// 	echo '</br>';
// 	echo "Numbers: ";
// 	$p3 = $pages->number();
// 	echo '</br>';
// 	$p4 = $pages->currentPage();
// 	echo "Current page: $p4";
// 	echo '</br>';
// 	$p5 = $pages->previousPage();
// 	echo "Previous page: ".$p5;
// 	echo '</br>';
// 	$p6 = $pages->nextPage();
// 	echo "next page: ".$p6;
// 	echo '</br>';
	
	$pretty = $pages->pretty();
	foreach($pretty as $k=>$v){
	
		if($k == 'numbers'){
			foreach($v as $key=>$value){
				
				if(isset($_GET['s']) && $value == $_GET['s']){
					 echo $value;
				}else{
				?>
	    				   <a href="index.php?s=<?php echo $value; ?>"> <?php echo $value;?> </a>
	    				    		
	    		<?php 
	    			}
			}
	    		}else{
					if($pages->currentPage() == $pages->firstPage() && ($k == 'previous' || $k == 'first')){
					}
					elseif($pages->currentPage() == $pages->lastPage() && ($k == 'next' || $k == 'last')){
					}else{
	    		?>
	    		<a href="index.php?s=<?php echo $v; ?>"> <?php echo $k;?> </a>
	    		<?php 
	    			}
				}
	}

//$db->closeConnection();


?>
</center>