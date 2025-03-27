<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sale Products - DECORA</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="icon" type="image/png" href="imges/logofurniture.png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>
<body>
  <?php include 'nav.php'; ?>

  <section class="sale-products">
    <h2>Products on Sale</h2>
    <div class="product-grid">
      <div class="product-card">
        <img src="imges/herosec1.png" alt="Sale Product 1" />
        <h3>Modern Sofa - 50% Off</h3>
        <p><del>$599.99</del> $299.99</p>
        <button>Add to Cart</button>
      </div>
      <div class="product-card">
        <img src="imges/Dining Chair 2.webp" alt="Sale Product 2" />
        <h3>Elegant Chair - 30% Off</h3>
        <p><del>$149.99</del> $104.99</p>
        <button>Add to Cart</button>
      </div>
      <div class="product-card">
        <img src="imges/Dining Table 2.webp" alt="Sale Product 3" />
        <h3>Wooden Table - 40% Off</h3>
        <p><del>$249.99</del> $149.99</p>
        <button>Add to Cart</button>
      </div>
    </div>
  </section>

  <?php include 'footer.php'; ?>
</body>
</html>