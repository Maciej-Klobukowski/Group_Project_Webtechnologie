<?php
session_start();
date_default_timezone_set('Europe/Amsterdam');

// DATABASE GEGEVENS
$dbHost = 'localhost';
$dbPort = '5432';
$dbName = 'webtechname';
$dbUser = 'WebTechUser';
$dbPassword = 'Abracadabra is a magic word! ;)';

$errorMessage = '';
$connectionError = '';

try {
    $dsn = "pgsql:host=$dbHost;port=$dbPort;dbname=$dbName";
    $pdo = new PDO($dsn, $dbUser, $dbPassword, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
} catch (PDOException $e) {
    $connectionError = "Kan geen verbinding maken met de database, probeer later opnieuw.";
}

if (!$connectionError && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputUsername = $_POST['username'] ?? '';
    $inputPassword = $_POST['password'] ?? '';

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $inputUsername]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $user['password'] === $inputPassword) {
            $_SESSION['username'] = $user['username'];
        } else {
            $errorMessage = "Fout: probeer opnieuw.";
        }
    } catch (PDOException $e) {
        $errorMessage = "Er is iets misgegaan, probeer opnieuw.";
    }
}

// Als ingelogd, sensor data ophalen
if (!$connectionError && isset($_SESSION['username'])) {
    try {
        $stmt = $pdo->query("SELECT temperature, humidity, timestamp FROM sensor_data ORDER BY timestamp DESC LIMIT 1");
        $sensorData = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
     
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
<meta charset="UTF-8" />
<title>Login & Sensor Data + Countdown</title>
<style>
    body {
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg, #e0eafc, #cfdef3);
    color: #333;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
    text-align: center;
}

form {
    background: white;
    padding: 30px 40px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    width: 90%;
    max-width: 320px;
}


    input[type="text"], input[type="password"] {
        font-size: 1.1em;
        padding: 10px;
        margin: 10px 0;
        width: 100%;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    input[type="submit"] {
        font-size: 1.1em;
        padding: 10px 20px;
        background: #007BFF;
        border: none;
        border-radius: 5px;
        color: white;
        cursor: pointer;
        margin-top: 10px;
        width: 100%;
    }

    input[type="submit"]:hover {
        background: #0056b3;
    }

    .error {
        color: red;
        font-weight: bold;
        margin-top: 10px;
    }

    h2 {
        font-size: 2em;
        font-weight: normal;
        position: relative;
        display: inline-block;
        padding-bottom: 10px;
    }

    h2::after {
        content: "";
        display: block;
        height: 3px;
        width: 80%;
        background: #007BFF;
        margin: 0 auto;
        margin-top: 10px;
        border-radius: 2px;
    }

    h3, .since-text {
        font-size: 1.8em;
        font-weight: normal;
        color: #555;
        margin-bottom: 20px;
    }

    .timer-box {
        font-size: 2.2em;
        margin: 30px auto;
        background: white;
        display: inline-block;
        padding: 25px 35px;
        border-radius: 15px;
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    }

    .divider {
        margin: 50px auto 20px;
        width: 60%;
        border-top: 2px solid #ccc;
        border-radius: 1px;
    }

    .sensor-box {
        max-width: 320px;
        margin: 20px auto 40px;
        background: #f0f8ff;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        font-family: Arial, sans-serif;
    }
</style>
</head>
<body>

<?php if ($connectionError): ?>
    <div class="error"><?php echo htmlspecialchars($connectionError); ?></div>
<?php elseif (isset($_SESSION['username'])): ?>
    <h2>Welkom, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <h3>The birthday of the most important person ever is in ..</h3>
    <div class="timer-box" id="countdown">Loading...</div>

    <div class="divider"></div>

    <div class="timer-box" id="countup">Loading...</div>
    <p class="since-text">Since Timo's bank account was taken over by airsoft.</p>

<div class="sensor-box">
    <h2>Lokaal Sensor Data</h2>
    <?php if ($sensorData): ?>
        <p>Temperatuur: <strong><?php echo htmlspecialchars($sensorData['temperature']); ?> °C</strong></p>
        <p>Vochtigheid: <strong><?php echo htmlspecialchars($sensorData['humidity']); ?> %</strong></p>
        <p><small>Laatste update: <?php echo htmlspecialchars($sensorData['timestamp']); ?></small></p>
    <?php else: ?>
        <p style="color:red; font-weight:bold;">⚠️ Geen sensor data beschikbaar in de database.</p>
    <?php endif; ?>
</div>

    <script>
        // Countdown to birthday
        const birthday = new Date(2025, 9, 5, 0, 0, 0);
        function updateCountdown() {
            const now = new Date();
            const diff = birthday - now;
            if (diff <= 0) {
                document.getElementById('countdown').innerText = "Happy Birthday!";
                clearInterval(countdownTimer);
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
        const countdownTimer = setInterval(updateCountdown, 1000);

        // Count up from 16/01/2023
        const startDate = new Date(2023, 0, 16, 0, 0, 0);
        function updateCountup() {
            const now = new Date();
            const diff = now - startDate;

            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
            const minutes = Math.floor((diff / (1000 * 60)) % 60);
            const seconds = Math.floor((diff / 1000) % 60);

            document.getElementById('countup').innerText =
                days + " days " +
                hours + " hours " +
                minutes + " minutes " +
                seconds + " seconds";
        }
        updateCountup();
        setInterval(updateCountup, 1000);

    </script>
    </script>

<?php else: ?>
    <h2>Inloggen</h2>
    <form method="post" action="">
        <input type="text" name="username" placeholder="Gebruikersnaam" required autofocus />
        <input type="password" name="password" placeholder="Wachtwoord" required />
        <input type="submit" value="Inloggen" />
    </form>
    <?php if ($errorMessage): ?>
        <div class="error"><?php echo htmlspecialchars($errorMessage); ?></div>
    <?php endif; ?>
<?php endif; ?>

</body>
</html>
