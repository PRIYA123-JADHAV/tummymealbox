<!DOCTYPE html>
<html>
<head>
  <title>Checkout</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f3f3f3;
      margin: 0;
      padding: 20px;
    }

    h2 {
      text-align: center;
    }

    table {
      width: 100%;
      background: #fff;
      border-collapse: collapse;
      margin: 20px auto;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    th, td {
      padding: 12px 15px;
      text-align: center;
      border: 1px solid #ddd;
    }

    th {
      background-color: #f8f8f8;
    }

    input {
      padding: 10px;
      width: 100%;
      margin: 10px 0;
    }

    #placeOrderBtn {
      display: block;
      margin: 20px auto;
      padding: 12px 30px;
      font-size: 16px;
      background-color: #28a745;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    #placeOrderBtn:hover {
      background-color: #218838;
    }

    .message {
      text-align: center;
      color: red;
      margin-top: 10px;
    }
  </style>
</head>
<body>

  <h2>Checkout</h2>

  <form id="orderForm">
    <input type="text" name="name" placeholder="Your Name" required>
    <input type="text" name="mobile" placeholder="Mobile Number" required pattern="\d{10}">
    <input type="hidden" name="latitude" id="latitude">
    <input type="hidden" name="longitude" id="longitude">

    <table>
      <thead>
        <tr>
          <th>Dish</th>
          <th>Price</th>
          <th>Qty</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody id="cartTableBody">
        <tr>
          <td colspan="3"><strong>Grand Total</strong></td>
          <td id="grandTotal">₹0.00</td>
        </tr>
      </tbody>
    </table>

    <button type="submit" id="placeOrderBtn">Place Order</button>
  </form>

  <div class="message" id="message"></div>

  <script>
    function renderCart() {
      const cart = JSON.parse(localStorage.getItem("cart")) || [];
      const tbody = document.getElementById("cartTableBody");
      let grandTotal = 0;

      cart.forEach(item => {
        const price = Number(item.price);
        const qty = Number(item.qty);
        const total = price * qty;
        grandTotal += total;

        const row = document.createElement("tr");
        row.innerHTML = `
          <td>${item.product_name}</td>
          <td>₹${price.toFixed(2)}</td>
          <td>${qty}</td>
          <td>₹${total.toFixed(2)}</td>
        `;
        tbody.insertBefore(row, tbody.lastElementChild);
      });

      document.getElementById("grandTotal").innerText = "₹" + grandTotal.toFixed(2);
    }

    document.getElementById("orderForm").addEventListener("submit", function(e) {
      e.preventDefault();
      const form = e.target;
      const name = form.name.value.trim();
      const mobile = form.mobile.value.trim();
      const cart = JSON.parse(localStorage.getItem("cart")) || [];

      if (!name || !mobile || cart.length === 0) {
        document.getElementById("message").innerText = "❌ Please fill all fields and add items to cart.";
        return;
      }

      if (!navigator.geolocation) {
        alert("❌ Geolocation is not supported by your browser.");
        return;
      }

      navigator.geolocation.getCurrentPosition(position => {
        const lat = position.coords.latitude;
        const lng = position.coords.longitude;

        const formData = new FormData();
        formData.append("name", name);
        formData.append("mobile", mobile);
        formData.append("latitude", lat);
        formData.append("longitude", lng);
        formData.append("cart", JSON.stringify(cart));

        fetch("place-order.php", {
          method: "POST",
          body: formData
        })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            localStorage.removeItem("cart");
            window.location.href = "thankyou.php";
          } else {
            document.getElementById("message").innerText = "❌ " + data.message;
          }
        })
        .catch(() => {
          document.getElementById("message").innerText = "❌ Something went wrong.";
        });

      }, error => {
        alert("⚠️ Location access denied. Please allow location permission.");
      });
    });

    renderCart();
  </script>

</body>
</html>
