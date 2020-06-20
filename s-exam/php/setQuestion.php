<?php 
    include '../../dbConnect.php';

    $n = $_GET['n'];
    $topic = $_GET['topic'];
    $user = $_GET['user'];
    $table = $topic."_questions";

    //  Set Question difficulty theme #diffTheme
    $easy_question = 6; 
    $avg_question = 8;
    $hard_question = 6;
    
    $count_check = "SELECT COUNT(*) FROM `$user` WHERE topic='$topic'"; 
    $count_check = mysql_query($count_check);
    $count_check = (int)mysql_fetch_array($count_check)[0];
    // echo $count_check;
    if($count_check == 0) {
        //  Fetch Question for each Difficulty
        // echo " -- here";
        questionFetchFromDB("easy", $table, $easy_question, $topic, $user, 0);
        questionFetchFromDB("average", $table, $avg_question, $topic, $user, $easy_question);
        questionFetchFromDB("hard", $table, $hard_question, $topic, $user, ($easy_question+$avg_question));
    }

    function questionFetchFromDB($difficulty, $table, $qCount, $topic, $user, $count) {
        // Fetch the number of rows 
        $fq = mysql_query("SELECT question, option1, option2, option3, option4, answer FROM $table WHERE difficulty='$difficulty'");
        $c = (int)mysql_num_rows($fq);

        $rand = range(1, $c);
        shuffle($rand);
        $rand = array_slice($rand, 0, $qCount);

        $i=1;
        while($row = mysql_fetch_array($fq)) {
            if(in_array($i, $rand)) {
                $iq = 'INSERT INTO `'.$user.'`(sl_no, question, option1, option2, option3, option4, answer, topic) VALUES('.(++$count).',"'.$row[0].'", "'.$row[1].'", "'.$row[2].'", "'.$row[3].'", "'.$row[4].'", "'.$row[5].'", "'.$topic.'")';
                $conn = mysql_query($iq);

                if(!$conn) {
                    echo "$i th question not added\n";
                    echo $row[0]."\n";
                    echo "\n".$iq."\n\n\n";
                }
            }
            $i++;
        }
    }
?>