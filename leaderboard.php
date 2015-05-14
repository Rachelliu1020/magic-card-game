<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Magic Cards/leaderboard</title>
<link rel="stylesheet" href="game.css">
<script>
var ctx; 
var canvas; 
var buttonAudio;
var backgroundAudio;
var startButton;
var startClicked;
var soundAble=true;

function onloadPage(){
	canvas = document.getElementById("myCav");
	ctx = canvas.getContext("2d");
	//background image;
    backgroundImage=new Image();
	backgroundImage.src="image/background0.png";
	ctx.drawImage(backgroundImage, 0, 0);
	checkAudioImage = setInterval(function(){checkReadyState();},1000);
 
	//start button
	buttonX=100;
	buttonY=420;
	buttonWidth=128;
	buttonHeight=41;
	startButton=new Image();
	startButton.src="image/backButton.png";
	startClicked=new Image();
	startClicked.src="image/backClicked.png";
	
	//pause soundAble in URL
	//soundAble=decodeURIComponent(location.search.substr(location.search.indexOf("sound=")+6));
	//soundAble=((soundAble=="true"||soundAble=="")? true :false);
	soundAble=((getCookie("soundCookie")=="true")? true :false);
	//background audio
	backgroundAudio = new Audio("sounds/homeBg.wav");
	backgroundAudio.loop = true;
	backgroundAudio.volume = .25;
	backgroundAudio.load();
	if(soundAble){
		backgroundAudio.play();
	}else{
		backgroundAudio.pause();
	}
	
	//button audio 
	buttonAudio = new Audio("sounds/buttonClick.wav");
	buttonAudio.loop = false;
	buttonAudio.volume = .55;
	buttonAudio.load();
	
}


function checkReadyState() {
	if ( backgroundAudio.readyState==4 && buttonAudio.readyState == 4 && backgroundImage.complete && startButton.complete) {
		checkAudioImage=clearInterval(checkAudioImage);
		document.getElementById('loading').style.display = "none";
		document.getElementById('rankArea').style.display = "block";
		ctx.drawImage(startButton, buttonX, buttonY);
		
		//button listener
		canvas.addEventListener('click', clickButton, false);

	}
}
function clickButton(ev){
var myX; 
var myY; 

// Firefox
if (ev.layerX || ev.layerX == 0) {  
myX = ev.layerX; 
myY = ev.layerY; 
// Opera
} else if (ev.offsetX || ev.offsetX == 0) {  
myX = ev.offsetX; 
myY = ev.offsetY; 
} 
if (myX > buttonX && myX < (buttonX + buttonWidth) && myY > buttonY && myY < (buttonY + buttonHeight)) 
		{ 
	if(soundAble) buttonAudio.play();
	ctx.drawImage(startClicked, buttonX, buttonY);
	setTimeout(function(){window.location.href="game.html";},500);
	//setTimeout(function(){window.location.href="game.html?sound="+soundAble;},500);
	
	}

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
<!--no display image-->
<div id="images">
<img src="image/rulesBackground.png" alt="rule background shadow" width="30" height="30">
<img src="image/backButton.png" alt="back button" width="30" height="30">
<img src="image/background0.png" alt="background image" width="320" height="480">
</div>

<!--loading page-->
<div id="loading">LOADING...<br><br>Please wait</div>

<!--rules sentences-->
<div id="rankArea">



<?php

	//Start session
	session_start();
	
	//Include database connection details
	require_once('config.php');

	//Array to store validation errors
	$errmsg_arr = array();
	
	//Validation error flag
	$errflag = false;
	
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
	
	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
			
	//Sanitize the POST values
	if(isset($_POST["submit"])){
	$userName = clean($_POST["userName"]);
	if($userName=="")$userName ="Guest";
	$userScore =$_COOKIE['scoreCookie'];
	$datetime=date("d/m/y h:i:s"); //create date time
	
	//Create INSERT query
	$qry = "INSERT INTO leaderboard(user_name, user_score, datetime) VALUES('$userName','$userScore','$datetime')";
	
	$result = @mysql_query($qry);
	
	}
	//Check whether the query was successful or not
	if($result) {
		$qryScore="SELECT * FROM leaderboard ORDER by user_score DESC, datetime ASC";
		$resultScore=mysql_query($qryScore);
		$result_length = mysql_num_rows($resultScore);
		$_SESSION['SESS_PLAYER_ID']=$result_length;
		$lastScore=0;
		$counter=0;
?>
<div id="tableArea2">
<table border="0" align="center" bgcolor="#CCCCCC">
<caption style="font-size:20px;font-weight:bold;margin-top:10px;">World's highest Scores</caption>
<tr>
<td align="center" bgcolor="#E6E6E6"><strong>Rank</strong></td>
<td align="center" bgcolor="#E6E6E6"><strong>Name</strong></td>
<td align="center" bgcolor="#E6E6E6"><strong>Score</strong></td>
</tr>

<?php
	for($i = 1; $i <= $result_length; $i++){
		$counter++;
		 $row = mysql_fetch_array($resultScore);
		 
		 if($row['user_score']==$lastScore){$i--;}
		 
		 //update rank_num
		$sql = "UPDATE leaderboard SET rank_num='".$i."' where id='".$row['id']."'";
		mysql_query($sql);
		//$result=mysql_query("SELECT * FROM members WHERE id='".$_SESSION['SESS_MEMBER_ID']."'");//SQL
		
		if($counter<15||$counter==15){	 
		 //echo "<tr><tb>"$i."</tb><tb>".$row['user_name'] . "</tb><tb>" . $row['user_score'] . "</tb></tr>";
?>

<tr>
<td align="center" bgcolor="#FFFFFF"><?php echo $i; ?></td>
<td align="center" bgcolor="#FFFFFF"><?php echo $row['user_name']; ?></td>
<td align="center" bgcolor="#FFFFFF"><?php echo $row['user_score']; ?></td>
</tr>

<?php
       }
		 $lastScore=$row['user_score'];
	}
	?>
	</table>
	</div>
	<?php
	$resultID=mysql_query("SELECT * FROM leaderboard WHERE id='".$_SESSION['SESS_PLAYER_ID']."'");//SQL
	if($resultID) {
			$row = mysql_fetch_array($resultID);
			echo "<p>Your Rank: ".$row['rank_num']."&nbsp;&nbsp;".$row['user_name']. "&nbsp;&nbsp;".$row['user_score']."</p>";
		
	}
		//echo "<script>document.getElementById('submitScore').style.display='none'; window.history.go(-1);</script>";
		unset($_POST["submit"]);
		unset($_POST["userName"]);
		//unset($_SESSION['scoreSES']);
		unset($_COOKIE['scoreCookie']);
		mysql_close();
		exit();
	}else {
		die("Query failed");
	}
	
?>

</div>
</body>

</html>