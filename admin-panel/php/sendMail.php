<?php 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';

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
        $mail->addAddress('jerinji2016@gmail.com');
        
        //  Client Reply to Admin
        // $mail->addReplyTo('');

        //  Content
        $mail->isHTML(true);
        $mail->Subject = "SMTP Test";
        $mail->Body = '<b>Test</b>';
        
        $mail->send();
        echo "Message Sent";
    }
    catch(Exception $e) {
        echo "Message Not Sent\n".$mail->ErrorInfo;
    }
?>


