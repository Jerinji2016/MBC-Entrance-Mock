<script>
    const sylbabus = {
        state: "Kerela State",
        cbse: "CBSE",
        icse: "ICSE",
        others: "Others"
    };

    var studentList = [], studentsPerPage=13, currentPage=1;
    var studentDivTemplate = document.createElement("DIV");
    let slno = document.createElement("DIV"),
        name = document.createElement("DIV"),
        email = document.createElement("DIV"),
        phone = document.createElement("DIV"),
        mark = document.createElement("DIV"),
        syllabus = document.createElement("DIV");
    slno.setAttribute("class", "slno-div");
    name.setAttribute("class", "name-div");
    email.setAttribute("class", "email-div");
    phone.setAttribute("class", "phone-div");
    syllabus.setAttribute("class", "syllabus");

    mark.setAttribute("class", "mark-div");

    let input = document.createElement("INPUT");
    input.setAttribute("type", "checkbox");
    
    let sendBtn = document.createElement("BUTTON");
    sendBtn.setAttribute('class', 'send-button');
    
    let whatsapp = document.createElement("I");
    whatsapp.setAttribute('class', 'fa fa-whatsapp');
    sendBtn.appendChild(whatsapp);
    sendBtn.innerHTML += '&nbsp; WhatsApp';

    mark.appendChild(input);
    mark.appendChild(sendBtn);

    studentDivTemplate.setAttribute("class", "student-wrapper");
    studentDivTemplate.appendChild(slno);
    studentDivTemplate.appendChild(name);
    studentDivTemplate.appendChild(email);
    studentDivTemplate.appendChild(phone);
    studentDivTemplate.appendChild(syllabus);
    studentDivTemplate.appendChild(mark);
    console.log(studentDivTemplate);
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Students</title>
    <link rel="stylesheet" href="../css/students-registered-style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
</head>
<?php
    include '../../dbConnect.php';
?>
<script>
    var user = <?php include 'adminSession.php'; ?>[1];
</script>
<?php
    $var_sql = mysql_query('SELECT * FROM student_details');
    $i=1;
    while($row = mysql_fetch_assoc($var_sql)) {
?>
    <script>
        studentList.push(<?php echo json_encode($row) ?>);
    </script>
<?php
    $i++;
    }
?>
<body>
    <div class="container">
        <div class="header">
            <img src="../../img/logo/mbc-logo-expanded.png" alt="mbc-logo">
            <span id="user"></span>
        </div>
        <div class="body-container" id="target"></div>

        <div class="change-btn">
            <button class="prev-btn" onclick="changePage('-')">&lt;&lt;Prev</button>
            <button class="submit-btn" onclick="submitApproval()">Submit</button>
            <button class="next-btn" onclick="changePage('+')">Next&gt;&gt;</button>
        </div>
    </div>
</body>
</html>

<script>
    window.onload = function() {
        document.getElementById("user").innerHTML = user;
        console.log(studentList);
        displayContent();
    }
    
    function displayContent() {
        var target = document.getElementById("target");
        target.innerHTML = "";

        let tempDiv = studentDivTemplate.cloneNode(true);
        tempDiv.childNodes[0].innerHTML = "Sl No.";
        tempDiv.childNodes[1].innerHTML = "Student";
        tempDiv.childNodes[2].innerHTML = "Email";
        tempDiv.childNodes[3].innerHTML = "Phone No./(Parent)";
        tempDiv.childNodes[4].innerHTML = "Details";
        tempDiv.childNodes[5].innerHTML = "Approve";
        let inp = document.createElement("INPUT");
        inp.setAttribute("type", "checkbox");
        inp.setAttribute("onclick", "checkAll()");

        tempDiv.childNodes[5].appendChild(inp);
        tempDiv.classList.add("title-container");
        target.appendChild(tempDiv);
        
        for(let x=(currentPage-1)*studentsPerPage; 
                x<(currentPage*studentsPerPage) && x<studentList.length; 
                x++) {
            let div = studentDivTemplate.cloneNode(true);
            
            let btn = div.childNodes[5].childNodes[1];
            if(studentList[x].is_whatsapp == 1) {
                btn.setAttribute('onclick', "sendWhatsAppMsg(this, '"+studentList[x].name+"', '"+studentList[x].phone+"')");
            } else {
                btn.style.display="none";
            }

            div.id = studentList[x].email;
            div.childNodes[0].innerHTML = studentList[x].sl_no;

            var nameStr = "<b>"+studentList[x].name+"</b>";
            if(studentList[x].parent_name)
                nameStr += "<br>Parent: "+studentList[x].parent_name;
            if(studentList[x].address)
                nameStr += "<br>Address: "+studentList[x].address;
            div.childNodes[1].innerHTML = nameStr;

            div.childNodes[2].innerHTML = studentList[x].email;
            
            var phoneStr = studentList[x].phone;
            if(studentList[x].parent_phone) 
                phoneStr += "<br>"+studentList[x].parent_phone+"(P)";
            div.childNodes[3].innerHTML = phoneStr;
            
            var syl = `<b>Syllabus: </b> ${sylbabus[studentList[x].syllabus]}`;
            if(studentList[x].keam == "1")
                syl += "<br>KEAM";
            if(studentList[x].jee == "1")
                syl += "<br>JEE";
            div.childNodes[4].innerHTML = syl;

            if(studentList[x].approval_status == "1") {
                div.style.backgroundColor = "rgba(93, 93, 93, 0.568)";
            }

            div.childNodes[5].childNodes[0].setAttribute("value", studentList[x].email);
            target.appendChild(div);
        }
    }

    function changePage(str) {
        if(str == '+') {
            if(currentPage<Math.ceil(studentList.length/studentsPerPage))
                currentPage++;
        }
        else 
            if(currentPage>1)
                currentPage--;
        console.log(currentPage);
        displayContent();
    }

    var flag = false;
    function checkAll() {
        if(!flag) 
            flag = true;
        else 
            flag = false;
        
        for(let x=(currentPage-1)*studentsPerPage; 
                x<(currentPage*studentsPerPage) && x<studentList.length; 
                x++) {
            document.getElementById(studentList[x].email).childNodes[5].childNodes[0].checked = flag;
        }
    }

    function submitApproval() {
        let arr = [];
        arr.length = 0;
        for(let x=(currentPage-1)*studentsPerPage; 
                x<(currentPage*studentsPerPage) && x<studentList.length; 
                x++) {
            if(document.getElementById(studentList[x].email).childNodes[5].childNodes[0].checked)
                    arr.push([studentList[x].name, studentList[x].phone, studentList[x].email]);
        }
        console.log(arr);

        var xhr = new XMLHttpRequest(),
            x = JSON.stringify(arr);
        console.log(x);
        xhr.open('GET', 'approveStudents.php?&arr='+x, true);
        xhr.onreadystatechange = function() {
            if(xhr.readyState == 4 && xhr.status == 200) {
                console.log(xhr.responseText);
                window.location = "students-registered.php";
            }
        }
        xhr.send(x);
    }

    function sendWhatsAppMsg(event, name, phone) {
        console.log(name+ " "+ phone);
        var msg = `Dear ${name},
You have registered successfully for the Engineering Entrance Mock Examination by MBC College of Engineering and Technology, Peermade. Your login credentials will be mailed soon. 
For more details please contact +91-7559933571.`;
        msg = encodeURI(msg);
        
        const url = "http://api.whatsapp.com/send?phone=+91"+phone+"&text="+msg;
        // console.log(url);
        window.open(url);
    }
</script>