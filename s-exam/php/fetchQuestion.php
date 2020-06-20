<?php 
    include '../../dbConnect.php';

    $q = $_GET['q'];
    $topic = $_GET['topic'];
    $user = $_GET['user'];
    // echo $q."  ".$topic."\n";

    $var_sql = "SELECT question, option1, option2, option3, option4 FROM `$user` WHERE sl_no=$q AND topic='$topic'";
    $row = mysql_fetch_array(mysql_query($var_sql));

    echo json_encode($row);
?>
