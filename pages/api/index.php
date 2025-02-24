<?php
// Set the Content-Type header to application/json
header('Content-Type: application/json');

if($cate==""||$cate=="list"){
	$pageURL="includes/main.php";
}else{
	$pageURL="includes/".$cate.".php";
}
include($pageURL);

// Exit to ensure no additional output is sent
exit;
?>