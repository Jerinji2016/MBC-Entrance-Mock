<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results</title>
    
    <link rel="stylesheet" href="../css/student-result-style.css?v=4">
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Chettan+2:wght@600&family=Baloo+Da+2&family=Open+Sans&family=Roboto&family=Roboto+Condensed&display=swap" rel="stylesheet">

    <style>
        body {
            background: url("https://www.northatlantic-islands.com/fileadmin/template/content/images/bg/img_main.jpg");
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-size: cover;
            color: black;
            overflow-x: hidden;
            font-family: 'Baloo Da 2', cursive;
            font-family: 'Open Sans', sans-serif;
            font-family: 'Roboto', sans-serif;
            font-family: 'Roboto Condensed', sans-serif;
            font-family: 'Baloo Chettan 2', cursive;
        }
    </style>
</head>
<body>
    <script>
        var studentList = [], student;
        studentList.length = 0;
    </script>
    <?php 
        include '../../dbConnect.php';
    ?>   
        <script>
            var notaneed = <?php include 'adminSession.php'; ?> ;
            console.log(notaneed[1]);
        </script> 
    <?php
        $res = mysql_query("SELECT * FROM student_list WHERE exam_status>0");
    
        $noRows = mysql_num_rows($res);
        // echo $noRows;
        while($row = mysql_fetch_array($res)) {
    ?>
        <script>
            var noStudents = <?php echo $noRows; ?>;
            student = {
                name : "<?php echo $row[1]; ?>",
                userID : "<?php echo $row[3]; ?>",
                time : {
                    physics : <?php echo ($row[5] != null) ? $row[5] : 0; ?>,
                    chemistry : <?php echo ($row[6] != null) ? $row[6] : 0; ?>,
                    maths : <?php echo ($row[7] != null) ? $row[7] : 0; ?>,
                    gk : <?php echo ($row[8] != null) ? $row[8] : 0; ?>
                },
                totalTime : <?php echo ($row[5]+$row[6]+$row[7]+$row[8]) ?>,
                marks : {
                    physics : <?php echo ($row[9] != null) ? $row[9] : 0; ?>,
                    chemistry : <?php echo ($row[10] != null) ? $row[10] : 0; ?>,
                    maths : <?php echo ($row[11] != null) ? $row[11] : 0; ?>,
                    gk : <?php echo ($row[12] != null) ? $row[12] : 0; ?>
                },
                totalMarks : <?php echo ($row[9]+$row[10]+$row[11]+$row[12]) ?>,
                examStatus : <?php echo $row[13]; ?>
            };
            studentList.push(student);
        </script>
    <?php } ?>

    <div class="result-container">
        <div class="mbc-header-logo">
            <div>
                <img src="../../img/logo/mbc-logo-expanded.png" alt="mbc-logo" id="mbc-logo">
            </div>
            <div style="display: flex; justify-content: flex-end; align-items: center">
                <i class="material-icons" style="font-size:36px">person</i>
                <span id='user-name'> </span>
            </div>
        </div>
        <div class="result-body-container" id="result-list-target">
        </div>

        <div class="page-buttons">
            <button class="fd-button" onclick="pageChange('-')">&lt;&lt;&nbsp;Prev</button>
            <button class="fd-button" onclick="pageChange('+')">Next&nbsp;&gt;&gt;</button>
        </div>
    </div>
</body>
</html>

<script src="../script.js?v=4" defer></script>
<script>
    console.log(studentList);
    document.getElementById('user-name').innerHTML = notaneed[1];
</script>