<?php 
    include '../../dbConnect.php';

    $user = $_GET['user'];

    $var_sql = "CREATE TABLE `$user`(
        sl_no INT, 
        question varchar(700) NOT NULL, 
        option1 varchar(300) NOT NULL, 
        option2 varchar(300) NOT NULL, 
        option3 varchar(300) NOT NULL, 
        option4 varchar(300) NOT NULL, 
        answer varchar(5) NOT NULL, 
        result int, 
        topic varchar(10),
        answered varchar(5))";
        
        // echo $var_sql;
    $conn = mysql_query($var_sql);
    // echo $conn;
?>