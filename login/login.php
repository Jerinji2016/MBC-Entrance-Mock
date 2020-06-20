<?php 
    include '../dbConnect.php';
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $var_sql = "SELECT name, user_id, password, exam_status FROM student_list WHERE user_id='$user'";

    $res = mysql_query($var_sql);
    $row = mysql_fetch_array($res);
    if(empty($row) == 0 && $pass == $row[2]) {
        // echo "Login Successfull<br><br>";
        // echo "Checking for exam status <br><br>";
        
        if($row[3] == 1) {
?>
        <style>
            body {
                padding: 0;
                margin: 0;
                height: 100vh;
                background: url("https://images.unsplash.com/photo-1489844097929-c8d5b91c456e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&w=1000&q=80");
                background-size: cover;
                background-attachment: fixed;
                background-repeat: no-repeat;
            }
            .info-container {
                width: 60vw;
                height: 70vh;
                font-family: "Trebuchet MS", Helvetica, sans-serif;
                margin: auto;
                display: flex;
                flex-direction: column;
                justify-content: space-around;
                align-items: center;
            }
            .complete-info {
                font-size: 30px;
                text-align: center;
            }
            .contact-container {
                display: flex;
            }
            .contact-container div{
                margin: 10px;
            }
            .return-btn {

            }
            .return-btn button {
                padding: 10px 20px;
                text-decoration: none;
                cursor: pointer;
                border-radius: 10px;
                color: white;
                background-color: green;
            }
            a {
                text-decoration: none;
                color: white;
            }
        </style>
        <div class="info-container">
            <div class="complete-info">
                It seems you have completed the exam. <br>
                Please contact the administrator if there was any fault
            </div>
            <div class="contact-container">
                <div class="contact-label">Contact:</div>
                <div class="contact-info">+91 9876543210 <br>mbc@gmail.com</div>
            </div>
            <div class="return-btn">
                <button class="btn" onclick="window.location = '../index.html'"> Return to Login </button>
                <button class="btn"><a href="http://mbcpeermade.com/">More About MBC</a></button>
            </div>
        </div>
<?php
        }
        else {
            // create session 
            session_start();
            $_SESSION['user-name'] = $row[0];
            $_SESSION['user-id'] = $row[1];
            
            // redirect to exam            
            header("Location: ../s-exam/");
        }
    }
    else {    
?>      
    <script>
        alert("Login Failed! Invalid username or password");
        window.location = "../index.html";
    </script>
<?php   
    }
?>