<?
	$homepage = file_get_contents("tmpindexphp.html");
	echo md5($homepage);
?>