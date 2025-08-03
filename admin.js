function saveProduct(button, id) {
  const row = button.closest("tr");
  const name = row.children[1].querySelector("input").value;
  const category = row.children[2].querySelector("input").value;
  const description = row.children[3].querySelector("input").value;

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

function disableUser(id) {
  fetch("disable_user.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ id })
  })
    .then(res => res.json())
    .then(data => alert(data.status === "success" ? "User disabled!" : data.message));
}
