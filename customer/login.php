<?php
session_start();
include(__DIR__ . '/../config/db.php');

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM customers WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Debug: Print hashed password
    // echo "Stored hash: " . $user['password'];

    if (password_verify($password, $user['password'])) {
      $_SESSION['customer_id'] = $user['id'];
      $_SESSION['customer_name'] = $user['name'];

      echo "<script>
        alert('Login Successful!');
        window.location.href = 'menu.php';
      </script>";
    } else {
      $message = "❌ Invalid password!";
    }
  } else {
    $message = "❌ User not found!";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Customer Login</title>
  <style>
    body {
      background: #f4f4f4;
      font-family: Arial;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    .login-box {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      width: 350px;
    }

    h2 {
      text-align: center;
      color: #28a745;
    }

    input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    button {
      width: 100%;
      padding: 10px;
      background: #28a745;
      color: white;
      border: none;
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

  <div class="login-box">
    <h2>Login</h2>
    <?php if ($message): ?>
      <div class="error"><?= $message ?></div>
    <?php endif; ?>
    <form method="post">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
  </div>

</body>
</html>
