<center>
<h2 style="color: silver">One News</h2>
<?php 

	$id = $_GET['n'];
	
	?>
<div id="one-by-one" style="border-style: double; border-color: silver;">
<?php 
	if($n->getRowById($id) == false){
		echo $n->error();
	}else{
		$row = $n->getRowById($id)[0];

		echo $row['title'];
		echo '</br>';
		echo $row['description'];
		echo '</br> </br>';
		echo "BY: ".$row['author'];
	}
	
?>
</div>
</br>
</br>
</br>

<?php 
	if($n->getNextPrevious($id) == false){
		echo $n->error();
	}else{
		$test = $n->getNextPrevious($id);
?>
<div id="wrap" style="width: 848px">
		<div id="previous"">
			<h2 style="color: silver;"> Previous title </h2>
			<?php echo($test['previous']['title']); ?>
		</div>
		
		</br>
		
		<div id="next"">
		<h2 style="color: silver;"> Next title </h2>
			<?php echo($test['next']['title']); ?>
		</div>
	<br>
	<div id="pr-nxt"">
<?php if($test['previous']['title']  != "You are curently on first row!"){ ?>
	<a href="index.php?n=<?php echo $test['previous']['id'];?>"> Previous </a><?php }
	if($test['next']['title']  != "You are curently on last row!"){?>
	<a href="index.php?n=<?php echo $test['next']['id'];?>"> Next </a>
	</div>
</div>
<?php 
	}
}
?>
</center>