<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "refacciones";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos enviados desde el cliente
$productosEnCarrito = json_decode(file_get_contents('php://input'), true);

// Preparar la declaración SQL
$sql = "INSERT INTO carrito (titulo, cantidad, precio, subtotal) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// Insertar cada producto en la base de datos
foreach ($productosEnCarrito as $producto) {
    $titulo = $producto['titulo'];
    $cantidad = $producto['cantidad'];
    $precio = $producto['precio'];
    $subtotal = $producto['precio'] * $producto['cantidad'];
    $stmt->bind_param("sidi", $titulo, $cantidad, $precio, $subtotal);
    $stmt->execute();
}

$stmt->close();
$conn->close();

// Responder al cliente
echo json_encode(["success" => true]);
?>
