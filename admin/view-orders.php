<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include(__DIR__ . '/../config/db.php');

$result = $conn->query("SELECT * FROM orders ORDER BY order_time ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Orders</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            background: #f8f9fa;
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
            background: #17a2b8;
            color: white;
        }

        tr:hover {
            background: #f1f1f1;
        }

        .status {
            font-weight: bold;
            padding: 6px 10px;
            border-radius: 6px;
        }

        .Placed {
            background: #e0f7fa;
            color: #007bff;
        }

        .Cancelled {
            background: #fdecea;
            color: #dc3545;
        }

        .Delivered {
            background: #e8f5e9;
            color: #28a745;
        }

        .back-btn {
            margin-top: 20px;
            display: inline-block;
            background: #17a2b8;
            color: white;
            padding: 8px 16px;
            border-radius: 5px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <h1>📦 Orders Overview</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Mobile</th>
                <th>Items</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Order Time</th>
            </tr>
        </thead>
        <tbody>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['customer_name']) ?></td>
            <td><?= htmlspecialchars($row['customer_mobile']) ?></td>
            <td><?= htmlspecialchars($row['items']) ?></td>
            <td>₹<?= number_format($row['total_price'], 2) ?></td>
            <td><span class="status <?= $row['status'] ?>"><?= $row['status'] ?></span></td>
            <td><?= $row['order_time'] ?></td>
            <td>
                <form method="POST" action="delete-order.php" onsubmit="return confirm('Are you sure you want to delete this order?');">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <button type="submit" style="background:#dc3545; color:#fff; border:none; padding:6px 10px; border-radius:5px; cursor:pointer;">Delete</button>
                </form>
            </td>
        </tr>
    <?php } ?>
</tbody>

    </table>

    <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>

</body>
</html>
