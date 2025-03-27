<?php
include 'db_config.php';

$search_query = $_GET['search_query'] ?? ''; // أخذ الكلمة المفتاحية من النموذج
$search_query = "%" . $search_query . "%"; // إضافة % للبحث الجزئي

$sql = "SELECT * FROM products WHERE name LIKE ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $search_query); // ربط المتغير مع الاستعلام
$stmt->execute();
$result = $stmt->get_result();

// عرض النتائج
if ($result->num_rows > 0) {
    echo "<h2>Search Results:</h2>";
    while ($row = $result->fetch_assoc()) {
        echo "<div class='product-grid'>";
        echo "<div class='product-card'>";
        echo "<img src='" . $row['image'] . "' alt='" . $row['name'] . "' />";
        echo "<h3>" . $row['name'] . "</h3>";
        echo "<p>" . "$" . $row['price'] . "</p>";
        echo "<form action='cart.php' method='POST'>";
        echo "<input type='hidden' name='action' value='add'>";
        echo "<input type='hidden' name='name' value='" . $row['name'] . "'>";
        echo "<input type='hidden' name='price' value='" . $row['price'] . "'>";
        echo "<input type='hidden' name='imges' value='" . $row['image'] . "'>";
        echo "<button type='submit'>Add to Cart</button>";
        echo "</form>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "<p>No products found</p>";
}

$conn->close();
?>