<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../css/dashboard-style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>
<body style="overflow-y: hidden">
    <script>
        var user = <?php include 'adminSession.php' ?>[1];
        console.log(user);
    </script>
    <div class="bg-image"></div>
    <div class="container">
        <div class="header">
            <img src="../../img/logo/mbc-logo-expanded.png" alt="mbc-logo">
        </div>
        <div class="body-container">
            <div class="dashboard">
                <div class="registered-student" onclick="window.location='students-registered.php'">
                    Students Registered
                </div>
                <div class="add-question" onclick="window.location='../../q-upload/q-index.html'">
                    Add Questions
                </div>
                <div class="edit-question" onclick="window.location='editQuestions.php'">
                    Edit Questions
                </div>
                <div class="student-result" onclick="window.location='student-result.php'">
                    Student Results
                </div>
            </div>
        </div>
    </div>
</body>
</html>