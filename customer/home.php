<!DOCTYPE html>
<html>
<head>
  <title>Welcome to TummyMealBox</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(to right, #f8f9fa, #e8f5e9);
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 600px;
      margin: 80px auto;
      text-align: center;
      background: #ffffff;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }

    h1 {
      color: #28a745;
      margin-bottom: 20px;
    }

    p {
      font-size: 18px;
      color: #333;
    }

    .btn {
      display: inline-block;
      margin: 15px 10px;
      padding: 12px 25px;
      font-size: 16px;
      color: white;
      background-color: #007bff;
      border: none;
      border-radius: 6px;
      text-decoration: none;
      transition: background-color 0.3s ease;
    }

    .btn:hover {
      background-color: #0056b3;
    }

    .btn.green {
      background-color: #28a745;
    }

    .btn.green:hover {
      background-color: #218838;
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>Welcome to TummyMealBox 🍽️</h1>
    <p>Delicious food delivered with love!</p>
    <a href="login.php" class="btn">Login</a>
    <a href="register.php" class="btn green">Register</a>
    
  </div>

</body>
</html>
