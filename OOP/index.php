<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
	<link rel="stylesheet" href="css/layout.css" type="text/css" media="screen" />
</head>

<body>


<h2 style="color: silver;">My project:</h2>

<?php
require_once("Database.php");
require_once("Blog.php");
require_once("News.php");

$db = new Database($dbConfig);
$n = new News($db, 3);
$b = new Blog($db, 5)

	?>
	<div id="menu">
		<ul>
			<li><a href="index.php?view=blog">Blog</a></li>
			<li><a href="index.php?view=news">News</a></li>
		</ul>
	</div>
	
	<br>
	<div id="page">
<?php 
	if(isset($_GET['n'])){
		require_once 'oneNews.php';
	}else{
	if(isset($_GET['view'])){
		$page = $_GET['view'];
		require_once $_GET['view'].'View.php';
	}}
?>
	</div>
</body>
</html>