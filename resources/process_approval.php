<?php
session_start();
require 'includes/config.php'; // Database connection file

// Ensure the user is logged in as a manager
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'manager') {
    header("Location: login.php");
    exit();
}

// Check if the request is valid
if (isset($_GET['id']) && isset($_GET['status'])) {
    $requisition_id = $_GET['id'];
    $status = $_GET['status'];
    $approver_id = $_SESSION['user_id'];

    // Update requisition status
    $stmt = $conn->prepare("UPDATE requisitions SET `status` = ? WHERE `id` = ?");
    $stmt->bind_param("si", $status, $requisition_id);
    $stmt->execute();

    // Insert approval record
    $stmt = $conn->prepare("INSERT INTO approvals (`requisition_id`, `approver_id`, `status`) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $requisition_id, $approver_id, $status);
    $stmt->execute();

    // Redirect back with a success message
    header("Location: dashboard_manager.php?success=Requisition " . ucfirst($status));
    exit();
} else {
    header("Location: dashboard_manager.php?error=Invalid Request");
    exit();
}
?>
