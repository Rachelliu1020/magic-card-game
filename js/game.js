var ctx;
var canvas;
//achievement
var firstAward = 0;
var secondAward = 0;
var thirdAward = 0;
var fourthAward = 0;
//set the number of bomb and magic cards
var numBomb = 1;
var numMCard = 3;
var firstX = 110;
var firstY = 150;
var isPassed = true;
var matrix = [];
var level = 1;
var pic = new Array();
//score
var score = 0;
//timer
var timer;
var minuts = 0;
var second = 0;
var clickAble;
var backCard;
var backObj = [];
var card;

//sounds
var backgroundAudio;
var gameOverAudio;
var buttonAudio;
var clickCardAudio;
var bombAudio;
var showAllCardsAudio;
var passLevelAudio;
var allClearedAudio;
var checkAudio;
var soundAble = true;
var numClickSound = 0;

var backgroundImage;
var margin = 4;
var cardWidth = 50;
var cardHeight = 50;

//pause button
var pauseButtonX = 50;
var pauseButtonY = 420;
var pauseButtonWidth = 100;
var pauseButtonHeight = 41;
//stop button
var stopButtonX = 170;
var stopButtonY = 420;
var stopButtonHeight = 41;
var stopButtonWidth = 100;

var backPics = ["image/back01.png", "image/back02.png", "image/back03.png", "image/back04.png"];
var pictures = [
    "image/iconbomb0.png", "image/icon023.png",
    "image/icon022.png", "image/icon021.png",
    "image/icon020.png", "image/icon019.png",
    "image/icon024.png", "image/icon018.png",
    "image/icon017.png", "image/icon016.png",
    "image/icon015.png", "image/icon014.png",
    "image/icon013.png", "image/icon012.png",
    "image/icon011.png", "image/icon010.png",
    "image/icon09.png", "image/icon08.png",
    "image/icon07.png", "image/icon06.png",
    "image/icon05.png", "image/icon04.png",
    "image/icon03.png", "image/icon02.png",
    "image/icon01.png", "image/icon016.png",
    "image/icon015.png", "image/icon014.png",
    "image/icon013.png", "image/icon06.png",
];

//draw backSide of card
function backsideCard() {
    ctx.drawImage(backCard, this.x, this.y, this.width, this.height);
}

//construction-for cards
function Cards(x, y, width, height, img, num, bomb) {
    this.x = x;
    this.y = y;
    this.width = width;
    this.height = height;
    this.img = img;
    this.bomb = bomb;
    this.num = num;
    this.draw = backsideCard;
}

//make matrix for cards, set up cards objects
function createMatrix(level) {
    var cardMatrix = new Array();
    matrix = [];
    var cardX;
    var cardY;

    //shuffle cards
    var p;
    var q;
    var temp;
    for (var i = 0; i < 3 * pictures.length; i++) {
        p = Math.floor(Math.random() * (pictures.length - 1) + 1);
        q = Math.floor(Math.random() * (pictures.length - 1) + 1);
        temp = pictures[p];
        pictures[p] = pictures[q];
        pictures[q] = temp;
    }

    var b = Math.floor(Math.random() * backPics.length);
    backCard = backObj[b];


    switch (level) {
        //Level 1: 2*2 matrix, 1 bomb,3 Magic Cards
        case 1:
            numBomb = 1;
            numMCard = 3;
            firstX = 110;
            firstY = 150;
            cardX = firstX;
            cardY = firstY;
            for (var i = 0; i < 4; i++) {
                cardMatrix[i] = pictures[i];
            }
            for (var i = 0; i < cardMatrix.length; i++) {
                var bomb = 0;
                pic[i].src = cardMatrix[i];
                if (i == 0) {
                    bomb = 1;
                }
                card = new Cards(cardX, cardY, cardWidth, cardHeight, pic[i], i, bomb);
                matrix.push(card);

                cardX = cardX + cardWidth + margin;
                if (i % 2 == 1) {
                    cardX = firstX;
                    cardY = cardY + cardHeight + margin;
                }
                card.draw();
            }
            break;

        //Level 2: 3*3 matrix, 1 bomb,8 Magic Cards
        case 2:
            firstX = 80;
            firstY = 130;
            cardX = firstX;
            cardY = firstY;
            numBomb = 1;
            numMCard = 8;
            for (var i = 0; i < 9; i++) {
                cardMatrix[i] = pictures[i];
            }
            for (var i = 0; i < cardMatrix.length; i++) {
                var bomb = 0;
                pic[i].src = cardMatrix[i];
                if (i == 0) {
                    bomb = 1;
                }
                card = new Cards(cardX, cardY, cardWidth, cardHeight, pic[i], i, bomb);
                matrix.push(card);

                cardX = cardX + cardWidth + margin;
                if (i % 3 == 2) {
                    cardX = firstX;
                    cardY = cardY + cardHeight + margin;
                }
                card.draw();
            }
            break;

        //Level 3: 4*4 matrix, 2 bomb,14 Magic Cards
        case 3:
            firstX = 55;
            firstY = 110;
            cardX = firstX;
            cardY = firstY;
            numBomb = 2;
            numMCard = 14;
            for (var i = 0; i < 16; i++) {
                cardMatrix[i] = pictures[i];
            }
            for (var j = 1; j < numBomb; j++) {
                cardMatrix[j] = cardMatrix[0];
            }
            for (var i = 0; i < cardMatrix.length; i++) {
                bomb = 0;
                pic[i].src = cardMatrix[i];
                if (i == 0 || i == 1) {
                    var bomb = 1;
                }
                card = new Cards(cardX, cardY, cardWidth, cardHeight, pic[i], i, bomb);
                matrix.push(card);

                cardX = cardX + cardWidth + margin;
                if (i % 4 == 3) {
                    cardX = firstX;
                    cardY = cardY + cardHeight + margin;
                }
                card.draw();
            }
            break;

        //Level 4: 4*4 matrix, 3 bomb, 13 Magic Cards
        case 4:
            firstX = 55;
            firstY = 110;
            cardX = firstX;
            cardY = firstY;
            numBomb = 3;
            numMCard = 13;
            for (var i = 0; i < 16; i++) {
                cardMatrix[i] = pictures[i];
            }
            for (var j = 1; j < numBomb; j++) {
                cardMatrix[j] = cardMatrix[0];
            }
            for (var i = 0; i < cardMatrix.length; i++) {
                var bomb = 0;
                pic[i].src = cardMatrix[i];
                if (i < numBomb) {
                    bomb = 1;
                }
                card = new Cards(cardX, cardY, cardWidth, cardHeight, pic[i], i, bomb);
                matrix.push(card);

                cardX = cardX + cardWidth + margin;
                if (i % 4 == 3) {
                    cardX = firstX;
                    cardY = cardY + cardHeight + margin;
                }
                card.draw();
            }
            break;

        //Level 5: 5*5 matrix, 3 bomb, 22 Magic Cards
        case 5:
            firstX = 28;
            firstY = 93;
            cardX = firstX;
            cardY = firstY;
            numBomb = 3;
            numMCard = 22;
            for (var i = 0; i < 25; i++) {
                cardMatrix[i] = pictures[i];
            }
            for (var j = 1; j < numBomb; j++) {
                cardMatrix[j] = cardMatrix[0];
            }
            for (var i = 0; i < cardMatrix.length; i++) {
                var bomb = 0;
                pic[i].src = cardMatrix[i];
                if (i < numBomb) {
                    bomb = 1;
                }
                card = new Cards(cardX, cardY, cardWidth, cardHeight, pic[i], i, bomb);
                matrix.push(card);

                cardX = cardX + cardWidth + margin;
                if (i % 5 == 4) {
                    cardX = firstX;
                    cardY = cardY + cardHeight + margin;
                }
                card.draw();
            }
            break;

        //Level 6: 5*5 matrix, 4 bomb, 21 Magic Cards
        case 6:
            firstX = 28;
            firstY = 93;
            cardX = firstX;
            cardY = firstY;
            numBomb = 4;
            numMCard = 21;
            for (var i = 0; i < 25; i++) {
                cardMatrix[i] = pictures[i];
            }
            for (var j = 1; j < numBomb; j++) {
                cardMatrix[j] = cardMatrix[0];
            }
            for (var i = 0; i < cardMatrix.length; i++) {
                var bomb = 0;
                pic[i].src = cardMatrix[i];
                if (i < numBomb) {
                    bomb = 1;
                }
                card = new Cards(cardX, cardY, cardWidth, cardHeight, pic[i], i, bomb);
                matrix.push(card);

                cardX = cardX + cardWidth + margin;
                if (i % 5 == 4) {
                    cardX = firstX;
                    cardY = cardY + cardHeight + margin;
                }
                card.draw();
            }
            break;

        //Level 7: 5*5 matrix, 5 bomb, 20 Magic Cards
        case 7:
            firstX = 28;
            firstY = 93;
            cardX = firstX;
            cardY = firstY;
            numBomb = 5;
            numMCard = 20;
            for (var i = 0; i < 25; i++) {
                cardMatrix[i] = pictures[i];
            }
            for (var j = 1; j < numBomb; j++) {
                cardMatrix[j] = cardMatrix[0];
            }
            for (var i = 0; i < cardMatrix.length; i++) {
                var bomb = 0;
                pic[i].src = cardMatrix[i];
                if (i < numBomb) {
                    bomb = 1;
                }
                card = new Cards(cardX, cardY, cardWidth, cardHeight, pic[i], i, bomb);
                matrix.push(card);

                cardX = cardX + cardWidth + margin;
                if (i % 5 == 4) {
                    cardX = firstX;
                    cardY = cardY + cardHeight + margin;
                }
                card.draw();
            }
            break;

        //Level 8: 5*6 matrix, 6 bomb, 24 Magic Cards
        case 8:
            firstX = 28;
            firstY = 73;
            cardX = firstX;
            cardY = firstY;
            numBomb = 6;
            numMCard = 24;
            for (var i = 0; i < 30; i++) {
                cardMatrix[i] = pictures[i];
            }
            for (var j = 1; j < numBomb; j++) {
                cardMatrix[j] = cardMatrix[0];
            }
            for (var i = 0; i < cardMatrix.length; i++) {
                var bomb = 0;
                pic[i].src = cardMatrix[i];
                if (i < numBomb) {
                    bomb = 1;
                }
                card = new Cards(cardX, cardY, cardWidth, cardHeight, pic[i], i, bomb);
                matrix.push(card);

                cardX = cardX + cardWidth + margin;
                if (i % 5 == 4) {
                    cardX = firstX;
                    cardY = cardY + cardHeight + margin;
                }
                card.draw();
            }
            break;

        //Level 9: 5*6 matrix, 7 bomb, 23 Magic Cards
        case 9:
            firstX = 28;
            firstY = 73;
            cardX = firstX;
            cardY = firstY;
            numBomb = 7;
            numMCard = 23;
            for (var i = 0; i < 30; i++) {
                cardMatrix[i] = pictures[i];
            }
            for (var j = 1; j < numBomb; j++) {
                cardMatrix[j] = cardMatrix[0];
            }
            for (var i = 0; i < cardMatrix.length; i++) {
                var bomb = 0;
                pic[i].src = cardMatrix[i];
                if (i < numBomb) {
                    bomb = 1;
                }
                card = new Cards(cardX, cardY, cardWidth, cardHeight, pic[i], i, bomb);
                matrix.push(card);

                cardX = cardX + cardWidth + margin;
                if (i % 5 == 4) {
                    cardX = firstX;
                    cardY = cardY + cardHeight + margin;
                }
                card.draw();
            }
            break;

        //Level 10: 5*6 matrix, 8 bomb, 22 Magic Cards
        case 10:
            firstX = 28;
            firstY = 73;
            cardX = firstX;
            cardY = firstY;
            numBomb = 8;
            numMCard = 22;
            for (var i = 0; i < 30; i++) {
                cardMatrix[i] = pictures[i];
            }
            for (var j = 1; j < numBomb; j++) {
                cardMatrix[j] = cardMatrix[0];
            }
            for (var i = 0; i < cardMatrix.length; i++) {
                var bomb = 0;
                pic[i].src = cardMatrix[i];
                if (i < numBomb) {
                    bomb = 1;
                }
                card = new Cards(cardX, cardY, cardWidth, cardHeight, pic[i], i, bomb);
                matrix.push(card);

                cardX = cardX + cardWidth + margin;
                if (i % 5 == 4) {
                    cardX = firstX;
                    cardY = cardY + cardHeight + margin;
                }
                card.draw();
            }
            break;
    }
}

function randomCards() {
    var i;
    var j;
    var tempNum;
    var tempImg;
    var tempBomb;
    var matrixLength = matrix.length;

    for (var k = 0; k < 3 * matrixLength; k++) {
        i = Math.floor(Math.random() * matrixLength);
        j = Math.floor(Math.random() * matrixLength);
        tempNum = matrix[i].num;
        tempImg = matrix[i].img;
        tempBomb = matrix[i].bomb;
        matrix[i].num = matrix[j].num;
        matrix[i].img = matrix[j].img;
        matrix[i].bomb = matrix[j].bomb;
        matrix[j].num = tempNum;
        matrix[j].img = tempImg;
        matrix[j].bomb = tempBomb;
    }
}

//click card method triggered by mouse event
function clickCard(ev) {
    var i;
    var rect = canvas.getBoundingClientRect();
    var myX = ev.clientX - rect.left;
    var myY = ev.clientY - rect.top;

    for (i = 0; i < matrix.length; i++) {
        card = matrix[i];
        //find which card the player click
        if (myX > card.x && myX < (card.x + card.width) && myY > card.y && myY < (card.y + card.height)) {
            //bomb: 1
            if (card.bomb == 1) {
                if (soundAble) bombAudio.play();
                ctx.drawImage(card.img, card.x, card.y, card.width, card.height);

                //not bomb and first click: 0
            } else if (card.bomb == 0 && isPassed) {
                if (soundAble) clickCardAudio.play();
                ctx.drawImage(card.img, card.x, card.y, card.width, card.height);
            }
            break;
        }
    }

    if (i < matrix.length) {
        //the card is bomb
        if (card.bomb == 1) {
            isPassed = false;
            if (score >= 2000) {
                firstAward = 1;
                document.getElementById("3000score").src = "image/2000Score3.png";
                setCookie('3000score', firstAward, 7);
            }
            if (score >= 4000) {
                secondAward = 1;
                document.getElementById("5000score").src = "image/4000Score3.png";
                setCookie('5000score', secondAward, 7);
            }
            gameOver(isPassed);
            for (var j = 0; j < matrix.length; j++) {
                matrix[j].bomb = 2;
            }

            //all clicked card are not bomb
        } else if (card.bomb == 0) {
            numMCard--;
            //not bomb and have clicked: 2
            card.bomb = 2;
            //pass the level
            if (numMCard == 0) {
                score += 500;
                switch (level) {
                    case 1:
                        if (minuts == 0 && second <= 1) {
                            score += 200;
                        } else if (minuts == 0 && second <= 2) {
                            score += 100;
                        }
                        break;
                    case 2:
                        if (minuts == 0 && second <= 2) {
                            score += 200;
                        } else if (minuts == 0 && second <= 3) {
                            score += 100;
                        }
                        break;
                    case 3:
                        if (minuts == 0 && second <= 3) {
                            score += 250;
                        } else if (minuts == 0 && second <= 4) {
                            score += 150;
                        }
                        break;
                    case 4:
                        if (minuts == 0 && second <= 4) {
                            score += 250;
                        } else if (minuts == 0 && second <= 5) {
                            score += 200;
                        }
                        break;
                    case 5:
                        if (minuts == 0 && second <= 5) {
                            score += 300;
                        } else if (minuts == 0 && second <= 6) {
                            score += 200;
                        }
                        break;
                    case 6:
                        if (minuts == 0 && second <= 6) {
                            score += 300;
                        } else if (minuts == 0 && second <= 7) {
                            score += 250;
                        }
                        break;
                    case 7:
                        if (minuts == 0 && second <= 7) {
                            score += 350;
                        } else if (minuts == 0 && second <= 8) {
                            score += 250;
                        }
                        break;
                    case 8:
                        if (minuts == 0 && second <= 7) {
                            score += 350;
                        } else if (minuts == 0 && second <= 8) {
                            score += 300;
                        }
                        break;
                    case 9:
                        if (minuts == 0 && second <= 7) {
                            score += 400;
                        } else if (minuts == 0 && second <= 9) {
                            score += 300;
                        }
                        break;
                    case 10:
                        if (minuts == 0 && second <= 7) {
                            score += 450;
                        } else if (minuts == 0 && second <= 10) {
                            score += 350;
                        }
                        break;
                }
                document.getElementById("score").innerHTML = score;

                canvas.removeEventListener('click', clickCard, false);
                setTimeout(function () {
                    for (var j = 0; j < matrix.length; j++) {
                        if (matrix[j].bomb == 1)ctx.drawImage(matrix[j].img, matrix[j].x, matrix[j].y, matrix[j].width, matrix[j].height);
                    }
                }, 200);

                if (level < 10) {
                    if (soundAble)passLevelAudio.play();
                    timer = clearInterval(timer);
                    setTimeout(function () {
                        level++;
                        initial();
                    }, 1500);
                } else if (level == 10) {
                    thirdAward = 1;
                    document.getElementById("pass10LevelCL").src = "image/allLevel3.png";
                    setCookie('pass10Level', thirdAward, 7);
                    if (score >= 2000) {
                        firstAward = 1;
                        document.getElementById("3000scoreCL").src = "image/2000Score3.png";
                        setCookie('3000score', firstAward, 7);
                    }
                    if (score >= 4000) {
                        secondAward = 1;
                        document.getElementById("5000scoreCL").src = "image/4000Score3.png";
                        setCookie('5000score', secondAward, 7);
                    }
                    if (score >= 8050) {
                        fourthAward = 1;
                        document.getElementById("fullScoreCL").src = "image/fullScore3.png";
                        setCookie('fullScore', fourthAward, 7);
                    }
                    allCleared(isPassed);
                }
            }
        }
    }
    //find the pause button
    if (myX > pauseButtonX && myX < (pauseButtonX + pauseButtonWidth) && myY > pauseButtonY && myY < (pauseButtonY + pauseButtonHeight)) {
        if (soundAble) buttonAudio.play();
        //ctx.drawImage(pauseButton, pauseButtonX, pauseButtonY);
        document.getElementById('pause').style.display = "block";
        clearInterval(timer);
    }
    //find the stop button
    if (myX > stopButtonX && myX < (stopButtonX + stopButtonWidth) && myY > stopButtonY && myY < (stopButtonY + stopButtonHeight)) {
        if (soundAble) buttonAudio.play();
        document.getElementById('stop').style.display = "block";
        clearInterval(timer);
    }
}

//onload function
function onloadPage() {
    level = 1;
    canvas = document.getElementById("myCav");
    ctx = canvas.getContext("2d");
    render();
    soundAble = (getCookie("soundCookie") == "true") ? true : false;
    if (soundAble) {
        document.getElementById("sound").src = "image/sound.png";
    } else {
        document.getElementById("sound").src = "image/nosound.png";
        numClickSound = 1;
    }

    //achievement initialization
    firstAward = getCookie('3000score');
    secondAward = getCookie('5000score');
    thirdAward = getCookie('pass10Level');
    fourthAward = getCookie('fullScore');

    if (firstAward == 1) {
        document.getElementById("3000score").src = "image/2000Score3.png";
        document.getElementById("3000scoreCL").src = "image/2000Score3.png";
    }
    if (secondAward == 1) {
        document.getElementById("5000score").src = "image/4000Score3.png";
        document.getElementById("5000scoreCL").src = "image/4000Score3.png";
    }
    if (thirdAward == 1) {
        document.getElementById("pass10LevelCL").src = "image/allLevel3.png";
        document.getElementById("pass10Level").src = "image/allLevel3.png";
    }
    if (fourthAward == 1) {
        document.getElementById("fullScoreCL").src = "image/fullScore3.png";
        document.getElementById("fullScore").src = "image/fullScore3.png";
    }

    //background audio
    backgroundAudio = new Audio("sounds/gamingBg.mp3");
    backgroundAudio.loop = true;
    backgroundAudio.volume = .15;
    backgroundAudio.load();
    if (soundAble)backgroundAudio.play();
    //gameover audio
    gameOverAudio = new Audio("sounds/gameOver.mp3");
    gameOverAudio.loop = false;
    gameOverAudio.volume = .25;
    gameOverAudio.load();
    //click cards audio
    clickCardAudio = new Audio("sounds/flipCard.mp3");
    clickCardAudio.loop = false;
    clickCardAudio.volume = 1;
    clickCardAudio.load();
    //bomb audio
    bombAudio = new Audio("sounds/bomb.mp3");
    bombAudio.loop = false;
    bombAudio.volume = .55;
    bombAudio.load();
    //click button audio
    buttonAudio = new Audio("sounds/buttonClick.mp3");
    buttonAudio.loop = false;
    buttonAudio.volume = .55;
    buttonAudio.load();
    //automatically show all cards audio
    showAllCardsAudio = new Audio("sounds/autoShowFrontside.mp3");
    showAllCardsAudio.loop = false;
    showAllCardsAudio.volume = .55;
    showAllCardsAudio.load();
    //all cleared audio
    allClearedAudio = new Audio("sounds/allCleared0.mp3");
    allClearedAudio.loop = true;
    allClearedAudio.volume = .25;
    allClearedAudio.load();
    //pass level audio
    passLevelAudio = new Audio("sounds/passLevel.mp3");
    passLevelAudio.loop = false;
    passLevelAudio.volume = .55;
    passLevelAudio.load();

    //check all audio
    checkAudio = setInterval(function () {
        checkReadyState();
    }, 1000);
}
function checkReadyState() {
    var frontsideReady = true;
    var backsideReady = true;
    for (var i = 0; i < pic.length; i++) {
        frontsideReady = frontsideReady && pic[i].complete;
    }
    for (var i = 0; i < backPics.length; i++) {
        backsideReady = backsideReady && backObj[i].complete;
    }
    if (gameOverAudio.readyState == 4 && backgroundAudio.readyState == 4 && showAllCardsAudio.readyState == 4 && clickCardAudio.readyState == 4 && bombAudio.readyState == 4 && allClearedAudio.readyState == 4 && passLevelAudio.readyState == 4 && backgroundImage.complete && backsideReady && frontsideReady) {
        checkAudio = clearInterval(checkAudio);
        document.getElementById('loading').style.display = "none";
        initial();
    }
}

function initial() {
    ctx.clearRect(0, 0, 320, 480);
    ctx.drawImage(backgroundImage, 0, 0);
    ctx.drawImage(backgroundLevel, 0, 0);
    ctx.drawImage(backgroundShadow, 0, 55);
    ctx.drawImage(pauseButton, pauseButtonX, pauseButtonY);
    ctx.drawImage(stopButton, stopButtonX, stopButtonY);

    //click listener
    setTimeout(function () {
        canvas.addEventListener('click', clickCard, false);
    }, 3500);

    createMatrix(level);
    //game title
    document.getElementById('level').innerHTML = level;

    randomCards();

    //automatically show front-side after 1.5 seconds
    setTimeout(function () {
        for (i = 0; i < matrix.length; i++) {
            ctx.drawImage(matrix[i].img, matrix[i].x, matrix[i].y, matrix[i].width, matrix[i].height);
            if (soundAble) showAllCardsAudio.play();

        }
    }, 1500);

    //automatically show back-side after 3.5 seconds
    setTimeout(function () {
        for (i = 0; i < matrix.length; i++) {
            matrix[i].draw();
            if (soundAble) showAllCardsAudio.play();

        }
    }, 3500);
    update();
}

//timer
function update() {
    minuts = 0;
    second = 0;
    document.getElementById('timer').innerHTML = minuts + ":" + second;
    setTimeout(function () {
        timer = setInterval(function () {
            second++;
            if (second == 60) {
                minuts++;
                second = 0;
            }
            document.getElementById('timer').innerHTML = minuts + ":" + second;
        }, 1000);
    }, 3500);
}

function render() {
    //background image;
    backgroundImage = new Image();
    backgroundImage.src = "image/background0.gif";
    ctx.drawImage(backgroundImage, 0, 0);

    //level background shadow
    backgroundLevel = new Image();
    backgroundLevel.src = "image/gameLevel.png";
    ctx.drawImage(backgroundLevel, 0, 0);

    //game background shadow
    backgroundShadow = new Image();
    backgroundShadow.src = "image/gameBackground.png";
    ctx.drawImage(backgroundShadow, 0, 55);

    //frontSide of cards
    for (var i = 0; i < pictures.length; i++) {
        pic[i] = new Image();
        pic[i].src = pictures[i];
    }
    //backSide of cards
    for (var i = 0; i < backPics.length; i++) {
        backObj[i] = new Image();
        backObj[i].src = backPics[i];
    }

    //game title
    document.getElementById('level').innerHTML = level;

    //pause button
    pauseButton = new Image();
    pauseButton.src = "image/pauseButton.png";
    ctx.drawImage(pauseButton, pauseButtonX, pauseButtonY);
    //pauseClick=new Image();
    //pauseClick.src="image/pauseClicked.png";

    //stop button
    stopButton = new Image();
    stopButton.src = "image/stopButton.png";
    ctx.drawImage(stopButton, stopButtonX, stopButtonY);
}

function gameOver(isPassed) {
    if (!isPassed) {
        timer = clearInterval(timer);
        setTimeout(function () {
            backgroundAudio.pause();
            gameOverAudio.currentTime = 0;
            if (soundAble) gameOverAudio.play();
            document.getElementById('gameOver').style.display = "block";
            document.getElementById("scoreGameOver").innerHTML = score;
        }, 500);
    }
}

function allCleared(isPassed) {
    if (isPassed) {
        timer = clearInterval(timer);
        setTimeout(function () {
            backgroundAudio.pause();
            allClearedAudio.currentTime = 0;
            if (soundAble) allClearedAudio.play();
            document.getElementById('allCleared').style.display = "block";
            document.getElementById("scoreAllCleared").innerHTML = score;
            document.getElementById("score").innerHTML = score;
        }, 800);
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

function setCookie(cookieName, cookieValue, expireDays) {
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + expireDays);
    document.cookie = cookieName + "=" + escape(cookieValue) + ((expireDays == null) ? "" : ";expires=" + exdate.toGMTString());
}