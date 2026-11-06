<?php
// Forzar la visualización de errores para que nunca más se quede en blanco
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = getenv('DB_HOST');
$db   = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASSWORD') ?: getenv('DB_PASS');
$port = getenv('DB_PORT') ?: '5432';

try {
    // Conexión a PostgreSQL en Render
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Creamos la tabla y metemos los datos de prueba directamente aquí
    $sql = "
        CREATE TABLE IF NOT EXISTS alumnos (
            id SERIAL PRIMARY KEY,
            nombre VARCHAR(50) NOT NULL,
            email VARCHAR(50) NOT NULL
        );

        INSERT INTO alumnos (nombre, email) 
        VALUES 
            ('Ana López', 'ana@example.com'),
            ('Luis García', 'luis@example.com'),
            ('Marta Ruiz', 'marta@example.com')
        ON CONFLICT DO NOTHING;
    ";
    
    $conn->exec($sql);

} catch (PDOException $e) {
    die("❌ <strong>Error crítico de conexión o base de datos:</strong> " . htmlspecialchars($e->getMessage()));
}
?>
