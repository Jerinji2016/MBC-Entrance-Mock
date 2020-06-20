<?php 
    include 'dbConnect.php';

    session_start();

    $user_name = $_SESSION['user-name'];
    $user_id = $_SESSION['user-id'];
    $ses_sql = mysql_query("SELECT user_id FROM student_list WHERE user_id='$user_id'");
    $row = mysql_fetch_array($ses_sql);

    echo $_SERVER['DOCUMENT ROOT'];

    if(!isset($row[0])) {
        header('Location: '.$_SERVER['DOCUMENT ROOT'].'\\MBC-Entrance-Mock\\');
    }
    // else
    //     echo "<script> console.log('Session check successfull') </script>";
?>