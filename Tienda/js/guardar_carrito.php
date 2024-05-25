<?php
// guardar_datos.php

header('Content-Type: application/json');

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "refacciones";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Conexión fallida: " . $conn->connect_error]));
}

// Obtener los datos enviados
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(["success" => false, "message" => "Datos no recibidos correctamente"]);
    exit;
}

$usuario = $data['usuario'];
$productos = $data['productos'];

// Insertar datos del usuario
$nombre = $conn->real_escape_string($usuario['nombre']);
$apellido = $conn->real_escape_string($usuario['apellido']);
$telefono = $conn->real_escape_string($usuario['telefono']);
$correo = $conn->real_escape_string($usuario['correo']);
$horaRecogida = $conn->real_escape_string($usuario['horaRecogida']);
$diaRecogida = $conn->real_escape_string($usuario['diaRecogida']);
$horaCompra = $conn->real_escape_string($usuario['horaCompra']);
$diaCompra = $conn->real_escape_string($usuario['diaCompra']);
$aceptarTerminos = $usuario['aceptarTerminos'] ? 1 : 0;

$sql_usuario = "INSERT INTO usuarios (nombre, apellido, telefono, correo, hora_recogida, dia_recogida, hora_compra, dia_compra, aceptar_terminos)
VALUES ('$nombre', '$apellido', '$telefono', '$correo', '$horaRecogida', '$diaRecogida', '$horaCompra', '$diaCompra', '$aceptarTerminos')";

if ($conn->query($sql_usuario) === TRUE) {
    $usuario_id = $conn->insert_id;

    // Insertar datos de los productos
    foreach ($productos as $producto) {
        $producto_id = $conn->real_escape_string($producto['id']);
        $titulo = $conn->real_escape_string($producto['titulo']);
        $cantidad = $conn->real_escape_string($producto['cantidad']);
        $precio = $conn->real_escape_string($producto['precio']);

        $sql_producto = "INSERT INTO productos (usuario_id, producto_id, titulo, cantidad, precio)
        VALUES ('$usuario_id', '$producto_id', '$titulo', '$cantidad', '$precio')";

        if (!$conn->query($sql_producto)) {
            echo json_encode(["success" => false, "message" => "Error al guardar el producto: " . $conn->error]);
            exit;
        }
    }

    echo json_encode(["success" => true, "message" => "Datos guardados exitosamente"]);
} else {
    echo json_encode(["success" => false, "message" => "Error al guardar el usuario: " . $conn->error]);
}

$conn->close();
?>
