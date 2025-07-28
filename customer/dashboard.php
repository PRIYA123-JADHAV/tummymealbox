<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Customer Dashboard</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
  <div class="form-container">
    <h2>Welcome, <?php echo $_SESSION['customer_name']; ?> 👋</h2>
    <p>You are successfully logged in.</p>
    <a href="logout.php">
      <button style="background-color: #dc3545;">Logout</button>
    </a>
  </div>
</body>
</html>
