<?php
include '../db_config.php'; // استيراد ملف اتصال قاعدة البيانات

$action = $_GET['action'] ?? ''; // تحديد الإجراء المطلوب
$id = $_GET['id'] ?? 0; // الحصول على معرف الدفعة

if ($action === 'add') {
    // إضافة دفعة جديدة
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $payment_date = trim($_POST['payment_date']);
        $amount = floatval($_POST['amount']);
        $payment_status = trim($_POST['payment_status']);
        $payment_method = trim($_POST['payment_method']);
        $order_id = intval($_POST['order_id']);

        // إدخال الدفعة في قاعدة البيانات
        $stmt = $conn->prepare("INSERT INTO payments (payment_date, amount, payment_status, payment_method, order_id) VALUES (?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sdssi", $payment_date, $amount, $payment_status, $payment_method, $order_id);
            if ($stmt->execute()) {
                header("Location: payments.php");
                exit;
            } else {
                echo "Error adding payment: " . $stmt->error;
            }
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    }
} elseif ($action === 'edit') {
    // تعديل الدفعة
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = intval($_POST['id']);
        $payment_date = trim($_POST['payment_date']);
        $amount = floatval($_POST['amount']);
        $payment_status = trim($_POST['payment_status']);
        $payment_method = trim($_POST['payment_method']);
        $order_id = intval($_POST['order_id']);

        // تحديث الدفعة في قاعدة البيانات
        $stmt = $conn->prepare("UPDATE payments SET payment_date=?, amount=?, payment_status=?, payment_method=?, order_id=? WHERE id=?");
        if ($stmt) {
            $stmt->bind_param("sdssii", $payment_date, $amount, $payment_status, $payment_method, $order_id, $id);
            if ($stmt->execute()) {
                header("Location: payments.php");
                exit;
            } else {
                echo "Error updating payment: " . $stmt->error;
            }
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    }
} elseif ($action === 'delete') {
    // حذف الدفعة
    $id = intval($id); // تأمين قيمة المعرف
    $stmt = $conn->prepare("DELETE FROM payments WHERE id=?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            header("Location: payments.php");
            exit;
        } else {
            echo "Error deleting payment: " . $stmt->error;
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}
?>