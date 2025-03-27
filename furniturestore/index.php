<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DECORA - Home</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="icon" type="image/png" href="imges/logofurniture.png" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
  </head>
  <body>
    
   <?php include 'nav.php'; ?>

    
    <section class="hero">
      <div class="hero-card">
        <h2>Find Your Perfect Furniture</h2>
        <p>Best quality furniture at affordable prices.</p>
        <button onclick="window.location.href='product.php'">Shop Now</button>
      </div>
    </section>
    <section class="featured-products">
      <h2>Featured Products</h2>
      <div class="product-grid">
        <div class="product-card">
          <img src="imges/sofa.jpeg" alt="Sofa" />
          <h3>Modern Sofa</h3>
          <p>$299.99</p>
        </div>
        <div class="product-card">
          <img src="imges/product2.jpg" alt="Chair" />
          <h3>Elegant Chair</h3>
          <p>$99.99</p>
         
        </div>
        <div class="product-card">
          <img src="imges/product3.jpeg" alt="Table" />
          <h3>Wooden Table</h3>
          <p>$149.99</p>
         
        </div>
      </div>
    </section>

    <!-- ✅ Promotional Banner -->
    <section class="promo-banner">
  <div class="promo-content">
    <h2><i class="fas fa-gift"></i> Special Discount - Up to 50% Off!</h2>
    <p>Hurry, limited time offer.</p>
    <button onclick="window.location.href='sale-products.php'">
      <i class="fas fa-arrow-right"></i> Shop Now
    </button>
  </div>
</section>
<!-- ✅ Best Sellers Section -->
<section class="best-sellers">
  <h2>Best Sellers</h2>
  <div class="product-grid">
    <div class="product-card">
      <img src="imges/Wardrobe 2.jpg" alt="Best Seller 1" />
      <h3>warddrobe</h3>
      <p>$499.99</p>
     
    </div>
    <div class="product-card">
      <img src="imges/outdoor.webp" alt="Best Seller 2" />
      <h3>outdoor_chair</h3>
      <p>$99.00</p>
     
    </div>
    <div class="product-card">
      <img src="imges/Dining Table.jpeg" alt="Best Seller 3" />
      <h3>Classic Dining Table</h3>
      <p>$349.99</p>
   
    </div>
  </div>
</section>
    <!-- ✅ Contact Us -->
   <div class="contact-wrapper">
    <!-- قسم Contact Us -->
    <div class="contact">
        <h2>Contact Us</h2>
        <form>
            <input type="text" placeholder="Your Name" required />
            <input type="email" placeholder="Your Email" required />
            <textarea placeholder="Your Message" required></textarea>
            <button type="submit">Send Message</button>
        </form>
    </div>

    <!-- قسم Location -->
    <div class="location">
        <h2>Location</h2>
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12345.678901234567!2d-104.99012345678901!3d39.73912345678901!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMznCsDQ0JzIwLjgiTiAxMDTCsDU5JzA1LjEiVw!5e0!3m2!1sen!2sus!4v1622541234567!5m2!1sen!2sus"
            width="50%"
            height="300"
            style="border:0;"
            allowfullscreen=""
            loading="lazy">
        </iframe>
    </div>
</div>

    <?php include 'footer.php'; ?>
    <script src="script.js"></script>
  </body>
</html>
