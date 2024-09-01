<?php
/*
TItle: Database & Global Connection Handler
Authoer: Brandon Chong
Version: 3.0
Description: This conn.php file contains not just mysql database connections, 
also you can configure all your views or pages connections.
General Configurations of your web applications
*/
define ('WEBBY_ROOT', dirname(dirname(__FILE__)));

/* Here you can put your Localhost/Development Enviroment endpoint, so can be isolated from live database. */
$localhost_dev="";

/* Set your application timezone. */
date_default_timezone_set('Asia/Singapore');
/* Include PHP Variables and defines. */
require("define.php");

$host = 'localhost';
$db = 'db_EzyChat';
$user = 'root';
$pass = '#Abccy1982#';

try {
    // Create a new PDO instance and set error mode to exceptions
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Optional: set fetch mode to FETCH_ASSOC for associative arrays
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Catch any errors and display a message
    die("Connection failed: " . $e->getMessage());
}
?>