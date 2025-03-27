<?php
include '../db_config.php'; // استيراد ملف اتصال قاعدة البيانات

// جلب جميع الفئات من قاعدة البيانات
$categories = $conn->query("SELECT * FROM categories")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management</title>
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


.form.input:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}


.form.input select {
    appearance: none; 
    background-color: #fff;
    cursor: pointer;
}


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
            <li><a href="#"><i class="fas fa-users"></i>categories Management</a></li>
           
        </ul>
    </div>

    <div class="main-content">
        <h1>Category Management</h1>
        <button onclick="openModal()" class="btn">Add New Category</button>
        <table >
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?= $category['id'] ?></td>
                        <td><?= $category['name'] ?></td>
                        <td class="botton">
                            <a href="javascript:void(0);" onclick="openEditModal(<?= $category['id'] ?>)" class="btn btn-edit">Edit</a>
                            <a href="process_category.php?action=delete&id=<?= $category['id'] ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Window -->
    <div id="categoryModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle">Add New Category</h2>
            <form id="categoryForm" action="process_category.php" method="POST">
                <input type="hidden" id="category_id" name="id">
                <input type="hidden" name="action" id="formAction" value="add">
                <label for="name">Category Name:</label>
                <input class="form input" type="text" id="name" name="name" required><br><br>
                <button type="submit" class="btn">Save</button>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('category_id').value = '';
            document.getElementById('name').value = '';
            document.getElementById('modalTitle').innerText = 'Add New Category';
            document.getElementById('formAction').value = 'add';
            document.getElementById('categoryModal').style.display = 'flex';
        }

        function openEditModal(categoryId) {
            fetch(`fetch_category.php?id=${categoryId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert("Error: " + data.error);
                        return;
                    }
                    document.getElementById('category_id').value = data.id;
                    document.getElementById('name').value = data.name;
                    document.getElementById('modalTitle').innerText = 'Edit Category';
                    document.getElementById('formAction').value = 'edit';
                    document.getElementById('categoryModal').style.display = 'flex';
                })
                .catch(error => console.error("Error fetching data:", error));
        }

        function closeModal() {
            document.getElementById('categoryModal').style.display = 'none';
            document.getElementById('categoryForm').reset();
        }
    </script>

</body>
</html>