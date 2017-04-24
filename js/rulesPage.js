var ctx;
var canvas;
var buttonAudio;
var backgroundAudio;
var startButton;
var startClicked;
var soundAble = true;

function onloadPage() {
    canvas = document.getElementById("myCav");
    ctx = canvas.getContext("2d");
    //background image;
    backgroundImage = new Image();
    backgroundImage.src = "image/background0.gif";
    ctx.drawImage(backgroundImage, 0, 0);
    checkAudioImage = setInterval(function () {
        checkReadyState();
    }, 1000);

    //start button
    buttonX = 70;
    buttonY = 390;
    buttonWidth = 192;
    buttonHeight = 52;
    startButton = new Image();
    startButton.src = "image/startButton.png";
    startClicked = new Image();
    startClicked.src = "image/startClicked.png";

    soundAble = (getCookie("soundCookie") == "true") ? true : false;
    //background audio
    backgroundAudio = new Audio("sounds/homeBg.mp3");
    backgroundAudio.loop = true;
    backgroundAudio.volume = .25;
    backgroundAudio.load();
    if (soundAble) {
        backgroundAudio.play();
    } else {
        backgroundAudio.pause();
    }

    //button audio
    buttonAudio = new Audio("sounds/buttonClick.mp3");
    buttonAudio.loop = false;
    buttonAudio.volume = .55;
    buttonAudio.load();

}

function checkReadyState() {
    if (backgroundAudio.readyState == 4 && buttonAudio.readyState == 4 && backgroundImage.complete && startButton.complete && document.getElementById("bombInstruction").complete) {
        checkAudioImage = clearInterval(checkAudioImage);
        document.getElementById('loading').style.display = "none";
        document.getElementById('rules').style.display = "block";
        ctx.drawImage(startButton, buttonX, buttonY);

        //button listener
        canvas.addEventListener('click', clickButton, false);

    }
}

function clickButton(ev) {
    var rect = canvas.getBoundingClientRect();
    var myX = ev.clientX - rect.left;
    var myY = ev.clientY - rect.top;

    if (myX > buttonX && myX < (buttonX + buttonWidth) && myY > buttonY && myY < (buttonY + buttonHeight)) {
        if (soundAble) buttonAudio.play();
        ctx.drawImage(startClicked, buttonX, buttonY);
        setTimeout(function () {
            window.location.href = "game.html";
        }, 500);
    }

}

function getCookie(cookieName) {
    if (document.cookie.length > 0) {
        cookieStart = document.cookie.indexOf(cookieName + "=");
        if (cookieStart != -1) {
            cookieStart = cookieStart + cookieName.length + 1;
            cookieEnd = document.cookie.indexOf(";", cookieStart);
            if (cookieEnd == -1) cookieEnd = document.cookie.length;
            return unescape(document.cookie.substring(cookieStart, cookieEnd));
        }
    }
    return "";
}