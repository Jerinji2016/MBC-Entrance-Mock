<?php 
    include '../../dbConnect.php';

    $id = $_GET['id'];
    $status = (int)$_GET['status'];
    $topic = $_GET['topic'];

    $table = $topic."_questions";

    // echo $table." ".$id." ".$status."\n";

    $var_sql = 'UPDATE '.$table.' SET status='.$status.' WHERE sl_no='.$id;
    // echo $var_sql."\n\n";
    echo mysql_query($var_sql);
?>