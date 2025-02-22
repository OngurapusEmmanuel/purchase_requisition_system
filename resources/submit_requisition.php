<?php
session_start();
require 'config.php'; // Database connection file

// Ensure the user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'employee') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $requester_id = $_SESSION['user_id'];
    $department = $_POST['department'];
    $justification = $_POST['justification'];
    $items = $_POST['items']; // Array of item details

    // Insert requisition
    $stmt = $con->prepare("INSERT INTO requisitions (requester_id, department, justification) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $requester_id, $department, $justification);
    $stmt->execute();
    $requisition_id = $stmt->insert_id; // Get the last inserted ID

    // Insert items
    $stmt = $con->prepare("INSERT INTO requisition_items (requisition_id, item_name, quantity, unit_price) VALUES (?, ?, ?, ?)");
    foreach ($items as $item) {
        $stmt->bind_param("isid", $requisition_id, $item['name'], $item['quantity'], $item['unit_price']);
        $stmt->execute();
    }

    header("Location: dashboard_employee.php?success=Requisition Submitted");
    exit();
}
?>