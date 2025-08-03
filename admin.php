<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin User Control Panel | GlobeTrotter Store</title>
  <meta name="description" content="Access the GlobeTrotter Store Admin Panel to manage users, roles, and permissions. Monitor activity and maintain secure administrative control over the system.">
  <meta name="keywords" content="admin dashboard, user management, GlobeTrotter admin, admin panel, control panel, user roles, access control">
  <meta name="author" content="GlobeTrotter Admin Team">
  <link rel="stylesheet" href="styles.css">
  <link id="themeStylesheet" rel="stylesheet" href="css/theme-light.css" />
  <script src="scripts.js" defer></script>
  <script src="auth.js" defer></script>
  <script src="theme.js" defer></script>
  <style>
    h1 {
      text-align: center;
    }
    .admin-section {
      max-width: 1000px;
      margin: auto;
      padding: 1.5rem;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      margin-top: 2rem;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      padding: 0.75rem;
      border: 1px solid #ccc;
      text-align: left;
    }

    button {
      padding: 0.4rem 0.8rem;
      border: none;
      background: #007bff;
      color: white;
      border-radius: 4px;
      cursor: pointer;
    }
    button:hover {
      background: #0056b3;
    }
  </style>
</head>
<body>
    <header>
    <h1>GlobeTrotter Store</h1>
    <nav>
    <ul>
      <li><a href="homepage.html">Home</a></li>
      <li><a href="newsletter.html">Newsletter</a></li>
      <li><a href="products.html">Products</a></li>
      <li><a href="cart.html">Cart</a></li>
      <li><a href="orders.html">My Orders</a></li>
      <li><a href="about.html">About</a></li>
      <li><a href="help.html">Help</a></li>
      <li><a href="monitor.html">Monitor</a></li>
      <li><a href="admin.php">Admin</a></li>
      <!-- This will be injected dynamically by auth.js -->
    <li id="login-logout" style="display:none;"></li>

      <li><a href="register.html">Register</a></li>
    </ul>
    <select id="themeSelect">
        <option value="theme-light.css">Light</option>
        <option value="theme-dark.css">Dark</option>
        <option value="theme-blue.css">Blue</option>
    </select>
  </nav>
  </header>

  <h1>Admin Control Panel</h1>

  <div class="admin-section">
    <h2>Manage Products</h2>
    <?php
    $conn = new mysqli("localhost", "globetro_sohilw", "testing@#$", "globetro_products");
    if ($conn->connect_error) die("DB error: " . $conn->connect_error);
    $result = $conn->query("SELECT * FROM products");
    echo "<table><thead><tr><th>ID</th><th>Name</th><th>Category</th><th>Description</th><th>Actions</th></tr></thead><tbody>";
    while ($row = $result->fetch_assoc()) {
      echo "<tr>
        <td>{$row['id']}</td>
        <td><input type='text' value='{$row['name']}' /></td>
        <td><input type='text' value='{$row['category']}' /></td>
        <td><input type='text' value='{$row['description']}' /></td>
        <td><button onclick='saveProduct(this)'>Save</button, id></td>
      </tr>";
    }
    echo "</tbody></table>";
    ?>
  </div>

  <div class="admin-section">
    <h2>Manage Users</h2>
    <?php
    $result = $conn->query("SELECT username, email, isAdmin FROM users");
    echo "<table><thead><tr><th>ID</th><th>Username</th><th>Email</th><th>isAdmin</th><th>Actions</th></tr></thead><tbody>";
    while ($row = $result->fetch_assoc()) {
      $selectedUser = $row['isAdmin'] == 0 ? 'selected' : '';
      $selectedAdmin = $row['isAdmin'] == 1 ? 'selected' : '';
      echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['username']}</td>
        <td>{$row['email']}</td>
        <td>
          <select>
            <option value='0' $selectedUser>User</option>
            <option value='1' $selectedAdmin>Admin</option>
          </select>
        </td>
        <td><button onclick='saveUser(this)'>Update</button></td>
      </tr>";
    }
    echo "</tbody></table>";
    $conn->close();
    ?>
  </div>

  <script>
    function saveProduct(button) {
  const row = button.closest("tr");
  const id = row.cells[0].textContent.trim();
  const name = row.cells[1].querySelector("input").value;
  const category = row.cells[2].querySelector("input").value;
  const description = row.cells[3].querySelector("input").value;

  fetch("update_product.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ id, name, category, description })
  })
  .then(res => res.json())
  .then(data => alert(data.status === "success" ? "Updated!" : data.message));
}


    function saveUser(button) {
    const row = button.closest("tr");
    const username = row.cells[1].textContent.trim(); // Username is in cell 1
    const isAdmin = parseInt(row.cells[3].querySelector("select").value);

    fetch("update_user.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ username, isAdmin })
    })
    .then(res => res.json())
    .then(data => alert(data.status === "success" ? "User updated!" : data.message));
  }
  </script>
  
  <script>
  document.addEventListener("DOMContentLoaded", () => {
    const user = JSON.parse(sessionStorage.getItem("user"));

    if (!user?.isLoggedIn || user?.isAdmin !== "1") {
      // Not logged in or not an admin → redirect
      alert("Access denied. Admins only.");
      window.location.href = "login.html";
    }
  });
</script>
  
  <footer>
    <p>&copy; 2025 GlobeTrotter Store. All rights reserved.</p>
  </footer>
</body>
</html>

