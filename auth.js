let userList = [];

// Load users from PHP
fetch("get_users.php")
  .then((res) => res.json())
  .then((data) => {
    userList = data;
  })
  .catch((err) => {
    console.error("Failed to fetch users:", err);
  });

// Replace localStorage → sessionStorage
function login(email, password) {
  const user = userList.find(
    (u) => u.email === email && u.password === password
  );

  if (user) {
    user.isLoggedIn = true;
    sessionStorage.setItem("user", JSON.stringify(user));
    return true;
  }
  return false;
}

function logout() {
  sessionStorage.removeItem("user");
  window.location.href = "login.html";
}

function isAuthenticated() {
  const user = JSON.parse(sessionStorage.getItem("user"));
  return user?.isLoggedIn === true;
}

function isAdmin() {
  const user = JSON.parse(sessionStorage.getItem("user"));
  return user?.isLoggedIn && user?.isAdmin === "1";
}

document.addEventListener("DOMContentLoaded", () => {
  const nav = document.querySelector("nav ul");
  const user = JSON.parse(sessionStorage.getItem("user"));

  // Clear out any previous "Login" or "Logout" item (if dynamically injected)
  const loginLogoutItem = document.getElementById("login-logout");
  if (loginLogoutItem) loginLogoutItem.remove();

  const li = document.createElement("li");
  li.id = "login-logout";

  if (user?.isLoggedIn) {
    // Logged in: Show "Logout (name)"
    li.innerHTML = `<a href="#" id="logoutLink">Logout (${user.firstName || "User"})</a>`;
    nav.appendChild(li);

    document.getElementById("logoutLink").addEventListener("click", (e) => {
      e.preventDefault();
      logout();
    });
  } else {
    // Not logged in: Show Login
    li.innerHTML = `<a href="login.html">Login</a>`;
    nav.appendChild(li);
  }
});
