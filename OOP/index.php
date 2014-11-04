<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
	<link rel="stylesheet" href="css/layout.css" type="text/css" media="screen" />
	</head>
<body>

<center>

<h2 style="color: lightblue;">Welcome to index page:</h2>

<?php
require_once("Database.php");
require_once("Blog.php");

$db = new Database($dbConfig);

//$pagination = new Paginate($db, $c);

echo '<br>';

	
	$blog = new Blog($db, 5);
	try{
		$test = $blog->getNextPrevious(27);
		print_r($test);
	}catch (Exception $e){
		echo $e->getMessage();
	}

	
	die();
	
	$blogItems = $blog->getAllPage();
	?>
	<table style="width: 650px;" border="2" >
		<tr>
			<td><b>ID</b></td>
			<td><b>TEXT</b></td>
			<td><b>CREATED</b></td>
			<td><b>MODIFIED</b></td>
			<td><b>USERNAME</b></td>
		</tr>
	
	<?php 
	foreach ($blogItems as $row){
		?><tr><?php
		foreach($row as $key=>$value){
	?>
			<td><?php echo $value;?></td>
	<?php 
		}
	?>
		</tr>
	<?php 
	}
	?>
		</table>
	<?php 
	
	
	$pretty = $blog->pretty();
	?>
	
	<table  style="width: 500px"> <tr>
	<?php
	foreach($pretty as $k=>$v){
	
		if($k == 'numbers'){
			foreach($v as $key=>$value){
	
				if(isset($_GET['s']) && $value == $_GET['s']){
					echo '<td>'.$value.'</td>';
				}else{
					?>
		    				  <td> <a href="index.php?s=<?php echo $value; ?>"> <?php echo $value;?> </a></td>
		    				    		
		    		<?php 
		    			}
				}
		    		}else{
						if($blog->currentPage() == $blog->firstPage() && ($k == 'previous' || $k == 'first')){
						}
						elseif($blog->currentPage() == $blog->lastPage() && ($k == 'next' || $k == 'last')){
						}else{
		    		?>
		    		<td><a href="index.php?s=<?php echo $v; ?>"> <?php echo $k;?> </a></td>
		    		<?php 
		    			}
					}
		}

		
		
?>

</tr>
</table>
</center>
</body>
</html>