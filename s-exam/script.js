//  Number of Questions here #qno
const topics = ["physics", "chemistry", "maths", "gk"];
var t_counter = 0;

const noQues = {
    physics: 30,
    chemistry: 30,
    maths: 60,
    gk: 0
}
var questionNo = 20;

var currentTopic, currentQuestion;

if(!localStorage.getItem("topic")) {
    var questionArray = [];
    // console.log("No local storage item");
    questionArray.length = 0;
    currentTopic = "physics";
    questionNo = noQues[currentTopic];   
    currentQuestion = 1;

    localStorage.setItem("topic", currentTopic);
    localStorage.setItem("t-counter", t_counter);
    localStorage.setItem("q-no", currentQuestion);

    for(let c=1; c<=questionNo; c++)
        questionArray.push(c);
    localStorage.setItem("q-array", JSON.stringify(questionArray));
}
else {
    // console.log("Local storage item present");
    t_counter = parseInt(localStorage.getItem("t-counter"));
    currentTopic = localStorage.getItem("topic");
    currentQuestion = parseInt(localStorage.getItem("q-no"));
    questionArray = JSON.parse(localStorage.getItem("q-array"));
    // console.log(questionArray);
}

console.log(currentTopic, currentQuestion, "t_count="+t_counter);

//  Exam Time details #timer
var examDuration =  120*60,
    timerDuration = examDuration,
    lap = examDuration, 
    warnTime = 5;

var arr = {};
var topicTime = {
    physics: 0,
    chemistry: 0,
    maths: 0,
    gk: 0
}, interval;

initEvnironment();

window.onload = function() {
    var target = document.getElementById('timer');
    if(!localStorage.getItem('clock')) 
        localStorage.setItem('clock', timerDuration);
    else
        timerDuration = parseInt(localStorage.getItem('clock'));

    if(timerDuration <= 0)
        this.finish();

    // console.log(timerDuration);    
    startTimer(target, timerDuration);
}

function startTimer(target, duration) {
    var timer = duration, minutes, seconds;

    interval = setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        target.innerHTML = minutes + ":" + seconds;
        // console.log("timer"+timer, "td"+timerDuration);

        if(timer <= warnTime) {
            target.style.color = "red";
            target.style.animation = "hobble 1s infinite";
        }

        //  Stop when count down ends
        if (timer-- < 0) {
            timer = duration;
            clearInterval(interval);
        }
        
        if(timerDuration === 0) {
            localStorage.removeItem('clock');
            finish();
        }
        timerDuration--;
        localStorage.setItem('clock', timerDuration);
    }, 1000);
}

function initEvnironment() {
    questionNo = noQues[currentTopic];
    questionList(questionNo);
    
    // if(currentTopic == topics[2]) {
    //     //  Change Next Category Button to "Finish"
    //     var btn = document.getElementById('d-button');
    //     btn.setAttribute("onclick", "finish()");
    //     btn.setAttribute("value", "Finish");
    // }

    document.getElementsByClassName("topic")[t_counter].classList.add("topic-selected");
    document.getElementsByClassName("q-circle")[currentQuestion-1].classList.add("question-selected");

    // console.log("User Name : "+user);
    // console.log(questionArray, "Init env setup");
    for(let n=1; n<=questionNo; n++) {
        if((n-1)<4 && (n-1)<t_counter) 
            document.getElementsByClassName("topic")[n-1].classList.add('category-done');
        if(!questionArray.includes(n)) 
            document.getElementsByClassName("q-circle")[n-1].classList.add('question-done');

    }
    if(t_counter >= 3) {
        //  Change Next Category Button to "Finish"
        var btn = document.getElementById('d-button');
        btn.setAttribute("onclick", "finish()");
        btn.setAttribute("value", "Finish");

    }
    createUserTable();
    setQuestion(questionNo, currentTopic);
}
function createUserTable() {
    // console.log("create user table");
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'createUserDb.php?&user='+user, true);
    xhr.onreadystatechange = function() {
        if(xhr.readyState == 4 && xhr.status == 200) {
            // console.log(xhr.responseText);
            if(xhr.responseText != "1") 
                console.log("User DB Repeatition problem");
            else 
                console.log("- User DB Created");
        }
    }
    xhr.send(user);
}

function setQuestion(n, topic) {
    var xhr = new XMLHttpRequest();
    var x = "&n="+n+"&topic="+topic+"&user="+user;
    xhr.open('GET', 'setQuestion.php?'+x, true);
    xhr.onreadystatechange = function() {
        if(xhr.readyState == 4 && xhr.status == 200) {
            console.log(xhr.responseText);
            fetchQuestion();
        }
    }
    xhr.send(x);
}

function fetchQuestion() {
    var xhr = new XMLHttpRequest();
    console.log(currentTopic);
    var x = "&topic="+currentTopic+"&q="+currentQuestion+"&user="+user;

    xhr.open('GET', 'fetchQuestion.php?'+x, true);
    xhr.onreadystatechange = function() {
        if(xhr.readyState == 4 && xhr.status == 200) {
            arr = JSON.parse(xhr.responseText);
            console.log(arr);
            displayQuestion(arr);
        }
    }
    xhr.send(x);
}

function displayQuestion(arr) {
    // console.log(arr);
    let q = document.getElementById('question-target'),
        op1 = document.getElementById('op1-target'),
        op2 = document.getElementById('op2-target'),
        op3 = document.getElementById('op3-target'),
        op4 = document.getElementById('op4-target');

    q.innerHTML = arr.question;
    op1.innerHTML = arr.option1;
    op2.innerHTML = arr.option2;
    op3.innerHTML = arr.option3;
    op4.innerHTML = arr.option4;

    MathJax.typeset();
}
    
function questionList(n) {
    const target = document.getElementById('question-list');
    target.innerHTML = "";
    for(let i=1; i<=n; i++) {
        let div = document.createElement("DIV");
        div.innerHTML = i;
        div.classList.add("q-circle");
        div.setAttribute("onclick", "selectQuestion(this)")
        target.appendChild(div);

        if(i<questionNo) {
            let line = document.createElement("DIV");
            line.classList.add("line-next");
            target.appendChild(line);
        }
    }
}

function selectQuestion(event) {
    //  event - div object
    document.getElementsByClassName("q-circle")[(currentQuestion-1)].classList.remove("question-selected");
    event.classList.add("question-selected");
    currentQuestion = parseInt(event.innerHTML);

    localStorage.setItem("q-no", currentQuestion);
    console.log(localStorage.getItem("qno"));

    //  Clear marked Question
    var a = document.getElementsByName('ans');
    for(let i=0; i<4; i++) {
        a[i].checked = false;
    }

    fetchQuestion();

    //  May Need to be changed later based on Question number
    
}

function nextTopic() {  
    var conf = window.confirm("You cannot return back to the current Category later! \nDo you still want to continue?");
    if(conf) {
        //  Mark time for each topic
        topicTime[currentTopic] = lap - timerDuration;
        lap = timerDuration; 

        //  Change Style of Topic Selected
        document.getElementsByClassName('topic')[t_counter].classList.remove('topic-selected');
        document.getElementsByClassName('topic')[t_counter].classList.add('category-done');
        t_counter++;
        localStorage.setItem("t-counter", t_counter);

        document.getElementsByClassName('topic')[t_counter].classList.add('topic-selected');

        //  Reset Question Lists
        document.getElementById('question-list').innerHTML = "";
        questionList(questionNo);
        currentQuestion = 1;
        localStorage.setItem("q-no", currentQuestion);
        document.getElementsByClassName("q-circle")[0].classList.add("question-selected");

        //  Change current topic & Fetch Questions
        currentTopic = topics[t_counter];
        localStorage.setItem("topic", currentTopic);

        initEvnironment();

        questionArray.length = 0;
        for(let c=1; c<=questionNo; c++)
            questionArray.push(c);

        localStorage["q-array"] = JSON.stringify(questionArray);
        console.log("\n\n",JSON.parse(localStorage.getItem("q-array")));

        questionNo = noQues[currentTopic];
        console.log("Topic Change to "+ currentTopic);
        setQuestion(questionNo, currentTopic);

        if(t_counter >= 2) {
            //  Change Next Category Button to "Finish"
            var btn = document.getElementById('d-button');
            btn.setAttribute("onclick", "finish()");
            btn.setAttribute("value", "Finish");

        }
        questionList(questionNo); 
        // location.reload();
    }
}

//  Finish and Clean Up Test
function finish() {    
    console.log("Finished Test");
    topicTime[currentTopic] = lap - timerDuration;
    clearInterval(interval);

    // console.log(topicTime, "time for topics");

    var x = "&user=" + user;
    x += "&phytime=" + topicTime["physics"];
    x += "&chemtime=" + topicTime["chemistry"];
    x += "&mathtime=" + topicTime["maths"];
    x += "&gktime=" + topicTime["gk"];
    
    //  Evaluate Score
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "markUpdate.php?"+x, true);
    xhr.onreadystatechange = function() {
        if(xhr.readyState == 4 && xhr.status == 200) {
            console.log(xhr.responseText);
            localStorage.clear();
            document.cookie = "user=" + user;
            window.location = "examFinish.php";
        }
    }
    xhr.send(x);
}

var answer = null;

//  Find Marked Answer
function findAns() {
    var a = document.getElementsByName('ans');
    var flag = 0;
    for(let i=0; i<4; i++) {
        if(a[i].checked) {
            answer = a[i].value;
            console.log(answer);
            flag++;
            finalizeAnswer(answer);
        }
    }
    if(flag == 0) {
        alert("Please select an answer");
    }
} 

function finalizeAnswer(answer) {
    var question = document.getElementsByClassName('q-circle')[(currentQuestion-1)];
    question.classList.remove("question-selected");
    question.classList.add("question-done");

    var index = questionArray.indexOf(currentQuestion);
    var nextQ;

    questionArray.splice(questionArray.indexOf(currentQuestion),1);
    
    localStorage["q-array"] = JSON.stringify(questionArray);
    console.log(localStorage["q-array"], "ans submit");

    if(document.getElementsByClassName('q-circle')[questionArray[index]] == undefined)
        nextQ = document.getElementsByClassName('q-circle')[(questionArray[0]-1)];
    else   
        nextQ = document.getElementsByClassName('q-circle')[(questionArray[index]-1)];

    var xhr = new XMLHttpRequest();
    var x = "&slno="+currentQuestion+"&topic="+currentTopic+"&ans="+answer+"&user="+user;
    xhr.open('GET', 'addResult.php?'+x, true);
    xhr.onreadystatechange = function() {
        if(xhr.readyState == 4 && xhr.status == 200) {
            console.log(xhr.responseText);
            if(questionArray.length != 0)
                selectQuestion(nextQ);
            else
                nextTopic();
        }
    }
    xhr.send(x);
}

function questionChange(change) {
    var index = questionArray.indexOf(currentQuestion);
    var nextQ;

    console.log(questionArray);
    console.log(currentQuestion, index);

    if(change == '+') {
        if(document.getElementsByClassName('q-circle')[questionArray[index+1]] == undefined)
            nextQ = document.getElementsByClassName('q-circle')[(questionArray[0]-1)];
        else  
            nextQ = document.getElementsByClassName('q-circle')[(questionArray[index+1]-1)];
    } else {
        if(document.getElementsByClassName('q-circle')[questionArray[index-1]] == undefined)
            nextQ = document.getElementsByClassName('q-circle')[(questionArray[questionArray.length - 1]-1)];
        else  
            nextQ = document.getElementsByClassName('q-circle')[(questionArray[index-1]-1)];
    }
    selectQuestion(nextQ);
}