<?phpAdd commentMore actions
// api_sensordata.php
header('Content-Type: application/json');
date_default_timezone_set('Europe/Amsterdam');

$dbHost = 'localhost';
$dbPort = '5432';
$dbName = 'webtechname';
$dbUser = 'WebTechUser';
$dbPassword = 'Abracadabra is a magic word! ;)';

try {
    $dsn = "pgsql:host=$dbHost;port=$dbPort;dbname=$dbName";
    $pdo = new PDO($dsn, $dbUser, $dbPassword, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Kan geen verbinding maken met de database']);
    exit;
}

// Alleen POST accepteren
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Alleen POST methode toegestaan']);
    exit;
}

// JSON input lezen
$input = json_decode(file_get_contents('php://input'), true);
if (!$input || !isset($input['temperature']) || !isset($input['humidity'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Temperature en humidity zijn vereist']);
    exit;
}

$temperature = floatval($input['temperature']);
$humidity = floatval($input['humidity']);

try {
    $stmt = $pdo->prepare("INSERT INTO sensor_data (temperature, humidity) VALUES (:temperature, :humidity)");
    $stmt->execute([
        ':temperature' => $temperature,
        ':humidity' => $humidity,
    ]);
    echo json_encode(['message' => 'Data opgeslagen']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Fout bij opslaan data']);
}Add commentMore actions
?>