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
    // Niet technische foutmelding tonen
    $connectionError = "Kan geen verbinding maken met de database, probeer later opnieuw.";
}

// Alleen proberen inloggen als we succesvol met DB verbonden zijn en formulier is verzonden
if (!$connectionError && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputUsername = $_POST['username'] ?? '';
    $inputPassword = $_POST['password'] ?? '';

    // Zoek gebruiker in database
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $inputUsername]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $user['password'] === $inputPassword) {
            // Login succesvol
            $_SESSION['username'] = $user['username'];
        } else {
            // Gebruiker of wachtwoord fout
            $errorMessage = "Fout: probeer opnieuw.";
        }
    } catch (PDOException $e) {
        $errorMessage = "Er is iets misgegaan, probeer opnieuw.";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
<meta charset="UTF-8" />
<title>Login & Countdown</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f0f0f0;
        color: #333;
        text-align: center;
        margin-top: 50px;
    }
    form {
        background: white;
        display: inline-block;
        padding: 20px 30px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        max-width: 300px;
    }
    input[type="text"], input[type="password"] {
        font-size: 1em;
        padding: 8px;
        margin: 8px 0;
        width: 100%;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }
    input[type="submit"] {
        font-size: 1em;
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
    #countdown {
        font-size: 2.5em;
        margin-top: 20px;
        background: white;
        display: inline-block;
        padding: 15px 25px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    h2 {
        font-weight: normal;
        font-size: 1.8em;
    }
</style>
</head>
<body>

<?php if ($connectionError): ?>
    <div class="error"><?php echo htmlspecialchars($connectionError); ?></div>
<?php elseif (isset($_SESSION['username'])): ?>
    <h2>Welkom, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <h3>The birthday of the most important person ever is in ..</h3>
    <div id="countdown">Loading...</div>

    <script>
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