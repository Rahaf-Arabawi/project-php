<?php
session_start(); // بدء الجلسة لإظهار رسائل التنبيه
include '../db_config.php'; // استيراد ملف اتصال قاعدة البيانات
$users = $conn->query("
    SELECT u.id, u.full_name, u.phone, u.email, u.address, u.role, u.created_at 
    FROM users u 
")->fetch_all(MYSQLI_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
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
<header>
    <!-- Sidebar -->
    <div class="sidebar">
    <div class="logo">
            <img src="../logofurniture.png" alt="Logo"> 
        </div>
        <ul>
            <li><a href="../index.php"><i class="fas fa-home"></i>Dashboard</a></li>
            <li><a href="#"><i class="fas fa-users"></i>User Management</a></li>
           
        </ul>
    </div>

    <div class="main-content">
        <h1>User Management</h1>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success"><?= $_SESSION['message'] ?></div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error"><?= $_SESSION['error'] ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <button onclick="openModal()" class="btn btn-add">Add New User</button>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Role</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= $user['full_name'] ?></td>
                        <td><?= $user['phone'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td><?= $user['address'] ?></td>
                        <td><?= ucfirst($user['role']) ?></td>
                        <td><?= $user['created_at'] ?></td>
                        <td class="botton">
                            <a href="javascript:void(0);" onclick="openEditModal(<?= $user['id'] ?>)" class="btn btn-edit">Edit</a>
                            <a href="process.php?action=delete&id=<?= $user['id'] ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal for adding a new user -->
    <div id="addUserModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Add New User</h2>
            <form action="process.php?action=add" method="POST">
                <label for="full_name">Full Name:</label>
                <input class="form input" type="text" id="full_name" name="full_name" required><br><br>
                <label for="phone">Phone:</label>
                <input class="form input" type="text" id="phone" name="phone" required><br><br>
                <label for="email">Email:</label>
                <input class="form input" type="email" id="email" name="email" required><br><br>
                <label for="address">Address:</label>
                <input class="form input" type="text" id="address" name="address" required><br><br>
                <label for="role">Role:</label>
                <select class="form input" id="role" name="role" required>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select><br><br>
                <label for="password">Password:</label>
                <input class="form input" type="password" id="password" name="password" required><br><br>
                <button type="submit" class="btn btn-add">Add</button>
            </form>
        </div>
    </div>

    <!-- Modal for editing a user -->
    <div id="editUserModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h2>Edit User</h2>
            <form id="editUserForm" action="process.php?action=edit" method="POST">
                <input class="form input" type="hidden" id="edit_id" name="id">
                <label for="edit_full_name">Full Name:</label>
                <input class="form input" type="text" id="edit_full_name" name="full_name" required><br><br>
                <label for="edit_phone">Phone:</label>
                <input class="form input" type="text" id="edit_phone" name="phone" required><br><br>
                <label for="edit_email">Email:</label>
                <input class="form input" type="email" id="edit_email" name="email" required><br><br>
                <label for="edit_address">Address:</label>
                <input class="form input" type="text" id="edit_address" name="address" required><br><br>
                <label for="edit_role">Role:</label>
                <select class="form input" id="edit_role" name="role" required>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select><br><br>
                <label for="edit_password">Password:</label>
                <input class="form input" type="password" id="edit_password" name="password"><br><br>
                <button type="submit" class="btn btn-edit">Save Changes</button>
            </form>
        </div>
    </div>

    <script>
        // Open the "Add New User" modal
        function openModal() {
            document.getElementById('addUserModal').style.display = 'flex';
        }

        // Close the "Add New User" modal
        function closeModal() {
            document.getElementById('addUserModal').style.display = 'none';
        }

        // Open the "Edit User" modal
        function openEditModal(userId) {
            fetch(`fetch_user.php?id=${userId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit_id').value = data.id;
                    document.getElementById('edit_full_name').value = data.full_name;
                    document.getElementById('edit_phone').value = data.phone;
                    document.getElementById('edit_email').value = data.email;
                    document.getElementById('edit_address').value = data.address;
                    document.getElementById('edit_role').value = data.role;

                   
                    document.getElementById('editUserForm').action = `process.php?action=edit&id=${data.id}`;

                    document.getElementById('editUserModal').style.display = 'flex';
                });
        }

        
        function closeEditModal() {
            document.getElementById('editUserModal').style.display = 'none';
        }
    </script>
</body>
</html>