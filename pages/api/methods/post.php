<?php
if ($cate <> "") {
    $pageURL = 'pages/api/includes/'.$cate.'.php';
    // Check if the file exists before including it
    if (file_exists($pageURL)) {
    	echo "test";
        include($pageURL);
    } else {
        $pageURL = 'pages/api/includes/main.php';
        include($pageURL);
    }
} else {
    $pageURL = 'pages/api/includes/main.php';
    include($pageURL);
}