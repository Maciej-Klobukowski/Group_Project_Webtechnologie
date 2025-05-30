<?php
session_start();
header('Content-Type: application/json');
date_default_timezone_set('Europe/Amsterdam');

// Database config
$dbHost = 'localhost';
$dbPort = '5432';
$dbName = 'webtechname';
$dbUser = 'WebTechUser';
$dbPassword = 'Abracadabra is a magic word! ;)';

// Verbinding maken
try {
    $dsn = "pgsql:host=$dbHost;port=$dbPort;dbname=$dbName";
    $pdo = new PDO($dsn, $dbUser, $dbPassword, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Kan geen verbinding maken met database.']);
    exit;
}

// Alleen POST requests toestaan
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Alleen POST methode toegestaan.']);
    exit;
}

// JSON input lezen
$input = json_decode(file_get_contents('php://input'), true);

if (!$input || empty($input['username']) || empty($input['password'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Geldige gebruikersnaam en wachtwoord vereist.']);
    exit;
}

$username = $input['username'];
$password = $input['password'];

// User ophalen uit DB
try {
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        http_response_code(401);
        echo json_encode(['error' => 'Ongeldige gebruikersnaam of wachtwoord.']);
        exit;
    }

    // Wachtwoord check (pas aan als je hashes gebruikt)
    if ($user['password'] !== $password) {
        http_response_code(401);
        echo json_encode(['error' => 'Ongeldige gebruikersnaam of wachtwoord.']);
        exit;
    }

    // Login succesvol, sessie opslaan
    $_SESSION['username'] = $user['username'];

    echo json_encode([
        'message' => 'Login succesvol',
        'username' => $user['username']
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Fout bij het verwerken van login.']);
}
/*
🔁 How It Works Step-by-Step
User submits login form on your website.

The browser sends a POST request to your PHP API (login.php on localhost:8000).

Your PHP script:

Accepts that request.

Connects to the PostgreSQL database.

Checks if the user exists and if the password is correct.

If successful:

The PHP script starts a session and sends back a JSON response.

Your frontend can use that response to, for example, redirect the user or show a success message.
*/

