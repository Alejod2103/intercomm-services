<?php

$name = $_POST['name'];
$phone = $_POST['tel'];
$address = $_POST['address'];
$signature = $_POST['signature'];



$signature = str_replace("data:image/png;base64,", "", $signature);
$signature = base64_decode($signature);
$file = 'signatures/' . time() . '.png';
file_put_contents($file, $signature);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "datos";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Conexion fallida: " . mysqli_connect_error());
}

$sql = "INSERT INTO form_firmas (name, phone, address, signature)
VALUES ('$name', '$phone', '$address', '$file')";

if (mysqli_query($conn, $sql)) {
    echo json_encode(['success' => true]);
    session_start();
    $_SESSION['nombre'] = $nombre;
    $_SESSION['telefono'] = $telefono;
    $_SESSION['direccion'] = $direccion;
    $_SESSION['firma'] = $firma;
    header('Location: success.php');
} else {
    echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
}

mysqli_close($conn);

?>