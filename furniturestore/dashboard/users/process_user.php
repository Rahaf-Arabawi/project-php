<?php
include '../db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_user'])) {
        $full_name = $_POST['full_name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $role = $_POST['role'];

        $sql = "INSERT INTO users (full_name, phone, email, address, role) 
                VALUES ('$full_name', '$phone', '$email', '$address', '$role')";
        if ($conn->query($sql)) {
            echo "<script>alert('User added successfully!'); window.location.href='users.php';</script>";
        } else {
            echo "<script>alert('Error adding user: " . $conn->error . "'); window.location.href='users.php';</script>";
        }
    } elseif (isset($_POST['edit_user'])) {
        $user_id = $_POST['user_id'];
        $full_name = $_POST['full_name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $role = $_POST['role'];

        $sql = "UPDATE users 
                SET full_name='$full_name', phone='$phone', email='$email', address='$address', role='$role' 
                WHERE id='$user_id'";
        if ($conn->query($sql)) {
            echo "<script>alert('User updated successfully!'); window.location.href='users.php';</script>";
        } else {
            echo "<script>alert('Error updating user: " . $conn->error . "'); window.location.href='users.php';</script>";
        }
    } elseif (isset($_POST['delete_user'])) {
        $user_id = $_POST['user_id'];

        $sql = "DELETE FROM users WHERE id='$user_id'";
        if ($conn->query($sql)) {
            echo "<script>alert('User deleted successfully!'); window.location.href='users.php';</script>";
        } else {
            echo "<script>alert('Error deleting user: " . $conn->error . "'); window.location.href='users.php';</script>";
        }
    }
}
?>