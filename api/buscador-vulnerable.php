<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../config/conexion.php';

$q = $_GET['q'] ?? '';

try {
    // 1. Preparar la consulta SQL utilizando un marcador de posición (:termino)
    $sql = "SELECT * FROM productos WHERE nombre LIKE :termino";
    $stmt = $pdo->prepare($sql);

    // 2. Ejecutar la consulta pasando el valor con los comodines de manera segura
    $stmt->execute(['termino' => '%' . $q . '%']);
    
    $resultado = $stmt->fetchAll();

    http_response_code(200);
    echo json_encode([
        "estado" => "exito",
        "total"  => count($resultado),
        "data"   => $resultado
    ], JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "estado" => "error",
        "mensaje" => "Error al procesar la consulta en el servidor."
    ], JSON_UNESCAPED_UNICODE);
}
?>