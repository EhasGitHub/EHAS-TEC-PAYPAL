<?php
include 'config.php'; // Conexión a la base de datos

// Lee la entrada JSON de PayPal
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['orderID']) && isset($data['payerID'])) {
    $orderID = $data['orderID'];
    $payerID = $data['payerID'];
    
    // Aquí puedes guardar la orden en la base de datos
    $stmt = $conn->prepare("INSERT INTO orders (order_id, payer_id, status) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $orderID, $payerID, $status);
    $status = "Completado"; // Estado del pago

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Orden guardada con éxito"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al guardar la orden"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Datos incompletos"]);
}
?>
