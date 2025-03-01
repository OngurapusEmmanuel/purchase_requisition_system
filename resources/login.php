<?php
include_once('sessions.php');
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    include_once ('includes/config.php');

    if ($con) {
        $stmt = $con->prepare("SELECT `user_id`, `full_name`, `password`, `role` FROM users WHERE `email` = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 0) {
            $_SESSION['error'] = "Email not found!";
            header("Location: login.php");
            exit();
        }

        $stmt->bind_result($id, $name, $hashed_password, $role);
        $stmt->fetch();
        
        if (!$password===$Password || !password_verify($password, $Password))
        {
           $_SESSION['error'] = "Invalid password!";
           header("Location: login.php");
           exit();
       }


       if ($Role === "admin" || $Role === "Admin") {
        $_SESSION['user_id'] = $id;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_role'] = $role;
        header("Location: admin-dashboard.php");
        exit();
    } elseif ($Role ==="manager"|| "Manager") {
        $_SESSION['user_id'] = $id;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_role'] = $role;
        header("Location: manager-dashboard.php");
        exit();
    }elseif ($Role ==="user"|| "User") {
        $_SESSION['user_id'] = $id;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_role'] = $role;
        header("Location: user-dashboard.php");
        exit();
    } else {
        $_SESSION['error'] = "Invalid role!";
        header("Location: login.php");
        exit();
    }

    } else {
        $_SESSION['error'] = "Database connection error!";
        header("Location: login.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Purchase Requisition System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            max-width: 400px;
            width: 100%;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            transition: 0.3s ease-in-out;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .form-control {
            border-radius: 5px;
        }
    </style>
</head>
<body>



<div class="login-container">
    <h4 class="text-center mb-4">Login to Your Account</h4>

    <form action="" method="post">
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" id="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
        <div class="text-center mt-3">
            <a href="#">Forgot Password?</a> | <a href="register.php">Register</a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
