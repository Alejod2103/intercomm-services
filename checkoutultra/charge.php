<?php
require_once('vendor/autoload.php');
require __DIR__ . '/vendor/autoload.php';
use GuzzleHttp\Client;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

\Stripe\Stripe::setApiKey('sk_test_51MPo1hJQyDup2Epe0DIAVO3dYOm5SH45nqWq0PK3TS9vJaPrLhLwEOyV7LZSjRB2eeDNCPvAlAGTJF3L6I6b69hw00gAe2Md10');

$nombre = $_POST['name'];
$email = $_POST['email'];
$tel = $_POST['tel'];
$address = $_POST['address'];

try {
  $token = \Stripe\Token::create(array(
    "card" => array(
      "number" => $_POST['card_number'],
      "exp_month" => $_POST['card_exp_month'],
      "exp_year" => $_POST['card_exp_year'],
      "cvc" => $_POST['card_cvc']
    )
  ));

  $charge = \Stripe\Charge::create(array(
    "amount" => 12500,
    "currency" => "usd",
    "source" => $token['id'],
    "description" => "Servicio de Asistencia 6 meses",
    'metadata' => [
      'name' => $nombre,
      'email' => $email,
      'telefono' => $tel,
      'direccion' => $address,
    ]
  ));

  header('Location: success.html');

} catch (\Stripe\Exception\CardException $e) {
  $errorMessage = $e->getMessage();
  switch ($e->getError()->decline_code) {
      case "insufficient_funds":
          $estado = "Fondos insuficientes";
          header('Location: failure_funds.html');
          break;
      case "generic_decline":
          $estado = "Rechazo genérico";
          header('Location: failure_generic.html?errorMessage='.$errorMessage);
          break;
      case "lost_card":
          $estado = "Tarjeta perdida";
          header('Location: failure_lost.html');
          break;
      case "expired_card":
          $estado = "Tarjeta vencida";
          header('Location: failure_expired.html');
          break;
      case "fraudulent":
          $estado = "Fraude detectado";
          header('Location: failure_fraudulent.html');
          break;
      default:
          $estado = "Rechazo genérico";
          header('Location: failure_generic.html?errorMessage='.$errorMessage);
  }
}

?>