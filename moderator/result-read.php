<!DOCTYPE html>
<html>
<link rel="icon" type="image/png" href="icon.png">
<title>Vote Result</title>
<style>
    body, html {
        height: 100%;
        margin: 0;
        font-family: 'theaterbold', Arial, sans-serif;
        font-weight:bolder;
        /* line-height:200%; */
        font-style:normal;
        text-shadow:
            -1.5px -1.5px 3px #000,
            2px -2px 3px #000,
            -2px 2px 3px #000,
            3px 3px 0 #000;    
        background-color: #ffeea9;
        background-color: black;
        word-spacing: 0.3em;
        letter-spacing: 0.1em;
        text-emphasis-color: black;
    }

    .bgimg {
        background-image: url('background-3.jpeg');
        height: 100%;
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
        position: relative;
        color: white;
        font-family: 'theaterbold', Arial, sans-serif;
        font-weight:bolder;
        font-style:normal;
        font-size: 50px;
    }

    .middle {
        position: absolute;
        font-size: 0.70em;
        top: 45%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: left;
        letter-spacing: 0.1em;
        margin-bottom: 1.5em;
    }
    
    th {
        text-align: left;
    }

    td {
        padding-top: 0.1em;
        padding-right: 0.4em;
        padding-bottom: 0.1em;
        text-align: center;
    }

    #time {
        text-align: center;
        word-spacing: 0.3em; 
        letter-spacing: 0.1em;
    }

    #outcome {
        text-align: center; 
        word-spacing: 0.3em; 
        color:white; 
        /* background-color: green;  */
        /* background-color: red;  */
        text-shadow: none;
    }

    .logo {
        /* text-shadow: none; */
        position: absolute;
        bottom: 0;
        left: 75%;
        font-family:-apple-system, 'Open Sans', 'Helvetica Neue', sans-serif;
        background-image: linear-gradient(to bottom,#A41034,#a01e3e, #a36071);
        /* background-image: linear-gradient(to bottom right, #A41034, white); */
        background-color: #A41034;
        font-size: 1em;
        color: white;
        padding-top: 0.75em;
        padding-bottom: 0.75em;
        padding-right: 0.5em;
        padding-left: 0.5em;
        margin: 1em;
        text-decoration: none;
    }
</style>
<body>
    <div class="bgimg">
        <div class="middle">
            <p id="title">FELIX CHEN OF TEXAS<br>AMENDMENT<br>ON AGREEING TO THE<br>AMENDMENT</p>

            <table style="margin-top: 1.5em;">   
                <tr style="margin-bottom: 0.75em;">
                    <td>RES.</td>
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

            <p id="outcome">  
            </p>
        </div>
        
        <a href="results.html" class="logo">
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