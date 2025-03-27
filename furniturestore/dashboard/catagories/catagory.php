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
    <title>Categories Management</title>
    <link rel="stylesheet" href="../admin.css">
    <style>
        /* Modal styles */
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
        }
        .close {
            float: right;
            cursor: pointer;
        }

        .btn a {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
            text-decoration: none;
            color: white;
            margin: 2px;
        }

        /* زر Edit */
        .btn-edit {
            background-color: #4CAF50; 
        }

        .btn-edit:hover {
            background-color: #45a049;
        }

        /* زر Delete */
        .btn-delete {
            background-color: #f44336;
        }

        .btn-delete:hover {
            background-color: #d32f2f; 
        }
    </style>
</head>
<body>
    <div class="main-content">
        <h1>Categories Management</h1>
        <button onclick="openModal()" class="btn">Add New Category</button>
        <table>
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
                        <td>
                            <a href="javascript:void(0);" onclick="openEditModal(<?= $category['id'] ?>)" class="btn-edit">Edit</a>
                            <a href="process_category.php?action=delete&id=<?= $category['id'] ?>" class="btn-delete">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal for adding/editing categories -->
    <div id="categoryModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle">Add New Category</h2>
            <form id="categoryForm" action="process_category.php?action=add" method="POST">
                <input type="hidden" id="category_id" name="id">
                <label for="name">Category Name:</label>
                <input type="text" id="name" name="name" required><br><br>
                <button type="submit" class="btn">Save</button>
            </form>
        </div>
    </div>

    <script>
        // JavaScript for opening/closing modal and populating edit form
        function openModal() {
            document.getElementById('categoryModal').style.display = 'flex';
            document.getElementById('modalTitle').innerText = 'Add New Category';
            document.getElementById('categoryForm').action = 'process_category.php?action=add';
        }

        function openEditModal(categoryId) {
            fetch(`fetch_category.php?id=${categoryId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('category_id').value = data.id;
                    document.getElementById('name').value = data.name;
                    document.getElementById('modalTitle').innerText = 'Edit Category';
                    document.getElementById('categoryForm').action = `process_category.php?action=edit&id=${data.id}`;
                    document.getElementById('categoryModal').style.display = 'flex';
                });
        }

        function closeModal() {
            document.getElementById('categoryModal').style.display = 'none';
        }
    </script>
</body>
</html>