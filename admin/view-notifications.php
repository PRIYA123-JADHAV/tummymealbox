<?php
include(__DIR__ . '/../config/db.php');

$result = $conn->query("SELECT * FROM notifications ORDER BY sent_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Notification History</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      padding: 20px;
    }
    .container {
      max-width: 800px;
      margin: auto;
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }
    th, td {
      padding: 12px;
      border: 1px solid #ddd;
      text-align: left;
    }
    th {
      background: #007bff;
      color: white;
    }
    h2 {
      text-align: center;
    }
    a {
      display: inline-block;
      margin-top: 10px;
      text-decoration: none;
      color: #007bff;
    }
    
  </style>
</head>
<body>
  <div class="container">
    <h2>📨 Sent Notifications</h2>
    <table>
      <tr>
        <th>ID</th>
        <th>Message</th>
        <th>Sent At</th>
      </tr>
      <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['message']) ?></td>
        <td><?= $row['sent_at'] ?></td>
      </tr>
      <?php endwhile; ?>
    </table>
    <a href="send-notification.php">← Back to Send Notification</a>
  </div>
</body>
</html>
