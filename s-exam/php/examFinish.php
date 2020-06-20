<script>
    var result = {
        'physics': [],
        'chemistry': [],
        'maths': [],
        'gk': []
    };

    var op = {
        a: "option1",
        b: "option2",
        c: "option3",
        d: "option4"
    };

    var resColor = {
        0 : 'red',
        5 : 'orange',
        10 : 'skyblue',
        15 : 'lightgreen',
        20 : 'rgb(12, 184, 12)'
    };

    var currentTopic = "physics";

</script>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Congrats</title>
        <link rel="stylesheet" href="../examFinish.css">

        <script>
        MathJax = {
            loader: {load: ['input/asciimath', 'output/chtml']}
        }
        </script>
        <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
        <script type="text/javascript" id="MathJax-script" async
            src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/startup.js">
        </script>

    </head>
    <body>
        <?php 
            include '../../dbConnect.php';
            $user = $_COOKIE['user'];
            
            $var_sql = "SELECT * FROM `$user`";
            $res = mysql_query($var_sql);

            $res_sql = "SELECT * FROM `student_list` WHERE user_id = '$user'";
            $result = mysql_fetch_assoc(mysql_query($res_sql));

            ?>
            <script>
                var finalResult = JSON.parse('<?php echo json_encode($result) ?>');
                // console.log(finalResult);
            </script>
            <?php

            while($row = mysql_fetch_assoc($res)) {
                ?> 
                <script>
                    var arr = JSON.parse('<?php echo json_encode($row) ?>');
                    result[arr['topic']].push(arr);
                </script>
                <?php
            }
   
            include '../../session.php';
            session_destroy();

            $var = mysql_query('DROP TABLE `'.$user.'`');
            echo $conn;
        ?>
        <div class="congrats-div">
            Congrats on completing your Exam
        </div>
        <div class="body-container">
            <div class="total-marks-container">
                <div class="topic-mark-container">
                    <div id="marks-physics" class="topic-marks">
                        <?php echo $result['physics_marks'] ?>/20
                        <hr>
                        <span>
                            Physics
                        </span>
                    </div>
                    <div class="mark-bar" id="mark-bar-physics"></div>
                </div>
                <div class="topic-mark-container">
                    <div id="marks-chemistry"class="topic-marks">
                        <?php echo $result['chemistry_marks'] ?>/20
                        <hr>
                        <span>
                            Chemistry
                        </span>
                    </div>
                    <div class="mark-bar" id="mark-bar-chemistry"></div>
                </div>
                <div class="topic-mark-container">
                    <div id="marks-maths" class="topic-marks">
                        <?php echo $result['maths_marks'] ?>/20
                        <hr>
                        <span>
                            Maths
                        </span>
                    </div>
                    <div class="mark-bar" id="mark-bar-maths"></div>
                </div>
                <div class="topic-mark-container">
                    <div id="marks-gk" class="topic-marks">
                        <?php echo $result['gk_marks'] ?>/20
                        <hr>
                        <span>
                            GK
                        </span>
                    </div>
                    <div class="mark-bar" id="mark-bar-gk"></div>
                </div>
            </div>
            <div class="check-note">
                Check where you went Wrong!!
            </div>
            <div class="topic-container">
                <button id="physics" class="topic-selected" onclick="selectTopic(this)">Physics</button>
                <button id="chemistry" onclick="selectTopic(this)">Chemistry</button>
                <button id="maths" onclick="selectTopic(this)">Maths</button>
                <button id="gk" onclick="selectTopic(this)">GK</button>
            </div>
            <hr style="width: 80%">

            <div class="result-container-heading">
                <div class="slno">Sl No.</div>
                <div class="question">Question</div>
                <div class="options">Options</div>
                <div class="answer">Answer</div>
                <div class="answered">Your Answer</div>
            </div>
            <div class="result-container" id='result-target'>

            </div>
        </div>
    </body>
</html>


<script>
    // console.log(result); 
    displayResult();

    window.onload = function() {
        // console.clear();

        setColor(document.getElementById('marks-physics'), finalResult.physics_marks);
        setColor(document.getElementById('marks-chemistry'), finalResult.chemistry_marks);
        setColor(document.getElementById('marks-maths'), finalResult.maths_marks);
        setColor(document.getElementById('marks-gk'), finalResult.gk_marks);

        MathJax.typeset();
    }

    function setColor(item, val) {
        r = Math.ceil(val/5);
        r *= 5;
        // console.log(r);
        item.style.color = resColor[r];
        item.parentNode.style.border = `2px solid ${resColor[r]}`;
        item.parentNode.childNodes[3].style.backgroundColor = resColor[r];
        item.parentNode.childNodes[3].style.width = Math.ceil((val*100)/20);
        // console.log(item.parentNode.childNodes[3]);
    }

    function selectTopic(event) {
        if(event.value == currentTopic) 
            return;
        else {
            var topicBtn = document.getElementById(currentTopic);
            topicBtn.classList.remove('topic-selected');
            event.classList.add('topic-selected');
            currentTopic = event.id;
            // console.log(currentTopic);

            displayResult();
        }
    }

    function displayResult() {
        var target = document.getElementById('result-target');

        var divContainer = document.createElement('DIV');
        divContainer.setAttribute('class', 'result-row');

        var slno = document.createElement('DIV'), 
            question = document.createElement('DIV'), 
            answer = document.createElement('DIV'), 
            answered = document.createElement('DIV'), 
            options = document.createElement('DIV');
        
        slno.setAttribute('class', 'slno');
        question.setAttribute('class', 'question');
        answer.setAttribute('class', 'answer');
        answered.setAttribute('class', 'answered');
        options.setAttribute('class', 'options');

        divContainer.appendChild(slno);         //  0
        divContainer.appendChild(question);     //  1
        divContainer.appendChild(options);      //  2
        divContainer.appendChild(answer);       //  3
        divContainer.appendChild(answered);     //  4

        // console.clear();
        // console.log(divContainer);
        target.innerHTML = "";

        for(let x=0; x<result[currentTopic].length; x++) {
            var div = divContainer.cloneNode(true);

            let item = result[currentTopic][x];
            let itemDiv =  div.childNodes;
            // console.log(item);

            itemDiv[0].innerHTML = item.sl_no;
            itemDiv[1].innerHTML = item.question;

            let option = `A. ${item.option1}<br><br>B. ${item.option2}<br><br>C. ${item.option3}<br><br>D. ${item.option4}`;
            itemDiv[2].innerHTML = option;
            
            itemDiv[3].innerHTML = item[op[item.answer]];
            itemDiv[4].innerHTML = item[op[item.answered]] ?? "{unanswered}";

            if(item.answered == null) {
                itemDiv[4].style.backgroundColor = 'transparent';
            } else if(item.answer == item.answered) {
                itemDiv[4].style.backgroundColor = 'rgba(37, 241, 37, 0.37)';
                itemDiv[4].style.boxShadow = '0px 0px 10px 5px rgba(37, 241, 37, 0.37)';
            }
            else {
                itemDiv[4].style.backgroundColor = 'rgba(241, 68, 37, 0.37)';
                itemDiv[4].style.boxShadow = '0px 0px 10px 5px rgba(241, 68, 37, 0.37)';
            }

            target.appendChild(div);
        }
        try {
            MathJax.typeset();
        }
        catch(e) {}
    }

</script>