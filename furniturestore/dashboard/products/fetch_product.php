<?php
include '../db_config.php'; // استيراد ملف اتصال قاعدة البيانات

// الحصول على معرف المنتج من الرابط
$id = intval($_GET['id'] ?? 0); // تأمين قيمة المعرف

// جلب بيانات المنتج من قاعدة البيانات
$query = "SELECT id, name, price, stock_quantity, category_id, supplier_id, image FROM products WHERE id = ?";
$stmt = $conn->prepare($query);

if ($stmt) {
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // إرجاع بيانات المنتج كـ JSON
        echo json_encode($result->fetch_assoc());
    } else {
        // إذا لم يتم العثور على المنتج
        echo json_encode(['error' => 'Product not found']);
    }

    $stmt->close();
} else {
    // في حالة وجود خطأ في إعداد الاستعلام
    echo json_encode(['error' => 'Database query error']);
}

$conn->close();
?>