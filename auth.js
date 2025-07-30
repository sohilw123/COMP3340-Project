// auth.js
// Fake user database
const fakeUser = {
  email: "user@example.com",
  password: "pass123",
  name: "John Doe",
  isLoggedIn: false
};

// Save default user (only once)
if (!localStorage.getItem("user")) {
  localStorage.setItem("user", JSON.stringify(fakeUser));
}

// Login function
function login(email, password) {
  const user = JSON.parse(localStorage.getItem("user"));

  if (user.email === email && user.password === password) {
    user.isLoggedIn = true;
    localStorage.setItem("user", JSON.stringify(user));
    return true;
  }
  return false;
}

// Logout function
function logout() {
  const user = JSON.parse(localStorage.getItem("user"));
  user.isLoggedIn = false;
  localStorage.setItem("user", JSON.stringify(user));
  window.location.href = "homepage.html"; // or login.html
}

// Check if user is logged in
function isAuthenticated() {
  const user = JSON.parse(localStorage.getItem("user"));
  return user?.isLoggedIn === true;
}
