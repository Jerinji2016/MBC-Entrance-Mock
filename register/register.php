<?php 
    include '../dbConnect.php';

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $keam = $_POST['keam'];
    $jee = $_POST['jee'];
    $syllabus = $_POST['syllabus'];

    $parent_name = $_POST['parent-name'];
    $parent_phone = $_POST['parent-phone'];
    $address = $_POST['address'];

    echo "$parent_name -- $parent_phone -- $address <br><br>";

    $is_whatsapp = (isset($_POST['is-whatsapp'])) ? 1 : 0; 
    echo $is_whatsapp." <br><br>";

    // , parent_name, parent_phone, address, is_whatsapp
    echo "$keam $jee $syllabus\n";
    echo $phone;

    $var_sql = "INSERT INTO student_details(name, email, phone, keam, jee, syllabus, is_whatsapp, parent_name, parent_phone, address) VALUES('$name', '$email', $phone, $keam, $jee, '$syllabus', $is_whatsapp, '$parent_name', '$parent_phone', '$address')";
    echo $var_sql;
    $var_sql = mysql_query($var_sql);
    echo $var_sql;

    if($var_sql) 
        header("Location: register_complete.php");
    else {
?>
    <script>
        alert("Email already Exists. Please contact college Administrator");
        window.location = "index.html";
    </script>
<?php
    }
?>