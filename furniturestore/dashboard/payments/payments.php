<?php
include '../db_config.php'; // Include database connection file

// Fetch all payments from the database
$payments = $conn->query("
    SELECT p.id, p.payment_date, p.amount, p.payment_status, p.payment_method, o.id AS order_id
    FROM payments p
    LEFT JOIN orders o ON p.order_id = o.id
")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments Management</title>
    <link rel="stylesheet" href="../admin.css">
    <style>
        /* General Styles */
        body {
            margin: 0;
            font-family: 'Poppins', Arial, sans-serif;
            background-color: #F5F1E9;
            color: #6B4F4F;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }


        /* Sidebar Styles */
        .sidebar {
            width: 200px;
            background-color: #A6A88C; /* Olive Green */
            color: white;
            height: 100vh;
            position: fixed;
            top: 0px; /* Adjusted to fit below the navbar */
            left: 0;
            overflow-y: auto;
            transition: 0.3s ease-in-out;
        }
        .sidebar .logo img {
        max-width: 80%;
        height: auto;
         }
        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            padding: 15px;
            border-bottom: 1px solid #8F9079; /* Slightly Darker Olive */
            transition: background 0.3s;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .sidebar ul li a i {
            margin-right: 12px;
        }

        .sidebar ul li:hover {
            background-color: #8F9079; /* Darker Olive */
            cursor: pointer;
        }

        /* Main Content Styles */
        .main-content {
            margin-left: 250px; /* Adjusted for sidebar */
            margin-top: 0px; /* Adjusted for navbar */
            padding: 20px;
            flex: 1;
            transition: 0.3s ease-in-out;
        }

        /* Buttons */
        .botton{
            display: flex; 
            gap: 10px;
        }        
        
        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            background-color: #4CAF50;
            text-decoration: none;
            color: white;
            margin: 2px;
            
        }

        .btn-edit {
            background-color: #4CAF50;
        }

        .btn-edit:hover {
            background-color: #45a049;
        }

        .btn-delete {
            background-color: #f44336;
        }

        .btn-delete:hover {
            background-color: #d32f2f;
        }

        /* Alerts */
        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 14px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
     
        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #8B7355;
            font-weight: bold;
            color: white;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        /* Modal Styles */

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .close {
            float: right;
            cursor: pointer;
            font-size: 20px;
            font-weight: bold;
        }

        .close:hover {
            color: #f44336;
        }
        .form.input {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    transition: all 0.3s ease-in-out;
}

/* تحسين المظهر عند التركيز */
.form.input:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

/* تحسين مظهر القائمة المنسدلة */
.form.input select {
    appearance: none; /* إخفاء السهم الافتراضي */
    background-color: #fff;
    cursor: pointer;
}

/* تخصيص زر اختيار الصورة */
.form.input[type="file"] {
    border: none;
    background: #f9f9f9;
    padding: 5px;
    cursor: pointer;
}


 </style>
</head>
<body>

<div class="sidebar">
    <div class="logo">
            <img src="../logofurniture.png" alt="Logo"> 
        </div>
        <ul>
            <li><a href="../index.php"><i class="fas fa-home"></i>Dashboard</a></li>
            <li><a href="#"><i class="fas fa-users"></i>payments Management</a></li>
           
        </ul>
    </div>
    <div class="main-content">
        <h1>Payments Management</h1>
        <button onclick="openModal()" class="btn">Add New Payment</button>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Payment Date</th>
                    <th>Amount</th>
                    <th>Payment Status</th>
                    <th>Payment Method</th>
                    <th>Order ID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payments as $payment): ?>
                    <tr>
                        <td><?= $payment['id'] ?></td>
                        <td><?= $payment['payment_date'] ?></td>
                        <td>$<?= number_format($payment['amount'], 2) ?></td>
                        <td><?= $payment['payment_status'] ?></td>
                        <td><?= $payment['payment_method'] ?></td>
                        <td><?= $payment['order_id'] ?></td>
                        <td class="botton">
                            <a href="javascript:void(0);" onclick="openEditModal(<?= $payment['id'] ?>)" class="btn btn-edit">Edit</a>
                            <a href="process_payment.php?action=delete&id=<?= $payment['id'] ?>" class="btn btn-delete">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal for adding a new payment -->
    <div id="addPaymentModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Add New Payment</h2>
            <form action="process_payment.php?action=add" method="POST">
                <label for="payment_date">Payment Date:</label>
                <input  class="form input" type="date" id="payment_date" name="payment_date" required><br><br>
                <label for="amount">Amount:</label>
                <input  class="form input" type="number" id="amount" name="amount" step="0.01" required><br><br>
                <label for="payment_status">Payment Status:</label>
                <select  class="form input" id="payment_status" name="payment_status" required>
                    <option value="Paid">Paid</option>
                    <option value="Pending">Pending</option>
                    <option value="Failed">Failed</option>
                </select><br><br>
                <label for="payment_method">Payment Method:</label>
                <select  class="form input" id="payment_method" name="payment_method" required>
                    <option value="Credit Card">Credit Card</option>
                    <option value="PayPal">PayPal</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                    <option value="Cash">Cash</option>
                </select><br><br>
                <label for="order_id">Order ID:</label>
                <input  class="form input" type="number" id="order_id" name="order_id" required><br><br>
                <button type="submit" class="btn">Add</button>
            </form>
        </div>
    </div>

    <!-- Modal for editing a payment -->
    <div id="editPaymentModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h2>Edit Payment</h2>
            <form id="editPaymentForm" action="process_payment.php?action=edit&id=" method="POST">
                <input type="hidden" id="edit_id" name="id">
                <label for="edit_payment_date">Payment Date:</label>
                <input  class="form input" type="date" id="edit_payment_date" name="payment_date" required><br><br>
                <label for="edit_amount">Amount:</label>
                <input  class="form input" type="number" id="edit_amount" name="amount" step="0.01" required><br><br>
                <label for="edit_payment_status">Payment Status:</label>
                <select  class="form input" id="edit_payment_status" name="payment_status" required>
                    <option value="Paid">Paid</option>
                    <option value="Pending">Pending</option>
                    <option value="Failed">Failed</option>
                </select><br><br>
                <label for="edit_payment_method">Payment Method:</label>
                <select  class="form input" id="edit_payment_method" name="payment_method" required>
                    <option value="Credit Card">Credit Card</option>
                    <option value="PayPal">PayPal</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                    <option value="Cash">Cash</option>
                </select><br><br>
                <label for="edit_order_id">Order ID:</label>
                <input  class="form input" type="number" id="edit_order_id" name="order_id" required><br><br>
                <button type="submit" class="btn">Save Changes</button>
            </form>
        </div>
    </div>

    <script>
        // Open the "Add New Payment" modal
        function openModal() {
            document.getElementById('addPaymentModal').style.display = 'flex';
        }

        // Close the "Add New Payment" modal
        function closeModal() {
            document.getElementById('addPaymentModal').style.display = 'none';
        }

        // Open the "Edit Payment" modal
        function openEditModal(paymentId) {
            fetch(`fetch_payment.php?id=${paymentId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit_id').value = data.id;
                    document.getElementById('edit_payment_date').value = data.payment_date;
                    document.getElementById('edit_amount').value = data.amount;
                    document.getElementById('edit_payment_status').value = data.payment_status;
                    document.getElementById('edit_payment_method').value = data.payment_method;
                    document.getElementById('edit_order_id').value = data.order_id;
                    document.getElementById('editPaymentModal').style.display = 'flex';
                });
        }

        // Close the "Edit Payment" modal
        function closeEditModal() {
            document.getElementById('editPaymentModal').style.display = 'none';
        }

        // Close any modal when clicking outside
        window.onclick = function(event) {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>