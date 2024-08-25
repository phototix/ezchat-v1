<?php
$row="";
$systemError="";$systemSucces="";
if(empty($_SESSION["systemError"])){
	$_SESSION["systemError"]="";
}
if(empty($_SESSION["systemSucces"])){
	$_SESSION["systemSucces"]="";
}
$page="";
if(isset($_GET["page"])&&!empty($_GET["page"])){
	$page=$_GET["page"];
}
if($page==""||$page=="index"){
	$page="main";
}
$cate="";
if(isset($_GET["cate"])&&!empty($_GET["cate"])){
	$cate=$_GET["cate"];
}
$action="";
if(isset($_GET["action"])&&!empty($_GET["action"])){
	$action=$_GET["action"];
}
$id="";
if(isset($_GET["id"])&&!empty($_GET["id"])){
	$id=$_GET["id"];
}
$form="";
if(isset($_POST["form"])&&!empty($_POST["form"])){
	$form=$_POST["form"];
}
$token="";
if(isset($_POST["token"])&&!empty($_POST["token"])){
	$token=$_POST["token"];
}

/* Pre Defined Variables for Date & Time - This will used for Token generation */
$Today=date("Y-m-d");
$Day=date("d");
$Month=date("m");
$Year=date("Y");
$Hour=date("g");
$Minute=date("i");
$Seconds=date("s");
$Time=date("g:i A");

$Token=md5($Today."webbycms".uniqid().$Time);

// Parse URL query to - Level 2 URL
if($page<>""&&$cate<>""&&$action<>""&&$id<>""){
	$str= str_replace("/".$page."/".$cate."/".$action."/".$id."?", "", $_SERVER["REQUEST_URI"]);
	parse_str(str_replace("/".$page."/".$cate."/".$action."/".$id."/?", "", $str));
}
if($page<>""&&$cate<>""&&$action<>""&&$id==""){
	$str= str_replace("/".$page."/".$cate."/".$action."?", "", $_SERVER["REQUEST_URI"]);
	parse_str(str_replace("/".$page."/".$cate."/".$action."/?", "", $str));
}
if($page<>""&&$cate<>""&&$action==""&&$id==""){
	$str= str_replace("/".$page."/".$cate."?", "", $_SERVER["REQUEST_URI"]);
	parse_str(str_replace("/".$page."/".$cate."/?", "", $str));
}
if($page<>""&&$cate==""&&$action==""&&$id==""){
	$str= str_replace("/".$page."?", "", $_SERVER["REQUEST_URI"]);
	parse_str(str_replace("/".$page."/?", "", $str));
}
if($page==""&&$cate==""&&$action==""&&$id==""){
	$str= str_replace("/?", "", $_SERVER["REQUEST_URI"]);
	parse_str($str);
}
if($page=="main"&&$cate==""&&$action==""&&$id==""){
	$str= str_replace("/?", "", $_SERVER["REQUEST_URI"]);
	parse_str($str);
}
?>