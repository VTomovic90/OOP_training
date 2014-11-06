</br>
<center>
<?php
	$selection = array('id','title','description','created','modified');
	$newsItems = $n->getAllPage($selection);
	?>
	<table style="width: 750px;" border="2" margin-right: auto; margin-left: auto; >
		<tr>
			<td><b>ID</b></td>
			<td><b>TEXT</b></td>
			<td><b>DESCRIPTION</b></td>
			<td><b>CREATED</b></td>
			<td><b>MODIFIED</b></td>
		</tr>
	
	<?php 
	foreach ($newsItems as $row){
		?><tr><?php
		foreach($row as $key=>$value){
			if($key == 'title'){
?>
				<td id="title"><a href="<?php echo 'index.php?view=news&n='.$row['id'];?>">  <?php echo $value;?> </a></td>
	<?php 		
			}else{
	?>
			<td><?php echo $value;?></td>
	<?php 
			}
		}
	?>
		</tr>
	<?php 
	}
	?>
		</table>
	<?php 
	
	
	$pretty = $n->pretty();
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
		    				  <td> <a href="index.php?view=news&s=<?php echo $value; ?>"> <?php echo $value;?> </a></td>
		    				    		
		    		<?php 
		    	}
			}
		}else{
						if($n->currentPage() == $n->firstPage() && ($k == 'previous' || $k == 'first')){
							 echo "<td>".$k."<td>";
						}
						elseif($n->currentPage() == $n->lastPage() && ($k == 'next' || $k == 'last')){
							echo "<td>".$k."<td>";
						}else{
				    		?>
				    		<td><a href="index.php?view=news&s=<?php echo $v; ?>"> <?php echo $k;?> </a></td>
				    		<?php 
		    			}
		}
		}

		
?>
</center>
</tr>
</table>
