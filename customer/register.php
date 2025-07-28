<?php
session_start();
include(__DIR__ . '/../config/db.php');

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $mobile = $_POST['mobile'];
  $email = $_POST['email'];
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // 🔐 hashed

  // Check if username exists
  $check = $conn->prepare("SELECT * FROM customers WHERE username = ?");
  $check->bind_param("s", $username);
  $check->execute();
  $res = $check->get_result();

  if ($res->num_rows > 0) {
    $message = "❌ Username already exists!";
  } else {
    $stmt = $conn->prepare("INSERT INTO customers (name, mobile, email, username, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $mobile, $email, $username, $password);
    if ($stmt->execute()) {
      echo "<script>alert('Registered Successfully! Please login.'); window.location.href = 'login.php';</script>";
      exit;
    } else {
      $message = "❌ Error while registering.";
    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
  <style>
    body {
      font-family: Arial;
      background: #f4f4f4;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    .box {
      background: white;
      padding: 30px;
      border-radius: 10px;
      width: 400px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      color: #007bff;
    }

    input {
      width: 100%;
      padding: 10px;
      margin-top: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    button {
      width: 100%;
      padding: 10px;
      background: #007bff;
      color: white;
      border: none;
      margin-top: 15px;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
    }

    .error {
      color: red;
      text-align: center;
    }
  </style>
</head>
<body>

<div class="box">
  <h2>Register</h2>
  <?php if ($message): ?>
    <div class="error"><?= $message ?></div>
  <?php endif; ?>
  <form method="post">
    <input type="text" name="name" placeholder="Full Name" required>
    <input type="text" name="mobile" placeholder="Mobile" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Register</button>
  </form>
</div>

</body>
</html>
