<?php
// Optioneel: zet hier je server tijdzone zodat PHP hetzelfde aanneemt als JavaScript
date_default_timezone_set('Europe/Amsterdam');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Countdown to Birthday</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
            background: #f0f0f0;
            color: #333;
        }
        h2 {
            font-weight: normal;
            font-size: 1.8em;
        }
        #countdown {
            font-size: 2.5em;
            margin-top: 20px;
            background: white;
            display: inline-block;
            padding: 15px 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<h2>The birthday of the most important person ever is in ..</h2>

<div id="countdown">Loading...</div>

<script>
    // Je verjaardag: oktober is maand 9 (0-based!)
    const birthday = new Date(2025, 9, 5, 0, 0, 0);

    function updateCountdown() {
        const now = new Date();
        const diff = birthday - now;

        if (diff <= 0) {
            document.getElementById('countdown').innerText = "Happy Birthday!";
            clearInterval(timer);
            return;
        }

        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
        const minutes = Math.floor((diff / (1000 * 60)) % 60);
        const seconds = Math.floor((diff / 1000) % 60);

        document.getElementById('countdown').innerText =
            days + " days " +
            hours + " hours " +
            minutes + " minutes " +
            seconds + " seconds";
    }

    updateCountdown();
    const timer = setInterval(updateCountdown, 1000);
</script>

</body>
</html>
