<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Requisition | Purchase Requisition System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
            margin-top: 50px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

    <?php
    require 'navbar.php';
?>

<div class="container">
    <h3 class="text-center">New Purchase Requisition</h3>
    <form action="submit_requisition.php" method="POST">
        <!-- Department -->
        <div class="mb-3">
            <label for="department" class="form-label">Department</label>
            <select class="form-control" id="department" name="department" required>
                <option value="">Select Department</option>
                <option value="IT">IT</option>
                <option value="HR">HR</option>
                <option value="Finance">Finance</option>
            </select>
        </div>

        <!-- Justification -->
        <div class="mb-3">
            <label for="justification" class="form-label">Justification</label>
            <textarea class="form-control" id="justification" name="justification" rows="3" required></textarea>
        </div>

        <!-- Items Table -->
        <h5>Requested Items</h5>
        <table class="table table-bordered" id="itemsTable">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" name="item_name[]" class="form-control" required></td>
                    <td><input type="number" name="quantity[]" class="form-control quantity" required></td>
                    <td><input type="number" name="unit_price[]" class="form-control unit-price" required></td>
                    <td><input type="text" name="total-price[]" class="form-control total-price" readonly></td>
                    <td><button type="button" class="btn btn-danger remove-row">X</button></td>
                </tr>
            </tbody>
        </table>

        <!-- Add Item Button -->
        <button type="button" class="btn btn-success" id="addItem">Add Item</button>

        <!-- Submit Buttons -->
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Submit Requisition</button>
            <button type="reset" class="btn btn-secondary">Clear</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Add New Row
        document.getElementById('addItem').addEventListener('click', function () {
            let table = document.getElementById('itemsTable').getElementsByTagName('tbody')[0];
            let newRow = table.insertRow();
            newRow.innerHTML = `
                <td><input type="text" name="item_name[]" class="form-control" required></td>
                <td><input type="number" name="quantity[]" class="form-control quantity" required></td>
                <td><input type="number" name="unit_price[]" class="form-control unit-price" required></td>
                <td><input type="text" class="form-control total-price" readonly></td>
                <td><button type="button" class="btn btn-danger remove-row">X</button></td>
            `;
        });

        // Remove Row
        document.addEventListener('click', function (event) {
            if (event.target.classList.contains('remove-row')) {
                event.target.closest('tr').remove();
            }
        });

        // Calculate Total Price
        document.addEventListener('input', function (event) {
            if (event.target.classList.contains('quantity') || event.target.classList.contains('unit-price')) {
                let row = event.target.closest('tr');
                let quantity = row.querySelector('.quantity').value;
                let unitPrice = row.querySelector('.unit-price').value;
                row.querySelector('.total-price').value = quantity * unitPrice;
            }
        });
    });
</script>

</body>
</html>
