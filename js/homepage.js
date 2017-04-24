var ctx;
var canvas;
var buttonAudio;
var backgroundAudio;
var backgroundImage;
var achvButton;
var scoreButton;
var aboutButton;
var soundButton;

var playClicked;
//achievement
var firstAward = 0;
var secondAward = 0;
var thirdAward = 0;
var fourthAward = 0;
//play button
var buttonX = 62;
var buttonY = 395;
var buttonWidth = 192;
var buttonHeight = 52;
//achievement button
var achvButtonX = 62;
var achvButtonY = 140;
var achvButtonWidth = 95;
var achvButtonHeight = 95;
//sound button
var soundButtonX = 162;
var soundButtonY = 240;
var soundButtonWidth = 95;
var soundButtonHeight = 95;
//about button
var aboutButtonX = 62;
var aboutButtonY = 240;
var aboutButtonWidth = 95;
var aboutButtonHeight = 95;
//score button
var scoreButtonX = 162;
var scoreButtonY = 140;
var scoreButtonWidth = 95;
var scoreButtonHeight = 95;

var soundAble = true;
var numClickSound = 0;

//onload function
function onloadPage() {
    canvas = document.getElementById("myCav");
    ctx = canvas.getContext("2d");
    //background image;
    backgroundImage = new Image();
    backgroundImage.src = "image/background0.gif";
    ctx.drawImage(backgroundImage, 0, 0);
    //game name
    gameName = new Image();
    gameName.src = "image/gameName.png";

    //magic card pictures
    achvButton = new Image();
    achvButton.src = "image/achievement.png";

    scoreButton = new Image();
    scoreButton.src = "image/score.png";

    //about button
    aboutButton = new Image();
    aboutButton.src = "image/info.png";


    //sound button
    soundButton = new Image();
    soundButton.src = "image/ssound.png";
    nosoundButton = new Image();
    nosoundButton.src = "image/nossound.png";

    //play button
    playButton = new Image();
    playButton.src = "image/playButton.png";
    playClicked = new Image();
    playClicked.src = "image/playClicked.png";

    //background audio
    backgroundAudio = new Audio("sounds/homeBg.mp3");
    backgroundAudio.loop = true;
    backgroundAudio.volume = .25;
    backgroundAudio.load();
    backgroundAudio.play();
    //button audio
    buttonAudio = new Audio("sounds/buttonClick.mp3");
    buttonAudio.loop = false;
    buttonAudio.volume = .55;
    buttonAudio.load();
    checkAudioImage = setInterval(function () {
        checkReadyState();
    }, 1000);

    setCookie("soundCookie", soundAble, 365);

    firstAward = getCookie('3000score');
    secondAward = getCookie('5000score');
    thirdAward = getCookie('pass10Level');
    fourthAward = getCookie('fullScore');
    if (firstAward == 1) {
        document.getElementById("3000score").src = "image/2000Score1.png";
    }
    if (secondAward == 1) {
        document.getElementById("5000score").src = "image/4000Score1.png";
    }
    if (thirdAward == 1) {
        document.getElementById("pass10Level").src = "image/allLevel1.png";
    }
    if (fourthAward == 1) {
        document.getElementById("fullScore").src = "image/fullScore1.png";
    }
}

function checkReadyState() {
    if (backgroundAudio.readyState == 4 && buttonAudio.readyState == 4 && backgroundImage.complete && achvButton.complete && scoreButton.complete && aboutButton.complete && soundButton.complete && nosoundButton.complete && document.getElementById("backButton").complete) {
        checkAudioImage = clearInterval(checkAudioImage);
        document.getElementById('loading').style.display = "none";
        ctx.drawImage(gameName, 15, 40);
        ctx.drawImage(achvButton, achvButtonX, achvButtonY);
        ctx.drawImage(scoreButton, scoreButtonX, scoreButtonY);
        ctx.drawImage(aboutButton, aboutButtonX, aboutButtonY);
        ctx.drawImage(soundButton, soundButtonX, soundButtonY);
        ctx.drawImage(playButton, buttonX, buttonY);
        //ctx.drawImage(soundButton, soundButtonX, soundButtonY);

        //button listener
        canvas.addEventListener('click', clickButton, false);

    }
}

function clickButton(ev) {
    var rect = canvas.getBoundingClientRect();
    var myX = ev.clientX - rect.left;
    var myY = ev.clientY - rect.top;

    //click play button
    if (myX > buttonX && myX < (buttonX + buttonWidth) && myY > buttonY && myY < (buttonY + buttonHeight)) {
        if (soundAble) buttonAudio.play();
        ctx.drawImage(playClicked, buttonX, buttonY);
        setTimeout(function () {
            window.location.href = "rulesPage.html"
        }, 500);
        //setTimeout(function(){window.location.href="rulesPage.html?sound="+soundAble;},500);
    }

    //click the sound button image
    if (myX > soundButtonX && myX < (soundButtonX + soundButtonWidth) && myY > soundButtonY && myY < (soundButtonY + soundButtonHeight)) {
        numClickSound++;
        if (numClickSound % 2 == 1) {
            backgroundAudio.pause();

            soundAble = false;
            setCookie("soundCookie", soundAble, 365);
            ctx.drawImage(nosoundButton, soundButtonX, soundButtonY);

        } else {
            soundAble = true;
            backgroundAudio.play();
            setCookie("soundCookie", soundAble, 365);
            ctx.drawImage(soundButton, soundButtonX, soundButtonY);
        }
    }

    //click about button image
    if (myX > aboutButtonX && myX < (aboutButtonX + aboutButtonWidth) && myY > aboutButtonY && myY < (aboutButtonY + aboutButtonHeight)) {
        if (soundAble) buttonAudio.play();
        document.getElementById('about').style.display = 'block';
    }
    //click score button image
    if (myX > scoreButtonX && myX < (scoreButtonX + scoreButtonWidth) && myY > scoreButtonY && myY < (scoreButtonY + scoreButtonHeight)) {
        if (soundAble) buttonAudio.play();
        document.getElementById('scorePage').style.display = 'block';
    }
    //click achievement button image
    if (myX > achvButtonX && myX < (achvButtonX + achvButtonWidth) && myY > achvButtonY && myY < (achvButtonY + achvButtonHeight)) {
        if (soundAble) buttonAudio.play();
        document.getElementById('achvPage').style.display = 'block';
    }

}

function setCookie(cookieName, cookieValue, expireDays) {
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + expireDays);
    document.cookie = cookieName + "=" + escape(cookieValue) +
        ((expireDays == null) ? "" : ";expires=" + exdate.toGMTString());
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
