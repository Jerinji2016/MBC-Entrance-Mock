<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../style.css?v=6">
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans&display=swap" rel="stylesheet">

    <script>
        MathJax = {
            loader: {load: ['input/asciimath', 'output/chtml']}
        }
    </script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script type="text/javascript" id="MathJax-script" async
        src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/startup.js">
    </script>

    <title>MBC | Mock Exam</title>
</head>
<body>
    <?php 
        include '../../dbConnect.php';
        include '../../session.php';

        $update_status = mysql_query("UPDATE student_list SET exam_status=1 WHERE user_id='$user_id'");
    ?>
    <script>    
        var user = "<?php echo $user_id; ?>"; 
    </script>
    <div id="timer" class="timer"></div>

    <div class="container">
        <div class="topic-container">
            <div class="topic">Physics</div>
            <div class="line-next"></div>
            <div class="topic">Chemistry</div>
            <div class="line-next"></div>
            <div class="topic">Maths</div>
            <div class="line-next"></div>
            <div class="topic">GK</div>
        </div>
        <div class="question-wrapper">
            <div class="question-list" id="question-list"></div>
            
            <div class="question-container">
                <div class="question" id="question-target">
                    Q. Question Here?
                </div>
                <div class="option-container">
                    <div id="option_target">
                        <div onclick="this.childNodes[1].checked = true">
                            <input type="radio" name="ans" id="ans" value="a">
                            <span id="op1-target">Option 1</span>
                        </div>
                        <div onclick="this.childNodes[1].checked = true">
                            <input type="radio" name="ans" id="ans" value="b">
                            <span id="op2-target">Option 2</span>
                        </div>     
                        <div onclick="this.childNodes[1].checked = true">
                            <input type="radio" name="ans" id="ans" value="c">
                            <span id="op3-target">Option 3</span>
                        </div>    
                        <div onclick="this.childNodes[1].checked = true">
                            <input type="radio" name="ans" id="ans" value="d">
                            <span id="op4-target">Option 4</span>
                        </div>
                    </div>
                </div>
                
            </div>  
        </div>
        
        <div class="note-submit">
            <b>Note:</b> Your answers are noted only when you click on <b>Submit</b>!
        </div>

        <div id="submit">
            <input type="submit" value="Submit" onclick="findAns()">
            <input type="button" id='d-button' value="Next Category" onclick="nextTopic()" style="margin-left: 50px">
        </div>
    </div>
</body>
</html>

<script src="../script.js?v=5"> </script>