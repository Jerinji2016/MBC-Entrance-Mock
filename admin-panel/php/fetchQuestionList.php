<?php 
    include '../../dbConnect.php';

    $topic = $_GET['topic'];
    $difficulty = $_GET['difficulty'];
    $table = $topic."_questions";

    $fetch_list = "SELECT * FROM $table";
    if(isset($difficulty))
        $fetch_list .= " WHERE difficulty='$difficulty'";
    
    $conn = mysql_query($fetch_list);
 
    $arr = array();
    $i = 1;
    while($row = mysql_fetch_array($conn)) {
        $temp_arr = array();
        $temp_arr["id"] = $row[0];
        $temp_arr["slno"] = $i;
        $temp_arr["question"] = $row[1];
        $temp_arr["option1"] = $row[2];
        $temp_arr["option2"] = $row[3];
        $temp_arr["option3"] = $row[4];
        $temp_arr["option4"] = $row[5];
        $temp_arr["answer"] = $row[6];
        $temp_arr["difficulty"] = $row[7];
        $temp_arr["entered"] = $row[8];

        array_push($arr, $temp_arr);
        $i++;
    }
    echo json_encode($arr);
?>