<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include(__DIR__ . '/../config/db.php');

$result = $conn->query("SELECT * FROM customers ORDER BY id asc");
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Customers</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            background: #f4f6f9;
            padding: 30px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        th {
            background: #007bff;
            color: white;
        }

        tr:hover {
            background: #f1f1f1;
        }

        .back-btn {
            margin-top: 20px;
            display: inline-block;
            background: #007bff;
            color: white;
            padding: 8px 16px;
            border-radius: 5px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <h1>👥 List of Customers</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Username</th>
                <th>Registered At</th>
            </tr>
        </thead>
      <tbody>
    <?php while ($row = $result->fetch_assoc()) {
        // Skip if essential fields are empty
        if (empty($row['name']) || empty($row['email']) || empty($row['mobile'])) continue;
    ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['mobile']) ?></td>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= $row['created_at'] ?? '—' ?></td>
        </tr>
    <?php } ?>
</tbody>

    </table>

    <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>

</body>
</html>
