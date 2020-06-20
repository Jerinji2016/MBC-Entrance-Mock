<?php 
    include '../../dbConnect.php';

    $category = $_GET['category'];
    $question = $_GET['question'];
    $op1 = $_GET['op1'];
    $op2 = $_GET['op2'];
    $op3 = $_GET['op3'];
    $op4 = $_GET['op4'];
    $answer= $_GET['answer'];
    $difficulty = $_GET['diff'];
    $user = $_GET['user'];

    switch($category) {
        case "physics" : 
            $sub_table = "physics_questions";
            break;
        case "chemistry":
            $sub_table = "chemistry_questions"; 
            break;
        case "maths": 
            $sub_table = "maths_questions";
            break;
        case "gk": 
            $sub_table = "gk_questions";
            break;
    }
    
    $var_sql = "INSERT INTO ".$sub_table."(question, option1, option2, option3, option4, answer, difficulty, entered_by) VALUES (";

    $var_sql .= '"'.$question.'", ';
    $var_sql .= '"'.$op1.'", ';
    $var_sql .= '"'.$op2.'", ';
    $var_sql .= '"'.$op3.'", ';
    $var_sql .= '"'.$op4.'", ';
    $var_sql .= '"'.$answer.'", ';
    $var_sql .= '"'.$difficulty.'", ';
    $var_sql .= '"'.$user.'")';

    $conn = mysql_query($var_sql);

    // echo $conn;
    $arr["conn"] = $conn;
    $arr["var"] = $var_sql;
    $arr["que"] = $question;
    echo json_encode($arr);
?>