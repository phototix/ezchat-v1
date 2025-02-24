<?php
if ($cate <> "") {
    $pageURL = 'includes/'.$cate.'.php';
    // Check if the file exists before including it
    if (file_exists($pageURL)) {
        include($pageURL);
    } else {
        $pageURL = 'includes/main.php';
    }
} else {
    $pageURL = 'includes/main.php';
}