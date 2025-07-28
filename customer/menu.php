<?php
include('../config/db.php');

// Fetch all menu items
$result = $conn->query("SELECT * FROM menus ORDER BY date_added DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Menu - TummyMealBox</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f2f2f2;
      margin: 0;
    }

    h2 {
      text-align: center;
      font-size: 32px;
      margin: 20px 0 10px;
      color: #333;
    }

    .filter-bar {
      text-align: center;
      margin-bottom: 20px;
    }

    .filter-bar button {
      padding: 10px 20px;
      margin: 5px;
      font-size: 16px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      background-color: #007bff;
      color: white;
    }

    .filter-bar button:hover {
      background-color: #0056b3;
    }

    .menu-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      padding: 20px;
    }

    .menu-card {
      background: #fff;
      border-radius: 10px;
      padding: 15px;
      text-align: center;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .menu-card img {
      width: 100%;
      height: 150px;
      object-fit: cover;
      border-radius: 8px;
    }

    .menu-card h3 {
      margin: 10px 0 5px;
      font-size: 20px;
    }

    .menu-card p {
      font-size: 14px;
      color: #555;
    }

    .menu-card span {
      display: block;
      margin: 10px 0;
      font-weight: bold;
      font-size: 18px;
    }

    .add-btn {
      padding: 10px;
      background: #28a745;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 15px;
      margin-top: 10px;
    }

    .add-btn:hover {
      background: #218838;
    }

    .qty-container {
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 10px 0;
    }

    .qty-container button {
      padding: 5px 10px;
      font-size: 18px;
      background: #007bff;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .qty-container span {
      margin: 0 10px;
      font-size: 18px;
      min-width: 20px;
      text-align: center;
    }
  </style>
</head>
<body>

  <h2>TummyMealBox Menu</h2>

  <!-- Filter -->
  <div class="filter-bar">
    <button onclick="filterCategory('All')">All</button>
    <button onclick="filterCategory('Starters')">Starters</button>
    <button onclick="filterCategory('Lunch')">Lunch</button>
    <button onclick="filterCategory('Dinner')">Dinner</button>
    <button onclick="filterCategory('Spices')">Spices</button>
  </div>

  <!-- Menu Items -->
  <div class="menu-grid" id="menuGrid">
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="menu-card" data-category="<?= $row['category'] ?>">
        <img src="<?= $row['image_url'] ?>" alt="<?= $row['product_name'] ?>">
        <h3><?= $row['product_name'] ?></h3>
        <p><?= $row['details'] ?></p>
        <span>₹<?= number_format($row['price'], 2) ?></span>

        <!-- Quantity -->
        <div class="qty-container">
          <button onclick="changeQty(<?= $row['id'] ?>, -1)">−</button>
          <span id="qty-<?= $row['id'] ?>">1</span>
          <button onclick="changeQty(<?= $row['id'] ?>, 1)">+</button>
        </div>

        <!-- Add -->
        <button class="add-btn" onclick='addToCart(<?= json_encode($row) ?>)'>Add to Cart</button>
      </div>
    <?php endwhile; ?>
  </div>
  <div style="text-align: center; margin-top: 30px;">
  <a href="checkout.php">
    <button style="
      padding: 12px 25px;
      background: #007bff;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
    ">
      Go to Checkout 🛒
    </button>
  </a>
</div>


  <script>
    let quantities = {};

    function changeQty(id, change) {
      if (!quantities[id]) quantities[id] = 1;
      quantities[id] += change;
      if (quantities[id] < 1) quantities[id] = 1;
      document.getElementById("qty-" + id).innerText = quantities[id];
    }

    function addToCart(item) {
      let cart = JSON.parse(localStorage.getItem("cart")) || [];
      const qty = quantities[item.id] || 1;
      const existing = cart.find(p => p.id === item.id);

      if (existing) {
        existing.qty += qty;
      } else {
        item.qty = qty;
        cart.push(item);
      }

      localStorage.setItem("cart", JSON.stringify(cart));
      alert(item.product_name + " added to cart!");
    }

    function filterCategory(category) {
      const cards = document.querySelectorAll('.menu-card');
      cards.forEach(card => {
        const itemCategory = card.getAttribute('data-category');
        if (category === 'All' || itemCategory === category) {
          card.style.display = 'block';
        } else {
          card.style.display = 'none';
        }
      });
    }
  </script>

</body>
</html>