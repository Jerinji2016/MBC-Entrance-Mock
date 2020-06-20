function checkField(a, b, c, d, e) {
    if(a == "" || b == "" || c == "" || d == "" || e == "") 
        return false;
    return true;
}

function submit() {
    // console.log("here");
    var category = document.getElementById('category').value,
        question = document.getElementById('question').value,
        option1 = document.getElementById('op1').value, 
        option2 = document.getElementById('op2').value, 
        option3 = document.getElementById('op3').value, 
        option4 = document.getElementById('op4').value, 
        answer = document.getElementById('answer').value, 
        difficulty = document.getElementById('difficulty').value;

    if(checkField(question, option1, option2, option3, option4) !== false) {
        var x;
        x = "&category="+category;
        x += "&question="+encodeURIComponent(question);
        x += "&op1="+encodeURIComponent(option1);
        x += "&op2="+encodeURIComponent(option2);
        x += "&op3="+encodeURIComponent(option3);
        x += "&op4="+encodeURIComponent(option4);
        x += "&answer="+answer;
        x += "&diff="+difficulty;
        x += "&user=Test_user";     
        // console.log(typeof(question));

        console.log(x);

        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'php/addQuestion.php?'+x, true);
        xhr.onreadystatechange = function() {
            if(xhr.readyState == 4 && xhr.status == 200) {
                //console.log("XHR-Status = " + xhr.responseText);
                console.log(xhr.response);
                var ar = JSON.parse(xhr.responseText);
                var arr = ar.conn;
                let query = document.getElementById("query"), color = "black";
                var text;
                console.log(ar);
                if(arr === true) {
                    color = "green";
                    text = "Question Added";
                    clearField();
                }
                else {
                    color = "red";
                    text = "Problem while adding the question to DB";
                    text += "<br> Please remove any \"(Double inverted commas in any field)"
                }
                query.style.borderColor = query.style.color = color;
                query.innerHTML=text;
                //alert('Question Added!');
            }
        }
        xhr.send();
    }
    else {
        alert("Do not leave any field empty!");
    }
}

function clearField() {
    document.getElementById('question').value = "";
    document.getElementById('op1').value = document.getElementById('op2').value = document.getElementById('op3').value = document.getElementById('op4').value = "";
    document.getElementById('question-preview').innerHTML = "";
    document.getElementById('op1-preview').innerHTML = "";
    document.getElementById('op2-preview').innerHTML = "";
    document.getElementById('op3-preview').innerHTML = "";
    document.getElementById('op4-preview').innerHTML = "";

}

function previewText(source, tgtId) {
    var target = document.getElementById(tgtId);
    target.innerHTML = source.value;
    console.log(source.value);
    MathJax.typeset();
}