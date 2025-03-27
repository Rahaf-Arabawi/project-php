
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Products - DRCORA</title>
    <link rel="stylesheet" href="product.css" />
    <link rel="icon" type="image/png" href="imges/logofurniture.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>
<body>
    <?php include 'nav.php'; ?>
    <h2 class="mar">Our Products</h2>
    <div class="img">
        <section class="products">
            <!-- Wooden Chair -->
            <div class="product-grid">
                <div class="product-card">
                    <img src="imges/wedding chair .jpeg" alt="Product" 
                         onmouseover="this.src='imges/wedding chair2.jpeg'" 
                         onmouseout="this.src='imges/wedding chair .jpeg'" />
                    <h3>Wooden Chair</h3>
                    <p>$99.99</p>
                    <form action="cart.php" method="POST">
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="name" value="Wooden Chair">
                        <input type="hidden" name="price" value="99.99">
                        <input type="hidden" name="imges" value="imges/wedding chair .jpeg">
                        <button type="submit">Add to Cart</button>
                    </form>
                </div>
            </div>

            <!-- Sofa -->
            <div class="product-grid">
                <div class="product-card">
                    <img src="imges/sofa.jpeg" alt="product"
                         onmouseover="this.src='imges/sofa 2.jpeg'" 
                         onmouseout="this.src='imges/sofa.jpeg'" />
                    <h3>Sofa</h3>
                    <p>$49.99</p>
                    <form action="cart.php" method="POST">
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="name" value="Sofa">
                        <input type="hidden" name="price" value="49.99">
                        <input type="hidden" name="imges" value="imges/sofa.jpeg">
                        <button type="submit">Add to Cart</button>
                    </form>
                </div>
            </div>

            <!-- Outdoor Chair -->
            <div class="product-grid">
                <div class="product-card">
                    <img src="imges/outdoor.webp" alt="product"
                         onmouseover="this.src='imges/Outdoor Chair 2.jpeg'" 
                         onmouseout="this.src='imges/outdoor.webp'" />
                    <h3>Outdoor Chair</h3>
                    <p>$69.99</p>
                    <form action="cart.php" method="POST">
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="name" value="Outdoor Chair">
                        <input type="hidden" name="price" value="69.99">
                        <input type="hidden" name="imges" value="imges/outdoor.webp">
                        <button type="submit">Add to Cart</button>
                    </form>
                </div>
            </div>

            <!-- Coffee Table -->
            <div class="product-grid">
                <div class="product-card">
                    <img src="imges/Coffee Table.jpeg" alt="product"
                         onmouseover="this.src='imges/Coffee Table 2.jpeg'" 
                         onmouseout="this.src='imges/Coffee Table.jpeg'" />
                    <h3>Coffee Table</h3>
                    <p>$39.99</p>
                    <form action="cart.php" method="POST">
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="name" value="Coffee Table">
                        <input type="hidden" name="price" value="39.99">
                        <input type="hidden" name="imges" value="imges/Coffee Table.jpeg">
                        <button type="submit">Add to Cart</button>
                    </form>
                </div>
            </div>

            <!-- Dining Table -->
            <div class="product-grid">
                <div class="product-card">
                    <img src="imges/Dining Table.jpeg" alt="Product" 
                         onmouseover="this.src='imges/Dining Table 2.webp'" 
                         onmouseout="this.src='imges/Dining Table.jpeg'" />
                    <h3>Dining Table</h3>
                    <p>$89.99</p>
                    <form action="cart.php" method="POST">
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="name" value="Dining Table">
                        <input type="hidden" name="price" value="89.99">
                        <input type="hidden" name="imges" value="imges/Dining Table.jpeg">
                        <button type="submit">Add to Cart</button>
                    </form>
                </div>
            </div>

            <!-- Dining Chair -->
            <div class="product-grid">
                <div class="product-card">
                    <img src="imges/Dining Chair.jpeg" alt="Product"
                         onmouseover="this.src='imges/Dining Chair 2.webp'" 
                         onmouseout="this.src='imges/Dining Chair.jpeg'" />
                    <h3>Dining Chair</h3>
                    <p>$89.99</p>
                    <form action="cart.php" method="POST">
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="name" value="Dining Chair">
                        <input type="hidden" name="price" value="89.99">
                        <input type="hidden" name="imges" value="imges/Dining Chair.jpeg">
                        <button type="submit">Add to Cart</button>
                    </form>
                </div>
            </div>

            <!-- Office Chair -->
            <div class="product-grid">
                <div class="product-card">
                    <img src="imges/Office Chair.webp" alt="Product"
                         onmouseover="this.src='imges/Office Chair 2.webp'" 
                         onmouseout="this.src='imges/Office Chair.webp'" />
                    <h3>Office Chair</h3>
                    <p>$149.99</p>
                    <form action="cart.php" method="POST">
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="name" value="Office Chair">
                        <input type="hidden" name="price" value="149.99">
                        <input type="hidden" name="imges" value="imges/Office Chair.webp">
                        <button type="submit">Add to Cart</button>
                    </form>
                </div>
            </div>

            <!-- Bookshelf -->
            <div class="product-grid">
                <div class="product-card">
                    <img src="imges/Bookshelf.webp" alt="Product"
                         onmouseover="this.src='imges/Bookshelf 2.jpg'" 
                         onmouseout="this.src='imges/Bookshelf.webp'" />
                    <h3>Bookshelf</h3>
                    <p>$119.99</p>
                    <form action="cart.php" method="POST">
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="name" value="Bookshelf">
                        <input type="hidden" name="price" value="119.99">
                        <input type="hidden" name="imges" value="imges/Bookshelf.webp">
                        <button type="submit">Add to Cart</button>
                    </form>
                </div>
            </div>

            <!-- Desk Lamp -->
            <div class="product-grid">
                <div class="product-card">
                    <img src="imges/Desk Lamp.jpeg" alt="Product" 
                         onmouseover="this.src='imges/Desk Lamp 2.jpeg'" 
                         onmouseout="this.src='imges/Desk Lamp.jpeg'" />
                    <h3>Desk Lamp</h3>
                    <p>$59.99</p>
                    <form action="cart.php" method="POST">
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="name" value="Desk Lamp">
                        <input type="hidden" name="price" value="59.99">
                        <input type="hidden" name="imges" value="imges/Desk Lamp.jpeg">
                        <button type="submit">Add to Cart</button>
                    </form>
                </div>
            </div>

            <!-- Wardrobe -->
            <div class="product-grid">
                <div class="product-card">
                    <img src="imges/Wardrobe1.jpg" alt="Product"
                         onmouseover="this.src='imges/Wardrobe 2.jpg'" 
                         onmouseout="this.src='imges/Wardrobe1.jpg'" />
                    <h3>Wardrobe</h3>
                    <p>$89.99</p>
                    <form action="cart.php" method="POST">
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="name" value="Wardrobe">
                        <input type="hidden" name="price" value="89.99">
                        <input type="hidden" name="imges" value="imges/Wardrobe1.jpg">
                        <button type="submit">Add to Cart</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>