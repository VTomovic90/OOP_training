</br>
<center>
<?php
	$selection = array('id','text','created','modified','username');
	$blogItems = $b->getAllPage($selection);
	//$pretty = $b->pretty();
	//require_once 'PrintPage.php';
	
	//$x = new PrintPage($blogItems,$selection,$pretty);
	
	
?>
		<table style="width: 750px;" border="2" margin-right: auto; margin-left: auto; >
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
					if($key == 'title'){
		?>
						<td id="title"><a href="<?php echo 'index.php?view=blog&s='.$row['id'];?>">  <?php echo $value;?> </a></td>
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
			
			
			$pretty = $b->pretty();
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
				    				  <td> <a href="index.php?view=blog&s=<?php echo $value; ?>"> <?php echo $value;?> </a></td>
				    				    		
				    		<?php 
				    	}
					}
				}else{
								if($b->currentPage() == $b->firstPage() && ($k == 'previous' || $k == 'first')){
									 echo "<td>".$k."<td>";
								}
								elseif($b->currentPage() == $b->lastPage() && ($k == 'next' || $k == 'last')){
									echo "<td>".$k."<td>";
								}else{
						    		?>
						    		<td><a href="index.php?view=blog&s=<?php echo $v; ?>"> <?php echo $k;?> </a></td>
						    		<?php 
				    			}
				}
				}
?>
</center>
</tr>
</table>
