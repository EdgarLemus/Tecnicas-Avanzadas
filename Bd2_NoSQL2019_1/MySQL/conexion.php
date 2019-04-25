<?php
// Create connection (Puerto, Usuario, Clave y base datos)
$conn = new mysqli('localhost', 'root', '','chatU');
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
