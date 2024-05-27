<?php 
 
// Database configuration 
$dbHost     = "localhost"; 
$dbUsername = "imvmbotc_admin"; 
$dbPassword = "BaconFrito33"; 
$dbName     = "imvmbotc_imvmbot"; 
 
// Create database connection 
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName); 
 
// Check connection 
if ($db->connect_error) { 
    die("Connection failed: " . $db->connect_error); 
} 
