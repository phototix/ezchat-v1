<?php
if($cate==""||$cate=="list"){
	$pageURL="includes/main.php";
}else{
	$pageURL="includes/".$cate.".php";
}
include($pageURL);
?>