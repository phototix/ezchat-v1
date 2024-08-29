<?php  
$page="index.html";
if(isset($_GET["page"])&&!empty($_GET["page"])){
	$page = $_GET["page"].".html";
}

$file_path = $page;
if(file_exists($file_path)){
	$file_contents = file_get_contents($file_path);
	echo $file_contents;
}else{
	echo "Page Not Found";
}
?>