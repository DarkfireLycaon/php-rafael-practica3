<?php
$host = getenv('DB_HOST');
$db   = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASSWORD');
$port = getenv('DB_PORT');

try {
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "❌ Error de conexión: " . $e->getMessage();
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
    echo "<h1>¡Tabla 'alumnos' creada con éxito en PostgreSQL!</h1>";

} catch (PDOException $e) {
    echo "<h1>Error al crear la tabla:</h1><p>" . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
