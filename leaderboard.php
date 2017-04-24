<?php
ob_start();
//Start session
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Magic Cards/leaderboard</title>
    <link rel="stylesheet" href="css/game.css" media="only all and (min-width:320px)">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <script src="js/leaderboard.js"></script>
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
        <img src="image/background0.gif" alt="background image" width="320" height="480">
    </div>

    <!--loading page-->
    <div id="loading">LOADING...<br><br>Please wait</div>

    <!--rank page-->
    <div id="rankArea">
        <?php
            //Include database connection details
            require_once('config.php');

            //Connect to mysql server
            $db = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysqli_connect_error());
            //Select database
            mysqli_select_db($db, DB_DATABASE) or die(mysqli_error($db));

            //Function to sanitize values received from the form. Prevents SQL injection
            function clean($db, $str)
            {
                $str = @trim($str);
                if (get_magic_quotes_gpc()) {
                    $str = stripslashes($str);
                }
                return mysqli_real_escape_string($db, $str);
            }

            //Sanitize the POST values
            if (isset($_POST["submit"])) {
                $userName = clean($db, $_POST["userName"]);
                if ($userName == "")
                    $userName = "Guest";
                $userScore = $_COOKIE['scoreCookie'];
                $datetime = date("d/m/y h:i:s"); //create date time

                //Create INSERT query
                $qry = "INSERT INTO leaderboard(user_name, user_score, datetime) VALUES('$userName','$userScore','$datetime')";
                $result = mysqli_query($db, $qry) or die(mysqli_error($db));
            }

            //Check whether the query was successful or not, user score DESC
            if ($result) {
                $qryScore = "SELECT * FROM leaderboard ORDER by user_score DESC";
                $resultScore = mysqli_query($db, $qryScore) or die(mysqli_error($db));
                $result_length = mysqli_num_rows($resultScore);
        ?>

            <div id="tableArea2">
                <table border="0" align="center" bgcolor="#CCCCCC">
                    <caption style="font-size:20px;font-weight:bold;margin-top:5px;">World's highest Scores</caption>
                    <tr>
                        <td align="center" bgcolor="#E6E6E6"><strong>Rank</strong></td>
                        <td align="center" bgcolor="#E6E6E6"><strong>Name</strong></td>
                        <td align="center" bgcolor="#E6E6E6"><strong>Score</strong></td>
                    </tr>

        <?php

                    $i = 1;
                    while ($row = mysqli_fetch_array($resultScore)) {
                        if ($row['id'] == $result_length) {
                            $_SESSION['rankNum'] = $i;
                        }

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
        <?php
            echo "<div id='userRankDisplay'><table border='0' align='center' bgcolor='#CCCCCC'><caption>Your Current Rank:</caption><tr><td align='center' bgcolor='#FFFFFF'>" . $_SESSION['rankNum'] . "</td><td align='center' bgcolor='#FFFFFF'>" . $userName . "</td><td align='center' bgcolor='#FFFFFF'>" . $userScore . "</td></tr></table></div>";
            unset($_POST["submit"]);
            unset($_POST["userName"]);
            unset($_SESSION['rankNum']);
            unset($_COOKIE['scoreCookie']);
            mysqli_close($db);
            exit();
        } else {
            die("Query failed");
        }
        ob_end_flush();
        ?>

    </div>
</body>

</html>