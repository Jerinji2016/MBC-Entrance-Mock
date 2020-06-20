<?php 
    include '../../dbConnect.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';

    $arr = $_GET['arr'];
    $arr = json_decode($arr);

    for($x=0; $x<count($arr); $x++) {
        $user_id = $arr[$x][2];
        $pass = randomPassword();

        $check_sql = "DELETE FROM student_list WHERE user_id='".$user_id."'";
        mysql_query($check_sql);

        $insert_student = mysql_query("INSERT INTO student_list(name, phone, user_id, password) VALUES('".$arr[$x][0]."','".$arr[$x][1]."','".$user_id."','".$pass."')");
        echo $insert_student."\n\n";
        
        $change_status = mysql_query("UPDATE student_details SET approval_status=1 WHERE email='".$arr[$x][2]."'");
        echo $change_status."\n\n";

        sendMail($user_id, $pass);
    }

    function randomPassword() {
        $alpha = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $pass = substr(str_shuffle($alpha), 0, 8);
        return $pass;
    }

    function sendMail($user, $pass) {
        $mail = new PHPMailer(true);

        try {
            // SMTP Server Configuration
    
            $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username = 'codemechanic2019@gmail.com';
            $mail->Password = 'vjivqwqvurtrjzhr';
            $mail->SMTP = 'tls';
            $mail->Port = 587;
    
            //  Recipients
            $mail->setFrom('noreply@gmail.com', 'MBC Exam Cell');
            $mail->addAddress($user);
            
    
            //  Content
            $mail->isHTML(true);
            $mail->Subject = "Mail Regarding Scholarship Exam";
            $mail->Body = 'Your registration has successfully been approved by the Exam Cell <br>
                Please Go through the details given below<br><br>
                Visit <a>http://codemechanic.epizy.com/MBC-Entrance-Mock/</a>:<br>
                Login using your username and password given below:<br>
                Username : '.$user.'<br>Password : '.$pass.'<br> 
                Please contact this@gmail.com for any queries <br><br>
                <i>Regards <br> 
                Mar Baselios Christian College of Engineering & Technology <br>
                Kuttikanam, Idukki</i>';
            
            $mail->send();
            echo "Message Sent";
        }
        catch(Exception $e) {
            echo "Message Not Sent\n".$mail->ErrorInfo;
        }
    }
?>