 <!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Magic Cards/homepage</title>
<link rel="stylesheet" href="game.css" media="only all and (min-width:320px)">
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<script>
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
var firstAward=0;
var secondAward=0;
var thirdAward=0;
var fourthAward=0;
//play button 
var buttonX=62;
var buttonY=395;
var buttonWidth=192;
var buttonHeight=52;
//achievement button
var achvButtonX=62;
var achvButtonY=140;
var achvButtonWidth=95;
var achvButtonHeight=95;
//sound button
var soundButtonX=162;
var soundButtonY=240;
var soundButtonWidth=95;
var soundButtonHeight=95;
//about button
var aboutButtonX=62;
var aboutButtonY=240;
var aboutButtonWidth=95;
var aboutButtonHeight=95;
//score button
var scoreButtonX=162;
var scoreButtonY=140;
var scoreButtonWidth=95;
var scoreButtonHeight=95;

var soundAble=true;
var numClickSound=0;
//onload function
function onloadPage(){
	canvas = document.getElementById("myCav");
	ctx = canvas.getContext("2d");
	//background image;
    backgroundImage=new Image();
	backgroundImage.src="image/background0.gif";
	ctx.drawImage(backgroundImage, 0, 0);
	//game name
	gameName=new Image();
	gameName.src="image/gameName.png";
	 
	//magic card pictures
	achvButton=new Image();
	achvButton.src="image/achievement.png";

	scoreButton=new Image();
	scoreButton.src="image/score.png";
	
	//about button
	aboutButton=new Image();
	aboutButton.src="image/info.png";
	
	
    //sound button
	soundButton=new Image();
	soundButton.src="image/ssound.png";
	nosoundButton=new Image();
	nosoundButton.src="image/nossound.png";
	
	//play button
	playButton=new Image();
	playButton.src="image/playButton.png";
	playClicked=new Image();
	playClicked.src="image/playClicked.png";
	 
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
	checkAudioImage = setInterval(function(){checkReadyState();},1000);
	
	setCookie("soundCookie",soundAble,365);
	
	firstAward=getCookie('3000score');
	secondAward=getCookie('5000score');
	thirdAward=getCookie('pass10Level');
	fourthAward=getCookie('fullScore');
	if(firstAward==1){
		document.getElementById("3000score").src="image/2000Score1.png";	
	}	
	if(secondAward==1){
		document.getElementById("5000score").src="image/4000Score1.png";	
	}
	if(thirdAward==1){
		document.getElementById("pass10Level").src="image/allLevel1.png";	
	}
	if(fourthAward==1){
		document.getElementById("fullScore").src="image/fullScore1.png";	
	}
}
function checkReadyState() {
	if ( backgroundAudio.readyState==4 && buttonAudio.readyState == 4 && backgroundImage.complete && achvButton.complete && scoreButton.complete && aboutButton.complete && soundButton.complete && nosoundButton.complete&&document.getElementById("backButton").complete) {
		checkAudioImage=clearInterval(checkAudioImage);
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
function clickButton(ev){
var myX; 
var myY; 

if (ev.layerX || ev.layerX == 0) { // Firefox 
myX = ev.layerX; 
myY = ev.layerY; 
} else if (ev.offsetX || ev.offsetX == 0) { // Opera 
myX = ev.offsetX; 
myY = ev.offsetY; 
} 
//click play button
if (myX > buttonX && myX < (buttonX + buttonWidth) && myY > buttonY && myY < (buttonY + buttonHeight)) 
		{ 
	if(soundAble) buttonAudio.play();
	ctx.drawImage(playClicked, buttonX, buttonY);
	setTimeout(function(){window.location.href="rulesPage.html"},500);
	//setTimeout(function(){window.location.href="rulesPage.html?sound="+soundAble;},500);
	}
	
//click the sound button image
if(myX > soundButtonX && myX < (soundButtonX + soundButtonWidth) && myY > soundButtonY && myY < (soundButtonY + soundButtonHeight)){
numClickSound++;
if(numClickSound%2==1){
backgroundAudio.pause();

soundAble=false;
setCookie("soundCookie",soundAble,365);
ctx.drawImage(nosoundButton, soundButtonX, soundButtonY);

}else{
soundAble=true;
backgroundAudio.play();
setCookie("soundCookie",soundAble,365);
ctx.drawImage(soundButton, soundButtonX, soundButtonY);
}

}
//click about button image
if (myX > aboutButtonX && myX < (aboutButtonX + aboutButtonWidth) && myY > aboutButtonY && myY < (aboutButtonY + aboutButtonHeight)){ 
	if(soundAble) buttonAudio.play();
	document.getElementById('about').style.display='block';
	}
	//click score button image
if (myX > scoreButtonX && myX < (scoreButtonX + scoreButtonWidth) && myY > scoreButtonY && myY < (scoreButtonY + scoreButtonHeight)){ 
	if(soundAble) buttonAudio.play();
	document.getElementById('scorePage').style.display='block';
	}
		//click achievement button image
if (myX > achvButtonX && myX < (achvButtonX + achvButtonWidth) && myY > achvButtonY && myY < (achvButtonY + achvButtonHeight)){ 
	if(soundAble) buttonAudio.play();
	document.getElementById('achvPage').style.display='block';
	}
	
}


function setCookie(cookieName,cookieValue,expireDays){
	var exdate=new Date();
	exdate.setDate(exdate.getDate()+expireDays);
	document.cookie=cookieName+ "=" +escape(cookieValue)+
	((expireDays==null) ? "" : ";expires="+exdate.toGMTString());
}
function getCookie(cookieName){
	if (document.cookie.length>0)
	{
		cookieStart=document.cookie.indexOf(cookieName + "=");
		if (cookieStart!=-1)
		{
			cookieStart=cookieStart + cookieName.length+1;
			cookieEnd=document.cookie.indexOf(";",cookieStart);
			if (cookieEnd==-1) cookieEnd=document.cookie.length;
			return unescape(document.cookie.substring(cookieStart,cookieEnd));
		}
	}
	return "";
}
</script>
</head>

<body onload="onloadPage()">

<canvas id="myCav" width="320" height="480"
        style="border:1px solid #c3c3c3;">
Your browser does not support the canvas element.
</canvas>

<div id="images">
<img src="image/background0.gif" alt="background image" width="320" height="480">
<img src="image/gameName.png" alt="game name" width="30" height="30">
<img src="image/homepage_icon105.png" alt="card example" width="30" height="30">
<img src="image/homepage_icon118.png" alt="card example" width="30" height="30">
<img src="image/homepage_iconbomb1.png" alt="card example" width="30" height="30">
<img src="image/homepage_icon124.png" alt="card example" width="30" height="30">
<img src="image/playButton.png" alt="play button" width="30" height="30">
</div>


<div id="loading">LOADING...<br><br>Please wait</div>



<!--about page-->
<div id="about">
<div id="aboutContent">
<p style="font-weight:bold; font-size:25px;padding-top:12px;margin-bottom:0;">
About
</p> 
<p>
Magic Card<br>
Version 1.5.7<br>
Coryright &copy; 2015 Magician.
</p>
<p>
Project Manager:<br>
Cui Liu
</p>
<p>
Lead Programmer:<br>
Rui Liu
</p>
<p>
Programmers:<br>
Jing Yang<br>
Kwanchanok Sonsoi
</p>
<p>
Graphic Designer:<br>
Lingzhu Yu
</p>
<p>
magician0015@gmail.com
</p>
</div>

<img class="backButton" id="backButton" src="image/backButton.png" alt="no button" width="128" height="41" onclick="if (soundAble) buttonAudio.play(); document.getElementById('backButton').src='image/backClicked.png';
   setTimeout(function(){
		document.getElementById('about').style.display='none';
		document.getElementById('backButton').src='image/backButton.png';
				},500);">
</div>

<!--score page-->
<div id="scorePage">
<?php
	//Include database connection details
	require_once('config.php');

	//Connect to mysql server
	$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
	if(!$link) {
		die('Failed to connect to server: ' . mysql_error());
	}
	
	//Select database
	$db = mysql_select_db(DB_DATABASE);
	if(!$db) {
		die("Unable to select database");
	}
	//rank query , datetime ASC
		$qryScore="SELECT * FROM leaderboard ORDER by user_score DESC";
		$resultScore=mysql_query($qryScore);
		$result_length = mysql_num_rows($resultScore);
?>
<div id="tableArea">
<table border="0" align="center" bgcolor="#CCCCCC">
<caption style="font-size:20px;font-weight:bold;margin-top:15px;margin-bottom:5px;">World's highest Scores</caption>
<tr>
<td align="center" bgcolor="#E6E6E6"><strong>Rank</strong></td>
<td align="center" bgcolor="#E6E6E6"><strong>Name</strong></td>
<td align="center" bgcolor="#E6E6E6"><strong>Score</strong></td>
</tr>

<?php
	$i = 1;
	while($row = mysql_fetch_array($resultScore)){
		
		if($i<15||$i==15){	 
?>

<tr>
<td align="center" bgcolor="#FFFFFF"><?php echo $i; ?></td>
<td align="center" bgcolor="#FFFFFF"><?php echo $row['user_name']; ?></td>
<td align="center" bgcolor="#FFFFFF"><?php echo $row['user_score']; ?></td>
</tr>

<?php
       }		 
		 $i++;
	}
?>
</table>
</div>

<img class="backButton" id="backButton2" src="image/backButton.png" alt="no button" width="128" height="41" onclick="if (soundAble) buttonAudio.play(); document.getElementById('backButton2').src='image/backClicked.png';
   setTimeout(function(){
		document.getElementById('scorePage').style.display='none';
		document.getElementById('backButton2').src='image/backButton.png';
				},500);">
</div>



<!--achievement page-->
<div id="achvPage">
<div id="achvContent">
<p style="font-size:26px;font-weight:bold;margin-top: 8px;margin-bottom: 18px;padding-bottom: 0px;">Achievements</p>
<img id="fullScore" src="image/fullScore0.png" alt="full score" width="74" height="75"><div class="achvExplain"><div id="title">Unbelievably Fast!</div><div id="content">Get full score: 8050</div></div>
<img id="pass10Level" src="image/allLevel0.png" alt="pass 10 level" width="74" height="75"><div class="achvExplain"><div id="title">The Secret of Memory.</div><div id="content">Passed all 10 levels</div></div>
<img id="5000score" src="image/4000Score0.png" alt="5000 score" width="74" height="75"><div class="achvExplain"><div id="title">Breakthrough!</div><div id="content">Get 4000 points</div></div>
<img id="3000score" src="image/2000Score0.png" alt="3000 score" width="74" height="75" ><div class="achvExplain"><div id="title">You Got It!</div><div id="content">Get 2000 points</div></div>
</div>
<img class="backButton" id="backButton3" src="image/backButton.png" alt="no button" width="128" height="41" onclick="if (soundAble) buttonAudio.play(); document.getElementById('backButton3').src='image/backClicked.png';
   setTimeout(function(){
		document.getElementById('achvPage').style.display='none';
		document.getElementById('backButton3').src='image/backButton.png';
				},500);">
</div>

</body>

</html>