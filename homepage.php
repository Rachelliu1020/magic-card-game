 <!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Magic Cards/homepage</title>
<link rel="stylesheet" href="game.css" media="only all and (min-width:320px)">
<script>
var ctx; 
var canvas; 
var buttonAudio;
var backgroundAudio;
var backgroundImage;
var pic1;
var scoreButton;
var aboutButton;
var soundButton;

var playClicked;
//play button 
var buttonX=62;
var buttonY=395;
var buttonWidth=192;
var buttonHeight=52;
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
	pic1=new Image();
	pic1.src="image/bomb.png";

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
}
function checkReadyState() {
	if ( backgroundAudio.readyState==4 && buttonAudio.readyState == 4 && backgroundImage.complete && pic1.complete && scoreButton.complete && aboutButton.complete && soundButton.complete && nosoundButton.complete&&document.getElementById("backButton").complete) {
		checkAudioImage=clearInterval(checkAudioImage);
		document.getElementById('loading').style.display = "none";
		ctx.drawImage(gameName, 15, 40);
		ctx.drawImage(pic1, 62, 140);
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
}


function setCookie(cookieName,cookieValue,expireDays){
	var exdate=new Date();
	exdate.setDate(exdate.getDate()+expireDays);
	document.cookie=cookieName+ "=" +escape(cookieValue)+
	((expireDays==null) ? "" : ";expires="+exdate.toGMTString());
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
Version 1.1.5<br>
Coryright &copy; 2015 Magician.
</p>
<p>
Project Magager:<br>
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
		$lastScore=0;
		$counter=0;
?>
<div id="tableArea">
<table border="0" align="center" bgcolor="#CCCCCC">
<caption style="font-size:20px;font-weight:bold;margin-top:10px;">World's highest Scores</caption>
<tr>
<td align="center" bgcolor="#E6E6E6"><strong>Rank</strong></td>
<td align="center" bgcolor="#E6E6E6"><strong>Name</strong></td>
<td align="center" bgcolor="#E6E6E6"><strong>Score</strong></td>
</tr>

<?php
	$i = 1;
	while($row = mysql_fetch_array($resultScore)){
		$counter++;
		
		 
		if($row['user_score']==$lastScore){$i--;}
		 
		if($counter<15||$counter==15){	 
?>

<tr>
<td align="center" bgcolor="#FFFFFF"><?php echo $i; ?></td>
<td align="center" bgcolor="#FFFFFF"><?php echo $row['user_name']; ?></td>
<td align="center" bgcolor="#FFFFFF"><?php echo $row['user_score']; ?></td>
</tr>

<?php
       }
		 $lastScore=$row['user_score'];
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
</body>

</html>