<?php

include "tree.php";

$tree = new TreeOflife(isset($_GET['w']) ? $_GET['w'] : 650);

?>
<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8" />

<?php echo $tree->htmlandcss->css; ?>

<style>
.sphere-11
{
	border: 1px dashed #000;
}

.sphere-aux-11
{
	/* background-color: rgba(255,255,255,0.5); */
	opacity: 0.3;
}

.bottom-words
{
	font-weight: bold;
}
/*.spheres
{
	background-color: rgba(0,0,0,0);
}
.paths
{
	background-color: rgba(0,0,0,0);
}*/
</style>

</head>
<body>
<?php
	//echo $tree->debug(); 
	echo $tree->htmlandcss->html;
?>
</body>
</html>
