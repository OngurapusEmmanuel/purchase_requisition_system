<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $department=$_POST['department'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO users (`full_name`, `email`,`department`, `role`,`password`) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email,$department, $role, $password);
    if ($stmt->execute()) {
        header("Location: dashboard_admin.php?success=User added");
    } else {
        echo "Error adding user.";
    }
}
?>