<?php
    include '../../dbConnect.php';

    $slno = $_GET['slno'];
    $topic = $_GET['topic'];
    $answer = $_GET['ans'];
    $user = $_GET['user'];

    $check_ans = "SELECT answer FROM `$user` WHERE topic='$topic' AND sl_no=$slno";

    $row = mysql_fetch_array(mysql_query($check_ans));
    // echo $answer." ".$row[0]."\n";
    // echo strcmp($row[0], $answer)."\n";

    if(strcmp($row[0], $answer) == 0)
        $res = 1;
    else    
        $res = 0;

    $var_sql = "UPDATE `$user` SET result = $res, answered = '$answer' WHERE topic='$topic' AND sl_no=$slno";
    $conn = mysql_query($var_sql);
    echo $var_sql;
?>