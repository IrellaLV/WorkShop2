<?php
// Datos para la conexión
$host = "localhost";
$user = "root";
$password = "";
$database = "usuarios";

// Crear la conexión
$conn = new mysqli($host, $user, $password, $database);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturar los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];

    // Preparar la consulta SQL
    $sql = "INSERT INTO usuarios (Nombre, Apellido, Telefono, Correo) VALUES (?, ?, ?, ?)";

    // Preparar la consulta
    if ($stmt = $conn->prepare($sql)) {
        // Enlazar los parámetros (s = string)
        $stmt->bind_param("ssss", $nombre, $apellido, $telefono, $correo);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Mostrar mensaje con check verde
            echo "
                <div style='color: green; font-size: 20px; text-align: center;'>
                    <span style='font-size: 40px;'>&#10003;</span> Datos insertados correctamente.
                </div>
            ";
        } else {
            echo "Error al insertar los datos: " . $stmt->error;
        }

        // Cerrar el statement
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
} else {
    echo "Error: No se ha enviado el formulario.";
}
?>
