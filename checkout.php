<?php
session_start();
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['total_amount'])) {
    $total = $_POST['total_amount'];
} else {
    die('Error: No se encontró el monto total.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago con PayPal</title>
    <script src="https://www.paypal.com/sdk/js?client-id=ASCRCLgsUEHtKpJvMXuEWVSwY7C0si0jjhhQnh2YDejnqS7n82GXF457__JQ5wRbX41VRNqtM1zhRd8z"></script>
</head>
<body>
    <div id="paypal-button-container"></div>
    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '<?php echo $total; ?>' // Monto total jalado del carrito
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function (detalles) {
                    // Lógica para actualizar el stock y vaciar el carrito
                    fetch('process_payment.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            transactionDetails: detalles
                        })
                    }).then(response => response.json())
                      .then(data => {
                          if (data.success) {
                              window.location.href = "confirmation.php";
                          } else {
                              alert('Hubo un problema al procesar el pago.');
                          }
                      });
                });
            },
            onCancel: function(data) {
                alert("Pago cancelado");
            }
        }).render('#paypal-button-container');
    </script>
</body>
</html>
