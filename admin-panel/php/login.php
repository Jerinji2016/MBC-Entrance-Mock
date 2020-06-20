<?php    
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    include '../../dbConnect.php';

    $login_sql = mysql_query("SELECT * FROM admin_details WHERE user_id='$user'");

    if($row = mysql_fetch_array($login_sql)) {
        if($row[3] == $pass) {
            session_start();
            $_SESSION['user_id'] = $user;
            $_SESSION['user-name'] = $row[1];

            header("Location: dashboard.php");
        }
    }
    else {
?>
    <script>
        alert("Invalid Username or Password");
        window.location = "../";
    </script>
<?php
    }
?>