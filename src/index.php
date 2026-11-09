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

    // 3. Consultar los registros para mostrarlos en pantalla
    $stmt = $conn->query("SELECT * FROM alumnos");
    $alumnos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("❌ Error de conexión o inicialización: " . htmlspecialchars($e->getMessage()));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Práctica PHP y PostgreSQL</title>
</head>
<body>
    <h2>¡Conexión y configuración de PostgreSQL exitosa! 🚀</h2>
    <h3>Listado de Alumnos:</h3>
    <ul>
        <?php foreach ($alumnos as $alumno): ?>
            <li><strong><?php echo htmlspecialchars($alumno['nombre']); ?></strong> (<?php echo htmlspecialchars($alumno['email']); ?>) - Edad: <?php echo $alumno['edad']; ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
