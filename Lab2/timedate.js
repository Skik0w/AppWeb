function gettheDate() {
    Todays = new Date();
    TheDate = "" + (Todays.getMonth() + 1) + "/" + Todays.getDate() + "/" + (Todays.getYear() - 100);
    document.getElementById("data").innerHTML = TheDate;
}
 
var timerID = null;
var timerRunning = false;
 
function stopclock() {
    if (timerRunning)
        clearTimeout(timerID);
    timerRunning = false;
}
 
function startclock() {
    stopclock();
    gettheDate();
    showtime();
    changeTimeColor();
}
 
function showtime() {
    var now = new Date();
    var hours = now.getHours();
    var minutes = now.getMinutes();
    var seconds = now.getSeconds();
    var timeValue = "" + ((hours > 12) ? hours - 12 : hours);
    timeValue += ((minutes < 10) ? ":0" : ":") + minutes;
    timeValue += ((seconds < 10) ? ":0" : ":") + seconds;
    timeValue += (hours >= 12) ? " P.M." : " A.M.";
    document.getElementById("zegarek").innerHTML = timeValue;
    timerID = setTimeout("showtime()", 1000);
    timerRunning = true;
}

function changeTimeColor() {
    var colors = ['red', 'green', 'blue', 'yellow', 'orange', 'purple', 'cyan', 'magenta'];
    var randomColor = colors[Math.floor(Math.random() * colors.length)];

    document.getElementById("data").style.color = randomColor;
    document.getElementById("zegarek").style.color = randomColor;

    setTimeout(changeTimeColor, 1000);
}