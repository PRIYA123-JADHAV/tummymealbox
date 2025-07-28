<?php
include(__DIR__ . '/../config/db.php');

$id = $_GET['id'] ?? 0;
$query = $conn->query("SELECT * FROM menus WHERE id = $id");
$dish = $query->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['product_name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $image_url = $_POST['image_url'];
    $details = $_POST['details'];

    $stmt = $conn->prepare("UPDATE menus SET product_name=?, price=?, category=?, image_url=?, details=? WHERE id=?");
    $stmt->bind_param("sdsssi", $name, $price, $category, $image_url, $details, $id);
    $stmt->execute();

    header("Location: manage-menus.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Dish</title>
  <style>
    body {
      font-family: Arial;
      padding: 20px;
      background: #f0f2f5;
    }
    form {
      background: white;
      padding: 20px;
      border-radius: 6px;
      max-width: 500px;
      margin: auto;
    }
    input, textarea, select {
      width: 100%;
      margin-bottom: 15px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    button {
      background: #007bff;
      color: white;
      border: none;
      padding: 10px 15px;
      border-radius: 5px;
    }
  </style>
</head>
<body>
  <h2>Edit Dish</h2>
  <form method="POST">
    <label>Dish Name:</label>
    <input type="text" name="product_name" value="<?= htmlspecialchars($dish['product_name']) ?>" required>

    <label>Price:</label>
    <input type="number" name="price" step="0.01" value="<?= $dish['price'] ?>" required>

    <label>Category:</label>
    <select name="category" required>
      <option value="Starters" <?= $dish['category'] == 'Starters' ? 'selected' : '' ?>>Starters</option>
      <option value="Lunch" <?= $dish['category'] == 'Lunch' ? 'selected' : '' ?>>Lunch</option>
      <option value="Dinner" <?= $dish['category'] == 'Dinner' ? 'selected' : '' ?>>Dinner</option>
      <option value="Dessert" <?= $dish['category'] == 'Dessert' ? 'selected' : '' ?>>Dessert</option>
    </select>

    <label>Image URL:</label>
    <input type="text" name="image_url" value="<?= htmlspecialchars($dish['image_url']) ?>">

    <label>Details:</label>
    <textarea name="details" required><?= htmlspecialchars($dish['details']) ?></textarea>

    <button type="submit">Update Dish</button>
  </form>
</body>
</html>
