<?php
include('../config/db.php');

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="orders_report.csv"');

$output = fopen("php://output", "w");

// Column headers
fputcsv($output, ['ID', 'Customer Name', 'Mobile', 'Items', 'Total Price', 'Status', 'Order Time']);

$sql = "SELECT * FROM orders";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    fputcsv($output, [
        $row['id'],
        $row['customer_name'],
        $row['customer_mobile'],
        $row['items'],
        $row['total_price'],
        $row['status'],
        $row['order_time']
    ]);
}

fclose($output);
exit;
?>
