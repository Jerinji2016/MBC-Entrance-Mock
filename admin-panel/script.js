//  Div template for each child
var studentHtmlTemplate = document.createElement("DIV"), studentPerLoad = 10, page = 0, questionNo = 10;
studentHtmlTemplate.setAttribute("class", "student");

//Create child element
var slno, userDetails, timeDetails, marksDetails, examStatus, totalDetails;
slno = document.createElement("DIV");
userDetails = document.createElement("DIV");
timeDetails = document.createElement("DIV");
marksDetails = document.createElement("DIV");
examStatus = document.createElement("DIV");
totalDetails = document.createElement("DIV");

//Add class to all child
slno.setAttribute("class", "slno");
userDetails.setAttribute("class", "user-details");
timeDetails.setAttribute("class", "time-details");
marksDetails.setAttribute("class", "marks-details");
totalDetails.setAttribute("class", "total-details");
examStatus.setAttribute("class", "exam-status");

//  Append all childs
studentHtmlTemplate.appendChild(slno);
studentHtmlTemplate.appendChild(userDetails);
studentHtmlTemplate.appendChild(timeDetails);
studentHtmlTemplate.appendChild(marksDetails);
studentHtmlTemplate.appendChild(totalDetails);
studentHtmlTemplate.appendChild(examStatus);

fetchList();

function fetchList() {
    var target = document.getElementById('result-list-target');
    target.innerHTML = "";
    console.log(studentList.length);

    let count = 1;
    for(var i=(page*studentPerLoad); (i<studentList.length && i<((page+1)*studentPerLoad)); i++) {
        let v = "time"
        // console.log(studentList[i]);
        temp = studentHtmlTemplate.cloneNode(true);
        // console.log(temp, typeof(temp));

        temp.setAttribute("id", studentList[i].userID);
        if(count%2 === 0)
            temp.classList.add("even");
        else
            temp.classList.add("odd"); 
    
        //  Sl No Div
        temp.childNodes[0].innerHTML = count;
        count++;
        //  User Details Div
        temp.childNodes[1].innerHTML = `
        <table>
            <tr>
                <td> Name </td>
                <td> : </td>
                <td> ${studentList[i].name} </td>
            </tr>
            <tr>
                <td> User ID </td>
                <td> : </td>
                <td> ${studentList[i].userID} </td>
            </tr>
        </table>`;    

        //  Time details Div
        temp.childNodes[2].setAttribute("id", "time"+studentList[i].userID);
        createChart(i, "time", temp.childNodes[2]).render();

        //  Marks Details Div
        temp.childNodes[3].setAttribute("id", "mark"+studentList[i].userID);
        createChart(i, "marks", temp.childNodes[3]).render();
        
        //  Total details Div
        var totalMarks = studentList[i].marks.physics + studentList[i].marks.chemistry + studentList[i].marks.maths + studentList[i].marks.gk;
        var totalTime = studentList[i].time.physics + studentList[i].time.chemistry + studentList[i].time.maths + studentList[i].time.gk;
        
        temp.childNodes[4].innerHTML = `
        <table>
            <tr>
                <td> Total time </td>
                <td> : </td>
                <td> ${parseInt(totalTime / 60, 10)}m ${parseInt(totalTime % 60, 10)}s </td>
            </tr>
            <tr>
                <td> Total marks </td>
                <td> : </td>
                <td> ${totalMarks} </td>
            </tr>
        </table>`;
        
        //  Exam Status Div
        temp.childNodes[5].innerHTML = `<div class="status-circle"></div>`;
        if(studentList[i].examStatus == 1) {
            temp.childNodes[5].childNodes[0].style.backgroundColor = "red";
            temp.childNodes[5].childNodes[0].style.borderColor = "red";
            temp.childNodes[5].childNodes[0].setAttribute("title", "Incomplete");
        }
        else 
        temp.childNodes[5].childNodes[0].setAttribute("title", "Completed Exam")

        //Append the child
        // console.log(temp);
        target.appendChild(temp);  
    }
}

function createChart(i, thing, target) {
    var t = (thing == "time")? "Time" : "Marks";
    var fs = (thing == "time")? "###0\"s\"" : "###0\"/"+questionNo+"\"";
    // console.log(target);
    var chart = new CanvasJS.Chart(target, {
        theme: "light2",
        animationEnabled: true,
        height: 100,
        width: 150,
        backgroundColor : "transparent",
        data: [{
            type: "pie",
            indexLabelFontSize: 10,
            radius: 30,
            yValueFormatString: fs,
            click: explodePie,
            dataPoints: [
                { y: studentList[i][thing].physics, label: "Physics " + thing },
                { y: studentList[i][thing].chemistry, label: "Chemistry " + thing },
                { y: studentList[i][thing].maths, label: "Maths " + thing },
                { y: studentList[i][thing].gk, label: "GK " + thing }
            ]
        }]
    });
    return chart;
}

function explodePie(e) {
	for(var i = 0; i < e.dataSeries.dataPoints.length; i++) {
		if(i !== e.dataPointIndex)
			e.dataSeries.dataPoints[i].exploded = false;
	}
}

function pageChange(str) {
    if(str === '+') {
        if((page+1) < Math.ceil(noStudents/studentPerLoad)) {
            page++;
            fetchList();
        }
    }
    else {
        if(page > 0 ) {
            page--;
            fetchList();
        }
    }
}