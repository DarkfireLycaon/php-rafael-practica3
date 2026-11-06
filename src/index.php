<?php


try {
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 1. Crear la tabla si no existe
    $sqlTable = "CREATE TABLE IF NOT EXISTS alumnos (
        id SERIAL PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        email VARCHAR(150) UNIQUE NOT NULL,
        edad INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );";
    $conn->exec($sqlTable);

    // 2. Insertar un registro de prueba si la tabla está vacía
    $check = $conn->query("SELECT COUNT(*) FROM alumnos");
    if ($check->fetchColumn() == 0) {
        $conn->exec("INSERT INTO alumnos (nombre, email, edad) VALUES ('Rafael Torretta', 'rafael@example.com', 25);");
    }

} catch (PDOException $e) {
    die("❌ Error de conexión o inicialización: " . htmlspecialchars($e->getMessage()));
}
?>
