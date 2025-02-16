<?php
session_start();
require 'includes/config.php';


if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch system stats
$stats_query = "SELECT 
    (SELECT COUNT(*) FROM users) AS total_users,
    (SELECT COUNT(*) FROM requisitions) AS total_requisitions,
    (SELECT COUNT(*) FROM requisitions WHERE status='Pending') AS pending_requisitions";

$stats_result = $con->query($stats_query);
$stats = $stats_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <?php
    require 'navbar.php';
    ?>

<div class="container mt-4">
    <h3>Admin Dashboard</h3>
    <div class="row">
        <div class="col-md-4"><div class="card bg-primary text-white"><div class="card-body">Total Users: <?= $stats['total_users'] ?></div></div></div>
        <div class="col-md-4"><div class="card bg-success text-white"><div class="card-body">Total Requisitions: <?= $stats['total_requisitions'] ?></div></div></div>
        <div class="col-md-4"><div class="card bg-warning text-dark"><div class="card-body">Pending Approvals: <?= $stats['pending_requisitions'] ?></div></div></div>
    </div>

    <h5 class="mt-4">Manage Users</h5>
    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Add New User</button>
    <table class="table table-bordered">
        <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Action</th></tr></thead>
        <tbody>
            <?php
            $user_query = "SELECT `id`, `full_name`, `email`,`department`, `role` FROM users";
            $users = $con->query($user_query);
            while ($user = $users->fetch_assoc()) { ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= htmlspecialchars($user['name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['department']) ?></td>
                    <td><?= ucfirst($user['role']) ?></td>
                    <td>
                    <button class='btn btn-sm btn-warning' data-bs-toggle='modal' data-bs-target='#editUserModal' data-id='{$Id}' data-firstname='{$firstname}' data-lastname='{$lastname}' data-email='{$email}' data-phone='{$phone}' data-role='{$role}' data-status='{$status}'>Edit</button>
                    <a href="delete_user.php?id=<?= $user['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="add_users.php" method="post">
                    <input type="hidden" name="action" value="add"> <!-- Add this line -->
                    <div class="mb-3">
                        <label for="username" class="form-label">Name</label>
                        <input type="text" name="username" class="form-control" id="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="useremail" class="form-label">Email</label>
                        <input type="email" name="useremail" class="form-control" id="useremail" required>
                    </div>
                    <div class="mb-3">
                        <label for="userrole" class="form-label">Role</label>
                        <select class="form-select" name="userrole" id="userrole">
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                            <option value="moderator">Moderator</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="deparment" class="form-label">Department</label>
                        <input type="email" name="deparment" class="form-control" id="deparment" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="manage-users.php" method="post">
                    <input type="hidden" name="action" value="update"> <!-- Add this line -->
                    <input type="hidden" name="id" id="editId">
                    <div class="mb-3">
                        <label for="editFirstName" class="form-label">First Name</label>
                        <input type="text" name="firstName" class="form-control" id="editFirstName" required>
                    </div>
                    <div class="mb-3">
                        <label for="editLastName" class="form-label">Last Name</label>
                        <input type="text" name="lastName" class="form-control" id="editLastName" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" name="userEmail" class="form-control" id="editEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPhoneNumber" class="form-label">Phone Number</label>
                        <input type="number" name="phoneNumber" class="form-control" id="editPhoneNumber" required>
                    </div>
                    <div class="mb-3">
                        <label for="editRole" class="form-label">Role</label>
                        <select class="form-select" name="userRole" id="editRole">
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                            <option value="moderator">Moderator</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editStatus" class="form-label">Status</label>
                        <select class="form-select" name="userStatus" id="editStatus">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<script>
        // Populate the edit modal with the user data
        var editUserModal = document.getElementById('editUserModal');
        editUserModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var userId = button.getAttribute('data-id');
            var firstName = button.getAttribute('data-firstname');
            var lastName = button.getAttribute('data-lastname');
            var email = button.getAttribute('data-email');
            var phone = button.getAttribute('data-phone');
            var role = button.getAttribute('data-role');
            var status = button.getAttribute('data-status');

            document.getElementById('editId').value = userId;
            document.getElementById('editFirstName').value = firstName;
            document.getElementById('editLastName').value = lastName;
            document.getElementById('editEmail').value = email;
            document.getElementById('editPhoneNumber').value = phone;
            document.getElementById('editRole').value = role;
            document.getElementById('editStatus').value = status;
        });
    </script>

</body>
</html>