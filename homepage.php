<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Magic Cards/homepage</title>
    <link rel="stylesheet" href="game.css" media="only all and (min-width:320px)">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <script src="js/homepage.js"></script>
</head>

<body onload="onloadPage()">

    <canvas id="myCav" width="320" height="480" style="border:1px solid #c3c3c3;">
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

        <img class="backButton" id="backButton" src="image/backButton.png" alt="no button" width="128" height="41"
            onclick="if (soundAble) buttonAudio.play();
            document.getElementById('backButton').src='image/backClicked.png';
            setTimeout(function(){
                document.getElementById('about').style.display='none';
                document.getElementById('backButton').src='image/backButton.png';
            },500);
        ">
    </div>

    <!--score page-->
    <div id="scorePage">
        <?php
            //Include database connection details
            require_once('config.php');

            //Connect to mysql server
            $db = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysqli_connect_error());
            //Select database
            mysqli_select_db($db, DB_DATABASE) or die(mysqli_error($db));

            //rank query , datetime ASC
            $qryScore = "SELECT * FROM leaderboard ORDER by user_score DESC";
            $resultScore = mysqli_query($db, $qryScore) or die(mysqli_error($db));
            $result_length = mysqli_num_rows($resultScore);
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
                    while ($row = mysqli_fetch_array($resultScore)) {
                        if ($i < 15 || $i == 15) {
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

        <img class="backButton" id="backButton2" src="image/backButton.png" alt="no button" width="128" height="41"
            onclick="if (soundAble) buttonAudio.play();
            document.getElementById('backButton2').src='image/backClicked.png';
            setTimeout(function(){
                document.getElementById('scorePage').style.display='none';
                document.getElementById('backButton2').src='image/backButton.png';
            },500);
        ">
    </div>


    <!--achievement page-->
    <div id="achvPage">
        <div id="achvContent">
            <p style="font-size:26px;font-weight:bold;margin-top: 8px;margin-bottom: 18px;padding-bottom: 0px;">Achievements</p>
            <img id="fullScore" src="image/fullScore0.png" alt="full score" width="74" height="75">
            <div class="achvExplain">
                <div id="title">Unbelievably Fast!</div>
                <div id="content">Get full score: 8050</div>
            </div>
            <img id="pass10Level" src="image/allLevel0.png" alt="pass 10 level" width="74" height="75">
            <div class="achvExplain">
                <div id="title">The Secret of Memory.</div>
                <div id="content">Passed all 10 levels</div>
            </div>
            <img id="5000score" src="image/4000Score0.png" alt="5000 score" width="74" height="75">
            <div class="achvExplain">
                <div id="title">Breakthrough!</div>
                <div id="content">Get 4000 points</div>
            </div>
            <img id="3000score" src="image/2000Score0.png" alt="3000 score" width="74" height="75">
            <div class="achvExplain">
                <div id="title">You Got It!</div>
                <div id="content">Get 2000 points</div>
            </div>
        </div>
        <img class="backButton" id="backButton3" src="image/backButton.png" alt="no button" width="128" height="41"
             onclick="if (soundAble) buttonAudio.play();
             document.getElementById('backButton3').src='image/backClicked.png';
             setTimeout(function(){
                document.getElementById('achvPage').style.display='none';
                document.getElementById('backButton3').src='image/backButton.png';
             },500);
        ">
    </div>

</body>

</html>