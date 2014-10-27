<?php
//require_once("connect.php");
require_once("config.php");
require_once("Database.php");
require_once("Paginate.php");
echo "Welcome to index page";

$db = new Database($dbConfig);

//SELECT ALL
$sql = "Select * from users";
$users = $db->selectAll($sql);
//print_r($users);
echo '</br>';

//SELECT FIRST
$users2 = $db->selectFirst($sql);
print_r ($users2);
echo '</br>';

//COUNT
$users3 = $db->count('users');
echo $users3;
echo '</br>';

//INSERT

//$sql2 = "INSERT INTO users (username, password, created, modified, groups_id)VALUES('$username','$password',NOW(),NOW(),$groupid)";

$rows = array('username','password','groups_id');

$values = array('xxxxxxxxxxx','yyyyyyyyy','groups_id');

$table = 'users';
if($db->insert($rows,$values,$table)){
    echo 'success: ->'.$db->getLastInsertedId();
}else{
    echo 'Error insert: '.$db->getLastError();
}
//echo $users4;
echo '</br>';

//LAST INSERTED ID
$lastid = $db->getLastInsertedId();
echo 'Last insert id:'.$lastid;
echo '</br>';

//UPDATE
$username2 = 'zzzzzzzzzzzzz';
//$username2 = mysqli_real_escape_string($dbConfig,$username2);
$sql3 = "UPDATE users SET username='$username2' WHERE id=".$lastid;
//print_r($sql3);die();
if($db->update($sql3)){
    echo 'Success:';
}else{
    echo $db->getLastError();
}
//echo $users5;
echo '</br>';

//DELETE
if($db->delete('users',32));
//echo $users6;


$pages = new Paginate($dbConfig);
//Proveeravamo da li radi nasledjivanje
//echo "Number of users is: ". $pages->Count('users');


?>