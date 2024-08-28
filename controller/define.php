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
$Time=date("H:i:s");

$Token=md5($Today."webbycms".uniqid().$Time);

$Queryresult = [];

// Parse URL query to - Level 2 URL
if($page<>""&&$cate<>""&&$action<>""&&$id<>""){
	$str= str_replace("/".$page."/".$cate."/".$action."/".$id."?", "", $_SERVER["REQUEST_URI"]);
	parse_str(str_replace("/".$page."/".$cate."/".$action."/".$id."/?", "", $str), $Queryresult);
}
if($page<>""&&$cate<>""&&$action<>""&&$id==""){
	$str= str_replace("/".$page."/".$cate."/".$action."?", "", $_SERVER["REQUEST_URI"]);
	parse_str(str_replace("/".$page."/".$cate."/".$action."/?", "", $str), $Queryresult);
}
if($page<>""&&$cate<>""&&$action==""&&$id==""){
	$str= str_replace("/".$page."/".$cate."?", "", $_SERVER["REQUEST_URI"]);
	parse_str(str_replace("/".$page."/".$cate."/?", "", $str), $Queryresult);
}
if($page<>""&&$cate==""&&$action==""&&$id==""){
	$str= str_replace("/".$page."?", "", $_SERVER["REQUEST_URI"]);
	parse_str(str_replace("/".$page."/?", "", $str), $Queryresult);
}
if($page==""&&$cate==""&&$action==""&&$id==""){
	$str= str_replace("/?", "", $_SERVER["REQUEST_URI"]);
	parse_str($str, $Queryresult);
}
if($page=="main"&&$cate==""&&$action==""&&$id==""){
	$str= str_replace("/?", "", $_SERVER["REQUEST_URI"]);
	parse_str($str, $Queryresult);
}

// Country list (example; add more as needed)
$countries = [
    'Malaysia (MY)' => '60',
    'Singapore (SG)' => '65',
    'United States (US)' => '1',
    'United Kingdom (GB)' => '44',
    'Canada (CA)' => '1',
    'Australia (AU)' => '61',
    // Add more countries as needed
];

// Create variables from the associative array
foreach ($Queryresult as $Querykey => $Queryvalue) {
    $$Querykey = $Queryvalue;
}
?>