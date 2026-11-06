<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = getenv('DB_HOST');
$db   = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASSWORD') ?: getenv('DB_PASS');
$port = getenv('DB_PORT') ?: '5432';

try {
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Opcional: Si quieres ejecutar tu archivo init.sql de forma automática al arrancar
    $initFile = __DIR__ . '/init.sql'; // Ajusta la ruta si está en otra carpeta
    if (file_exists($initFile)) {
        $sqlScript = file_get_contents($initFile);
        $conn->exec($sqlScript);
    }

} catch (PDOException $e) {
    die("❌ Error crítico de conexión: " . htmlspecialchars($e->getMessage()));
}
?>
