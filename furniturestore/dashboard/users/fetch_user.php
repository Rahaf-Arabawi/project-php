<?php
include '../db_config.php'; // استيراد ملف اتصال قاعدة البيانات

// الحصول على معرف المستخدم من الرابط
$id = intval($_GET['id'] ?? 0); // تأمين قيمة المعرف

// جلب بيانات المستخدم من قاعدة البيانات
$query = "SELECT id, full_name, phone, email, address, role FROM users WHERE id = ?";
$stmt = $conn->prepare($query);

if ($stmt) {
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // إرجاع بيانات المستخدم كـ JSON
        echo json_encode($result->fetch_assoc());
    } else {
        // إذا لم يتم العثور على المستخدم
        echo json_encode(['error' => 'User not found']);
    }

    $stmt->close();
} else {
    // في حالة وجود خطأ في إعداد الاستعلام
    echo json_encode(['error' => 'Database query error']);
}

$conn->close();
?>