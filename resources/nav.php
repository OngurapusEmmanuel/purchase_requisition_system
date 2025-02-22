<?php
// session_start();
// $user_role = $_SESSION['user_role'] ?? 'guest';
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Purchase Requisition</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php if ($user_role === 'employee') { ?>
                    <li class="nav-item"><a class="nav-link" href="dashboard_employee.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="requisition.php">New Requisition</a></li>
                <?php } elseif ($user_role === 'manager') { ?>
                    <li class="nav-item"><a class="nav-link" href="dashboard_manager.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="pending_requisitions.php">Pending Requests</a></li>
                    <li class="nav-item"><a class="nav-link" href="approve_requisition.html">Approvals</a></li>
                   <li class="nav-item"><a class="nav-link" href="view_requisition.html">Requisition History</a></li>
                <?php } elseif ($user_role === 'admin') { ?>
                    <li class="nav-item"><a class="nav-link" href="dashboard_admin.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage_users.php">Manage Users</a></li>
                    <li class="nav-item"><a class="nav-link" href="view_requisition.html">Requisition History</a></li>
                <?php } ?>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>