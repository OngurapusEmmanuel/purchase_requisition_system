<?php
function getRecordCount($table,$status) {
    global $con;
    $stmt = $con->prepare("SELECT COUNT(*) FROM $table WHERE `status`= $status");
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    return $count;
}
    ?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Purchase Requisition System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            padding-top: 20px;
        }
        .sidebar a {
            padding: 10px 15px;
            display: block;
            color: white;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .main-content {
            margin-left: 260px;
            padding: 20px;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h4 class="text-center text-light">Menu</h4>
    <a href="dashboard.html">Dashboard</a>
    <a href="requisition.html">New Requisition</a>
    <a href="view_requisition.html">Requisition History</a>
    <a href="approve_requisition.html">Approvals</a>
    <a href="logout.php">Logout</a>
</div>

<!-- Main Content -->
<div class="main-content">
    <h2>Dashboard</h2>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Pending Requisitions</div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo getRecordCount('approvals' , 'pending'); ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Approved Requisitions</div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo getRecordCount('approvals', 'approved'); ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger mb-3">
                <div class="card-header">Rejected Requisitions</div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo getRecordCount('approvals', 'rejected'); ?></h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Requisitions Table -->
    <div class="card">
        <div class="card-header">Recent Requisitions</div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Requisition ID</th>
                        <th>Requester</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>REQ001</td>
                        <td>John Doe</td>
                        <td>IT</td>
                        <td><span class="badge bg-warning">Pending</span></td>
                        <td><a href="view_requisition.php?id=1" class="btn btn-primary btn-sm">View</a></td>
                    </tr>
                    <tr>
                        <td>REQ002</td>
                        <td>Jane Smith</td>
                        <td>HR</td>
                        <td><span class="badge bg-success">Approved</span></td>
                        <td><a href="view_requisition.php?id=2" class="btn btn-primary btn-sm">View</a></td>
                    </tr>
                    <tr>
                        <td>REQ003</td>
                        <td>Michael Brown</td>
                        <td>Finance</td>
                        <td><span class="badge bg-danger">Rejected</span></td>
                        <td><a href="view_requisition.php?id=3" class="btn btn-primary btn-sm">View</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
