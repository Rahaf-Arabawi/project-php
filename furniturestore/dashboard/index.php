<?php
include 'db_config.php';

// Fetch data for the first chart (categories and their sales)
$sales_data = $conn->query("
    SELECT c.name AS category_name, COALESCE(SUM(op.quantity * op.price), 0) AS total_sales
    FROM categories c
    LEFT JOIN products p ON c.id = p.category_id
    LEFT JOIN orders_products op ON p.id = op.product_id
    GROUP BY c.name
")->fetch_all(MYSQLI_ASSOC);

// Fetch data for the second chart (products count by category)
$products_count_data = $conn->query("
    SELECT c.name AS category_name, COUNT(p.id) AS products_count
    FROM categories c
    LEFT JOIN products p ON c.id = p.category_id
    GROUP BY c.name
")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Logo -->
        <div class="logo">
            <img src="../imges/logofurniture.png" alt="Logo"> 
        </div>

        <ul>
            <li>
                <a href="../index.php">
                    <i class="fas fa-home"></i> 
                    <span>Home</span>
                </a>
            </li>
            <li>
                <a href="orders/orders.php">
                    <i class="fas fa-shopping-cart"></i> 
                    <span>Orders</span>
                </a>
            </li>
            <li>
                <a href="products/products.php">
                    <i class="fas fa-box-open"></i>
                    <span>Products</span>
                </a>
            </li>
            <li>
                <a href="users/users.php">
                    <i class="fas fa-users"></i> 
                    <span>Users</span>
                </a>
            </li>
            <li>
                <a href="payments/payments.php">
                    <i class="fas fa-credit-card"></i> 
                    <span>Payments</span>
                </a>
            </li>
            <li>
            <a href="catagories/categories.php">
                 <i class="fas fa-th"></i> 
                 <span>Categories</span>
            </a>

            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h1>Welcome to the Dashboard</h1>

        <!-- Quick Stats Section -->
        <div class="quick-stats">
            <div class="stat-card">
                <h2>Total Orders</h2>
                <p>
                    <?php
                    $result = $conn->query("SELECT COUNT(*) as total_orders FROM orders");
                    $row = $result->fetch_assoc();
                    echo $row['total_orders'];
                    ?>
                </p>
            </div>

            <div class="stat-card">
                <h2>Total Products</h2>
                <p>
                    <?php
                    $result = $conn->query("SELECT COUNT(*) as total_products FROM products");
                    $row = $result->fetch_assoc();
                    echo $row['total_products'];
                    ?>
                </p>
            </div>

            <div class="stat-card">
                <h2>Total Users</h2>
                <p>
                    <?php
                    $result = $conn->query("SELECT COUNT(*) as total_users FROM users");
                    $row = $result->fetch_assoc();
                    echo $row['total_users'];
                    ?>
                </p>
            </div>

            <div class="stat-card">
                <h2>Total Payments</h2>
                <p>
                    <?php
                    $result = $conn->query("SELECT COUNT(*) as total_payments FROM payments");
                    $row = $result->fetch_assoc();
                    echo $row['total_payments'];
                    ?>
                </p>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="chart-container">
            <canvas id="salesChart"></canvas>
        </div>

        <div class="chart-container">
            <canvas id="productsChart"></canvas>
        </div>
    </div>

    <!-- Chart Scripts -->
    <script>
        // First Chart: Sales by Category (Line Chart)
        const salesData = <?php echo json_encode($sales_data); ?>;
        const salesLabels = salesData.map(sale => sale.category_name);
        const salesValues = salesData.map(sale => sale.total_sales);

        const salesCtx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(salesCtx, {
            type: 'line', 
            data: {
                labels: salesLabels, 
                datasets: [{
                    label: 'Total Sales', 
                    data: salesValues,
                    borderColor: '#8B7355', // Brown
                    backgroundColor: 'rgba(139, 115, 85, 0.2)', // Light brown with transparency
                    borderWidth: 2 
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Sales by Category', 
                        font: {
                            size: 18
                        }
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Category Name', 
                            font: {
                                size: 14
                            }
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Total Sales', 
                            font: {
                                size: 14
                            }
                        },
                        beginAtZero: true 
                    }
                }
            }
        });

        // Second Chart: Products Count by Category (Bar Chart)
        const productsCountData = <?php echo json_encode($products_count_data); ?>;
        const productsCountLabels = productsCountData.map(product => product.category_name);
        const productsCountValues = productsCountData.map(product => product.products_count);

        const productsCtx = document.getElementById('productsChart').getContext('2d');
        const productsChart = new Chart(productsCtx, {
            type: 'bar', 
            data: {
                labels: productsCountLabels, 
                datasets: [{
                    label: 'Products Count', 
                    data: productsCountValues,
                    backgroundColor: '#6B8E23', // Olive green
                    borderColor: '#556B2F', // Darker olive green
                    borderWidth: 1 
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Products Count by Category', 
                        font: {
                            size: 18
                        }
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Category Name', 
                            font: {
                                size: 14
                            }
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Products Count', 
                            font: {
                                size: 14
                            }
                        },
                        beginAtZero: true 
                    }
                }
            }
        });
    </script>
</body>
</html>