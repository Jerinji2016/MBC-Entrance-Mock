<?php
    include '../../dbConnect.php';

    $id = $_GET["id"];
    $question = $_GET['question'];
    $option1 = $_GET['option1'];
    $option2 = $_GET['option2'];
    $option3 = $_GET['option3'];
    $option4 = $_GET['option4'];
    $answer = $_GET['answer'];
    $difficulty = $_GET['difficulty'];
    $user = $_GET['user'];
    $topic = $_GET['topic'];
    
    $table = $topic."_questions";

    $var_sql = 'UPDATE '.$table.' SET ';
    $var_sql .= 'question="'.$question.'", ';
    $var_sql .= 'option1="'.$option1.'", ';
    $var_sql .= 'option2="'.$option2.'", ';
    $var_sql .= 'option3="'.$option3.'", ';
    $var_sql .= 'option4="'.$option4.'", ';
    $var_sql .= 'answer="'.$answer.'", ';  
    $var_sql .= 'difficulty="'.$difficulty.'", ';
    $var_sql .= 'entered_by="'.$user.'" WHERE sl_no='.$id;
 
    echo mysql_query($var_sql);
?>