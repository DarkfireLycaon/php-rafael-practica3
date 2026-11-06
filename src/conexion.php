<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = getenv('DB_HOST');
$db   = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASSWORD') ?: getenv('DB_PASS'); // Compatible con ambos nombres de variable
$port = getenv('DB_PORT') ?: '5432';

try {
    // CORREGIDO: Usamos 'pgsql:' en lugar de 'mysql:' para conectar con PostgreSQL
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p style='color: green;'>✅ ¡Conexión establecida con éxito a PostgreSQL!</p>";
} catch (PDOException $e) {
    die("<h1>❌ Error de conexión:</h1><p>" . htmlspecialchars($e->getMessage()) . "</p>");
}

try {
    // Sentencia SQL para crear la tabla en PostgreSQL
    $sql = "CREATE TABLE IF NOT EXISTS alumnos (
        id SERIAL PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        email VARCHAR(150) UNIQUE NOT NULL,
        edad INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );";

    $conn->exec($sql);
    echo "<p style='color: green;'><h1>¡Tabla 'alumnos' creada con éxito en PostgreSQL!</h1></p>";

} catch (PDOException $e) {
    echo "<h1>Error al crear la tabla:</h1><p>" . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
