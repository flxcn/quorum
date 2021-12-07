<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Felix Chen">
    <link rel="icon" type="image/png" href="icon.png">
    <title>H-SPAN | Vote Tally</title>
    <link href="../assets/css/hspan.css" rel="stylesheet">
</head>
<body>
    <div class="bgimg">
        <div class="middle">
            <p id="title">FELIX CHEN OF TEXAS<br>AMENDMENT<br>ON AGREEING TO THE<br>AMENDMENT</p>

            <table style="margin-top: 1.5em;">   
                <tr style="margin-bottom: 0.75em;">
                    <td>AMEND.</td>
                    <td id="voteId">&nbsp;&nbsp;&nbsp;1028</td>
                </tr>

                <tr>
                    <td></td>
                    <td>YEA</td>
                    <td>NAY</td>
                    <td>PRES</td>
                    <td>NV</td>
                </tr>
            
                <tr>
                    <th>DELEGATES</th>
                    <td id="delegateYeaCount">46</td>
                    <td id="delegateNayCount">12</td>     
                    <td>2</td>
                    <td>1</td>
                </tr>

                <tr>
                    <th>CAUCUSES</th>
                    <td id="caucusYeaCount">7</td>
                    <td id="caucusNayCount">2</td>
                    <td>1</td>
                    <td>0</td>
                </tr>
            </table>

            <p id="time">  
                TIME REMAINING&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </p>

            <p id="outcome"></p>
        </div>
        
        <a href="results.php" class="logo">
            H<span style="font-size: 80%;">&#9642;</span>SPAN
        </a>
    </div>

    <script>
        var duration = 10;

        var countDownDate = new Date(new Date().getTime() + duration * 1000);
        
        var countDownFunction = setInterval(function() {
        
            var now = new Date().getTime();
        
            var difference = countDownDate - now;
        
            var minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((difference % (1000 * 60)) / 1000);
        
            document.getElementById("time").innerHTML = "TIME REMAINING&nbsp;&nbsp;" + 
            minutes + ":" + (seconds < 10 ? '0' : '') + seconds;
        
            if (difference < 0) {
                clearInterval(countDownFunction);
                document.getElementById("time").innerHTML = "TIME REMAINING&nbsp;&nbsp;0:00";
                calculateOutcome();
            }
        }, 1000);

        function calculateOutcome() {
            var delegateYeaCount = parseInt(document.getElementById("delegateYeaCount").innerHTML);
            var delegateNayCount = parseInt(document.getElementById("delegateNayCount").innerHTML);

            var caucusYeaCount = parseInt(document.getElementById("caucusYeaCount").innerHTML);
            var caucusNayCount = parseInt(document.getElementById("caucusNayCount").innerHTML);

            if (delegateYeaCount / (delegateYeaCount + delegateNayCount) >= 0.75 && caucusYeaCount / (caucusYeaCount + caucusNayCount) >= 0.75) {
                document.getElementById("outcome").innerHTML = "PASSAGE SECURED";
                document.getElementById("outcome").style.backgroundColor = "green";
            }
            else if (delegateYeaCount / (delegateYeaCount + delegateNayCount) < 0.75 || caucusYeaCount / (caucusYeaCount + caucusNayCount) < 0.75)
            {
                document.getElementById("outcome").innerHTML = "PASSAGE FAILED";
                document.getElementById("outcome").style.backgroundColor = "red";
            }
            else {
            }

        }
    </script>

</body>
</html>