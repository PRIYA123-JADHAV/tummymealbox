<?php
include(__DIR__ . '/../config/db.php');

// Handle deletion
if (isset($_GET['delete'])) {
  $id = intval($_GET['delete']);
  $conn->query("DELETE FROM feedback WHERE id = $id");
  header("Location: view-feedback.php");
  exit;
}

$result = $conn->query("SELECT * FROM feedback ORDER BY submitted_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>View Feedback & Reviews</title>
  <style>
    body {
      font-family: Arial;
      background: #f9f9f9;
    }
    .container {
      max-width: 1000px;
      margin: auto;
      padding: 30px;
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #ccc;
    }
    th {
      background-color: #007bff;
      color: #fff;
    }
    .delete-btn {
      color: red;
      text-decoration: none;
      font-weight: bold;
    }
    .delete-btn:hover {
      text-decoration: underline;
    }
    .back-btn {
      margin-top: 20px;
      display: inline-block;
      background: #007bff;
      color: #fff;
      padding: 10px 20px;
      text-decoration: none;
      border-radius: 5px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>📝 Customer Feedback & Reviews</h2>
    <table>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Mobile</th>
        <th>Email</th>
        <th>Message</th>
        <th>Submitted At</th>
        <th>Action</th>
      </tr>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= htmlspecialchars($row['mobile']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['message']) ?></td>
          <td><?= $row['submitted_at'] ?></td>
          <td><a class="delete-btn" href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this feedback?')">Delete</a></td>
        </tr>
      <?php endwhile; ?>
    </table>

    <a class="back-btn" href="dashboard.php">← Back to Dashboard</a>
  </div>
</body>
</html>
