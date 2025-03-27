<?php
session_start(); // بدء الجلسة لإظهار رسائل التنبيه
include '../db_config.php'; // استيراد ملف اتصال قاعدة البيانات

$action = $_GET['action'] ?? ''; // تحديد الإجراء المطلوب
$id = $_GET['id'] ?? 0; // الحصول على معرف المستخدم

if ($action === 'add') {
    // إضافة مستخدم جديد
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $full_name = trim($_POST['full_name']);
        $phone = trim($_POST['phone']);
        $email = trim($_POST['email']);
        $address = trim($_POST['address']);
        $role = trim($_POST['role']);
        $password = trim($_POST['password']);

        // التحقق من الحقول الفارغة
        if (empty($full_name) || empty($phone) || empty($email) || empty($address) || empty($role) || empty($password)) {
            $_SESSION['error'] = "All fields are required!";
            header("Location: users.php");
            exit;
        }

        // التحقق من تنسيق البريد الإلكتروني
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Invalid email format!";
            header("Location: users.php");
            exit;
        }

        // تشفير كلمة المرور
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // إدخال المستخدم في قاعدة البيانات
        $stmt = $conn->prepare("INSERT INTO users (full_name, phone, email, address, role, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $full_name, $phone, $email, $address, $role, $password_hash);
        if ($stmt->execute()) {
            $_SESSION['message'] = "User added successfully!";
        } else {
            $_SESSION['error'] = "Error adding user: " . $stmt->error;
        }

        header("Location: users.php");
        exit;
    }
} elseif ($action === 'edit') {
    // تعديل المستخدم
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = intval($_POST['id']);
        $full_name = trim($_POST['full_name']);
        $phone = trim($_POST['phone']);
        $email = trim($_POST['email']);
        $address = trim($_POST['address']);
        $role = trim($_POST['role']);
        $password = trim($_POST['password']);

        // التحقق من الحقول الفارغة
        if (empty($full_name) || empty($phone) || empty($email) || empty($address) || empty($role)) {
            $_SESSION['error'] = "All fields are required!";
            header("Location: users.php");
            exit;
        }

        // التحقق من تنسيق البريد الإلكتروني
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Invalid email format!";
            header("Location: users.php");
            exit;
        }

        // بناء الاستعلام لتحديث البيانات
        $query = "UPDATE users SET full_name=?, phone=?, email=?, address=?, role=?";
        $params = [$full_name, $phone, $email, $address, $role];

        // إذا كانت كلمة المرور غير فارغة، نقوم بتحديثها أيضًا
        if (!empty($password)) {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $query .= ", password=?";
            $params[] = $password_hash;
        }

        // إضافة شرط WHERE
        $query .= " WHERE id=?";
        $params[] = $id;

        // تحضير الاستعلام وتنفيذ التحديث
        $stmt = $conn->prepare($query);
        $stmt->bind_param(str_repeat('s', count($params) - 1) . 'i', ...$params);

        // التحقق من نجاح الاستعلام
        if ($stmt->execute()) {
            $_SESSION['message'] = "User updated successfully!";
        } else {
            $_SESSION['error'] = "Failed to update user: " . $stmt->error;
        }

        header("Location: users.php");
        exit;
    }
} elseif ($action === 'delete') {

    $id = intval($id); 
    $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['message'] = "User deleted successfully!";
    } else {
        $_SESSION['error'] = "Failed to delete user: " . $stmt->error;
    }

    header("Location: users.php");
    exit;
}
?>