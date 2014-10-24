<?php
//require_once("connect.php");
require_once("config.php");
require_once("Database.php");
echo "Welcome to index page";

$db = new Database($dbConfig);

$users = $db->selectAll("Select * from users");


$users = new database();

echo '</br>';
echo $users->getLastInsertedId('users',$con)."-th user is last";
echo '</br>';
$users->SelectFirst('users',$con);
echo '</br>';
    echo $users->Count('users',$con)+1 ."  Items in table";
echo '</br>';
    $vladimir = $users->SelectAll('users',$con);
    for($i=0; $i<$users->Count('users',$con); $i++ ){
        echo $vladimir['username'];
        echo "_____________________";
        echo $vladimir['group'];
        echo '</br>';
    }

echo '</br>';
echo '</br>';echo '</br>';
$pages = new paginate();
echo $pages->getLastInsertedId('users',$con)."-th user is last";

?>