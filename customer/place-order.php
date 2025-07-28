<?php
include(__DIR__ . '/../config/db.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (empty($_POST['name']) || empty($_POST['mobile']) || empty($_POST['cart'])) {
    echo json_encode(["success" => false, "message" => "❌ Missing fields"]);
    exit;
  }

  $name = $conn->real_escape_string($_POST['name']);
  $mobile = $conn->real_escape_string($_POST['mobile']);
  $cart = json_decode($_POST['cart'], true);

  $latitude = isset($_POST['latitude']) ? $conn->real_escape_string($_POST['latitude']) : null;
  $longitude = isset($_POST['longitude']) ? $conn->real_escape_string($_POST['longitude']) : null;

  if (!is_array($cart) || count($cart) === 0) {
    echo json_encode(["success" => false, "message" => "❌ Invalid or empty order data"]);
    exit;
  }

  $items_string = "";
  $total = 0;

  foreach ($cart as $item) {
    $product_name = $conn->real_escape_string($item['product_name']);
    $qty = (int)$item['qty'];
    $price = (float)$item['price'];

    $items_string .= "$product_name x$qty, ";
    $total += $qty * $price;
  }

  $items_string = rtrim($items_string, ", ");

  // Insert including location
  $stmt = $conn->prepare("INSERT INTO orders (customer_name, customer_mobile, items, total_price, latitude, longitude) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("sssdds", $name, $mobile, $items_string, $total, $latitude, $longitude);

  if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "✅ Order placed successfully"]);
  } else {
    echo json_encode(["success" => false, "message" => "❌ Failed to place order"]);
  }
} else {
  echo json_encode(["success" => false, "message" => "❌ Invalid request"]);
}
?>
