<div id="ses-dets">
    <?php include 'adminSession.php' ?>
</div>
<script>
    document.getElementById("ses-dets").style.display = "none";
    var aray = JSON.parse(document.getElementById("ses-dets").innerHTML);
    console.log(aray);
    var user = aray[1];

    var currentTopic = "physics", hardness = null;
    var questionList = {};
    var questionsPerLoad = 10, pageNo = 1;

    var questionDivTemplate = document.createElement("DIV");
    questionDivTemplate.setAttribute("class", "question-div-container");

    var slno = document.createElement("DIV"),
        question = document.createElement("DIV"),
        options = document.createElement("DIV"),
        answer = document.createElement("DIV"),
        difficulty = document.createElement("DIV"),
        enteredBy = document.createElement("DIV"),
        editBtn = document.createElement("DIV");

    slno.setAttribute("class", "q-slno");

    question.setAttribute("class", "q-question");
    
    options.setAttribute("class", "q-options");
    
    answer.setAttribute("class", "q-answer");
    answer.setAttribute("id", "answer");
    
    difficulty.setAttribute("class", "q-difficulty");
    difficulty.setAttribute("id", "difficulty");

    enteredBy.setAttribute("class", "q-enteredby");
    
    editBtn.setAttribute("class", "edit-btn");
    editBtn.setAttribute("onclick", "edit(this.parentNode)");
    editBtn.innerHTML = "Edit";

    var op1 = document.createElement("DIV"), 
        op2 = document.createElement("DIV"), 
        op3 = document.createElement("DIV"), 
        op4 = document.createElement("DIV");

    options.appendChild(op1);
    options.appendChild(op2);
    options.appendChild(op3);
    options.appendChild(op4);

    //  Add all child to the template
    questionDivTemplate.appendChild(slno);
    questionDivTemplate.appendChild(question);
    questionDivTemplate.appendChild(options);
    questionDivTemplate.appendChild(answer);
    questionDivTemplate.appendChild(difficulty);
    questionDivTemplate.appendChild(enteredBy);
    questionDivTemplate.appendChild(editBtn);
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Questions</title>
    <link rel="stylesheet" href="../css/edit-question-style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Da+2&family=Open+Sans&family=Roboto&family=Roboto+Condensed&display=swap" rel="stylesheet">
    <style>
        body {
            background: url("https://www.signoffsemi.com/wp-content/uploads/2017/02/CEOhDl.jpg");
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-size: cover;
            color: white;
        }
    </style>

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
    <div id="float-edit-container">
        <div class="float-edit-container">
            <!-- Make a hovering Div to edit -->
        </div>
        <div class="modal" id="modal">
            <div class="edit-wrapper">
                <div class="label-edit">Question : </div>
                <div class="field-edit">
                    <textarea name="question" id="question" cols="30" rows="4"></textarea>
                </div>
            </div>
            <div class="edit-wrapper">
                <div class="label-edit">Options : </div>
                <div class="field-edit">
                    A)&nbsp;<input type="text" name="option1" id="option1"><br>
                    B)&nbsp;<input type="text" name="option2" id="option2"><br>
                    C)&nbsp;<input type="text" name="option3" id="option3"><br>
                    D)&nbsp;<input type="text" name="option4" id="option4"><br>
                </div>
            </div>
            <div class="edit-wrapper">
                <div class="label-edit">Answer : </div>
                <div class="field-edit">
                    <select name="answer" id="answer">
                        <option value="a">A</option>
                        <option value="b">B</option>
                        <option value="c">C</option>
                        <option value="d">D</option>
                    </select>
                </div>
            </div>
            <div class="edit-wrapper">
                <div class="label-edit">Difficulty : </div>
                <div class="field-edit">
                    <select name="difficulty" id="difficulty">
                        <option value="easy">Easy</option>
                        <option value="average">Average</option>
                        <option value="hard">Hard</option>
                    </select>
                </div>
            </div>
            <div class="edit-btn-wrapper">
                <input type="submit" value="Submit" onclick="updateQuestion()">
                <input type="button" value="Cancel" onclick="hideModal()">
            </div>
        </div>
    </div>

    <script>
        var modalOrigin = document.getElementById('modal');
        var modal = {
            question : document.getElementById('question'),
            options : {
                option1 : document.getElementById('option1'),
                option2 : document.getElementById('option2'),
                option3 : document.getElementById('option3'),
                option4 : document.getElementById('option4')
            },
            answer : document.getElementById('answer'),
            difficulty : document.getElementById('difficulty')
        }
    </script>
    <div class="q-body-container">
        <div class="mbc-header-logo">
            <div>
                <img src="../../img/logo/mbc-logo-expanded.png" alt="mbc-logo" id="mbc-logo">
            </div>
            <div style="display: flex; justify-content: flex-end; align-items: center">
                <i class="material-icons" style="font-size:36px">person</i>
                <span id='user-name'> </span>
            </div>
        </div>
        <div class="filter-container">
            <div id="physics">
                <button id="physics-btn" class="topic-button topic-selected" onclick="selectTopic(this)"> Physics </button>
                <div class="difficulty-options">
                    <button onclick="selectTopic(this)">E</button>
                    <button onclick="selectTopic(this)">A</button>
                    <button onclick="selectTopic(this)">H</button>
                </div>
            </div>
            <div id="chemistry">
                <button id="chemistry-btn" class="topic-button" onclick="selectTopic(this)"> Chemistry </button>
                <div class="difficulty-options">
                    <button onclick="selectTopic(this)">E</button>
                    <button onclick="selectTopic(this)">A</button>
                    <button onclick="selectTopic(this)">H</button>
                </div>
            </div>

            <div id="maths">
                <button id="maths-btn" class="topic-button" onclick="selectTopic(this)"> Maths </button>
                <div class="difficulty-options">
                    <button onclick="selectTopic(this)">E</button>
                    <button onclick="selectTopic(this)">A</button>
                    <button onclick="selectTopic(this)">H</button>
                </div>
            </div>
            
            <div id="gk">
                <button id="gk-btn" class="topic-button" onclick="selectTopic(this)"> GK </button>
                <div class="difficulty-options">
                    <button onclick="selectTopic(this)">E</button>
                    <button onclick="selectTopic(this)">A</button>
                    <button onclick="selectTopic(this)">H</button>
                </div>
            </div>
        </div>
        <hr>
        <div class="question-header">
            <div class="question-list-heading q-slno">Sl No.</div>
            <div class="question-list-heading q-question">Question</div>
            <div class="question-list-heading q-options">Options</div>
            <div class="question-list-heading q-answer">Answer</div>
            <div class="question-list-heading q-difficulty">Difficulty</div>
            <div class="question-list-heading q-enteredby">Entered By</div>
            <div class="question-list-heading">Edit Values</div>
        </div>
        <hr>
        <div class="question-container" id="question-list-target"></div>

        <div class="page-buttons">
            <button class="fd-button" onclick="pageChange('-')">&lt;&lt;&nbsp;Prev</button>
            <button class="fd-button" onclick="pageChange('+')">Next&nbsp;&gt;&gt;</button>
        </div>
    </div>
</body>
</html>

<script>
    document.getElementById('user-name').innerHTML = user;
    fetchQuestionList();

    function selectTopic(event) {
        // console.log(event.innerHTML.length);
        console.log(hardness);
        if(event.innerHTML.length !== 1) {

            document.getElementById(currentTopic).childNodes[1].classList.remove('topic-selected');
            if(hardness) {
                let ele = document.getElementById(currentTopic).childNodes[3].childNodes[(hardness=="easy"?1:((hardness=="average")?3:5))];
                ele.classList.remove('topic-selected');
            }
            currentTopic = event.parentNode.id;
            event.classList.add('topic-selected');
            hardness = null;
        }
        else {
            let parentButton = event.parentNode.parentNode.childNodes[1];
            
            //  Remove style of currently selected Buttons
            document.getElementById(currentTopic).childNodes[1].classList.remove('topic-selected');
            if(hardness) {
                let ele = document.getElementById(currentTopic).childNodes[3].childNodes[(hardness=="easy"?1:((hardness=="average")?3:5))];
                ele.classList.remove('topic-selected');
            }
            // console.log(event);
            //  Set current topic
            currentTopic = event.parentNode.parentNode.id;

            //  Set style of currently selected button
            parentButton.classList.add('topic-selected');
            event.classList.add('topic-selected');
            
            switch(event.innerHTML) {
                case 'E' :
                    hardness = "easy"; 
                    break;
                case 'A' : 
                    hardness = "average";
                    break;
                case 'H' : 
                    hardness = "hard";
                    break;
            }
        }
        fetchQuestionList(); 
    }

    function fetchQuestionList() {
        var x = "&topic="+currentTopic;
        x += hardness ? ("&difficulty="+hardness) : "";
        
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'fetchQuestionList.php?'+x, true);
        xhr.onreadystatechange = function() {
            if(xhr.readyState == 4 && xhr.status == 200) {
                questionList.length = 0;
                questionList = JSON.parse(xhr.responseText);
                displayList();
                MathJax.typeset();
            }
        }
        xhr.send(x);
    }

    // questionsPerLoad, pageNo

    function displayList() {
        var target = document.getElementById('question-list-target');
        target.innerHTML = "";

        for(let x=(questionsPerLoad*(pageNo-1)); (x<questionList.length && x<(pageNo*questionsPerLoad)); x++) {
            let div = questionDivTemplate.cloneNode(true);
            div.setAttribute("id", questionList[x].slno);

            //  Sl No.
            div.childNodes[0].innerHTML = questionList[x].slno;

            //  Question
            div.childNodes[1].innerHTML = questionList[x].question;

            //  Options
            div.childNodes[2].childNodes[0].innerHTML = "A) " + questionList[x].option1;
            div.childNodes[2].childNodes[1].innerHTML = "B) " + questionList[x].option2;
            div.childNodes[2].childNodes[2].innerHTML = "C) " + questionList[x].option3;
            div.childNodes[2].childNodes[3].innerHTML = "D) " + questionList[x].option4;

            //  Answer
            switch(questionList[x].answer) {
                case 'a': 
                    div.childNodes[3].innerHTML = questionList[x].answer + ". " + questionList[x].option1;      
                    break;
                case 'b': 
                    div.childNodes[3].innerHTML = questionList[x].answer + ". " + questionList[x].option2;
                    break;
                case 'c': 
                    div.childNodes[3].innerHTML = questionList[x].answer + ". " + questionList[x].option3;
                    break;
                case 'd': 
                    div.childNodes[3].innerHTML = questionList[x].answer + ". " + questionList[x].option4;
                    break;
            }

            //  Difficulty
            div.childNodes[4].innerHTML = questionList[x].difficulty;

            //  Entered By
            div.childNodes[5].innerHTML = questionList[x].entered;

            target.appendChild(div);
        }
    }

    function pageChange(str) {
        if(str === '+') {
            if(pageNo < Math.ceil(questionList.length/questionsPerLoad))
                pageNo++;
                displayList();
        }
        else {
            if(pageNo > 1) {
                pageNo--;
                displayList();
            }
        }
    }

    function hideModal() {
        document.getElementById('modal').style.animation = "popOut .3s ease-out";
        setTimeout(function() {
            document.getElementById('float-edit-container').style.display="none";
        }, 290);
        
    }
    var editQ;
    function edit(origin) {
        var target = document.getElementById('modal');

        //  Style & Animation
        document.getElementById('float-edit-container').style.display = "flex";
        document.getElementById('modal').style.animation = "popIn .3s ease-in";

        var id = parseInt(origin.id)-1;
        editQ = id;
        console.log(id);
        console.log(questionList[id]);
        console.log(origin);
        modal.question.value = questionList[id].question;
        modal.options.option1.value = questionList[id].option1;
        modal.options.option2.value = questionList[id].option2;
        modal.options.option3.value = questionList[id].option3;
        modal.options.option4.value = questionList[id].option4;
        modal.answer.value = questionList[id].answer;
        modal.difficulty.value = questionList[id].difficulty;
    }

    function updateQuestion() {
        let question = document.getElementById('question').value, 
            option1 = document.getElementById('option1').value, 
            option2 = document.getElementById('option2').value,
            option3 = document.getElementById('option3').value,
            option4 = document.getElementById('option4').value, 
            answer = document.getElementById('answer').value,
            difficulty = document.getElementById('difficulty').value;

            
        var x = "&id="+questionList[editQ].id;
        x += "&question="+encodeURIComponent(question);
        x += "&option1="+encodeURIComponent(option1);
        x += "&option2="+encodeURIComponent(option2);
        x += "&option3="+encodeURIComponent(option3);
        x += "&option4="+encodeURIComponent(option4);
        x += "&answer="+answer;
        x += "&difficulty="+difficulty;
        x += "&user="+user;
        x += "&topic="+currentTopic;
        
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'updateQuestion.php?'+x, true);
        xhr.onreadystatechange = function() {
            if(xhr.readyState == 4 && xhr.status == 200) {
                if(xhr.responseText == "1") {
                    fetchQuestionList();
                    hideModal();
                }
                else {
                    alert("ERROR! Question Not Updated! \n Check if any of the field contains double-inverted commas(\")")
                }
            }
        }
        xhr.send(x);
   }
</script>