<?php
    session_start();
    include_once "databaseFunctions.php"; 
    $conn = connectToDatabase(); include_once "config.php";

    $outgoing_id = $_SESSION['idUsers'];
    $searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);

    $sql = "SELECT * FROM users WHERE NOT idUsers = {$outgoing_id} AND (nameAdmin LIKE '%{$searchTerm}%' OR surnameAdmin LIKE '%{$searchTerm}%') ";
    $output = "";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0){
        include_once "data.php";
    }else{
        $output .= 'No user found related to your search term';
    }
    echo $output;
?>