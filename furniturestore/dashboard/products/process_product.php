<?php
include '../db_config.php'; // استيراد ملف اتصال قاعدة البيانات

$action = $_GET['action'] ?? ''; // تحديد الإجراء المطلوب
$id = $_GET['id'] ?? 0; // الحصول على معرف المنتج

if ($action === 'add') {
    // إضافة منتج جديد
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = trim($_POST['name']);
        $price = floatval($_POST['price']);
        $stock = intval($_POST['stock']);
        $category_id = intval($_POST['category_id']);
        $supplier_id = intval($_POST['supplier_id']);

        // تحميل الصورة
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../uploads/'; // المجلد الذي سيتم حفظ الصور فيه
            $uploadFile = $uploadDir . basename($_FILES['image']['name']);

            // نقل الملف إلى المجلد المحدد
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                $image = basename($_FILES['image']['name']);
            } else {
                echo "Failed to upload image!";
                exit;
            }
        } else {
            echo "Image is required or there was an error uploading the image!";
            exit;
        }

        // إدخال المنتج في قاعدة البيانات
        $stmt = $conn->prepare("INSERT INTO products (name, price, stock_quantity, category_id, supplier_id, image) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sdiiss", $name, $price, $stock, $category_id, $supplier_id, $image);
            if ($stmt->execute()) {
                header("Location: products.php");
                exit;
            } else {
                echo "Error adding product: " . $stmt->error;
            }
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    }
} elseif ($action === 'edit') {
    // تعديل المنتج
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = intval($_POST['id']);
        $name = trim($_POST['name']);
        $price = floatval($_POST['price']);
        $stock = intval($_POST['stock']);
        $category_id = intval($_POST['category_id']);
        $supplier_id = intval($_POST['supplier_id']);

        // تحديث الصورة إذا تم تحميل صورة جديدة
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../uploads/';
            $uploadFile = $uploadDir . basename($_FILES['image']['name']);

            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                $image = basename($_FILES['image']['name']);
                $stmt = $conn->prepare("UPDATE products SET name=?, price=?, stock_quantity=?, category_id=?, supplier_id=?, image=? WHERE id=?");
                if ($stmt) {
                    $stmt->bind_param("sdiissi", $name, $price, $stock, $category_id, $supplier_id, $image, $id);
                } else {
                    echo "Error preparing statement: " . $conn->error;
                    exit;
                }
            } else {
                echo "Failed to upload image!";
                exit;
            }
        } else {
            $stmt = $conn->prepare("UPDATE products SET name=?, price=?, stock_quantity=?, category_id=?, supplier_id=? WHERE id=?");
            if ($stmt) {
                $stmt->bind_param("sdiisi", $name, $price, $stock, $category_id, $supplier_id, $id);
            } else {
                echo "Error preparing statement: " . $conn->error;
                exit;
            }
        }

        if ($stmt->execute()) {
            header("Location: products.php");
            exit;
        } else {
            echo "Error updating product: " . $stmt->error;
        }
    }
} elseif ($action === 'delete') {
    // حذف المنتج
    $id = intval($id); // تأمين قيمة المعرف
    $stmt = $conn->prepare("DELETE FROM products WHERE id=?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            header("Location: products.php");
            exit;
        } else {
            echo "Error deleting product: " . $stmt->error;
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}
?>