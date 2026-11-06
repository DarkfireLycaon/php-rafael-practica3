-- Eliminar las líneas de CREATE DATABASE y USE miapp ya que Render ya te la creó y conectamos directo

CREATE TABLE IF NOT EXISTS alumnos (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL
);

-- Insertamos los datos de prueba (evitando duplicados si se ejecuta varias veces)
INSERT INTO alumnos (nombre, email) 
VALUES 
    ('Ana López', 'ana@example.com'),
    ('Luis García', 'luis@example.com'),
    ('Marta Ruiz', 'marta@example.com')
ON CONFLICT DO NOTHING;
