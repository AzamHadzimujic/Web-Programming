async function loadProgresslog() {
  if (!Auth.isLoggedIn()) return;

  const user = Auth.getUser();
  if (!user || !user.user_id) return;

  try {
    const latest = await apiRequest(`/progresslog/user/${user.user_id}/latest`, { method: "GET" });

    if (latest && latest.progress_id) {
      document.getElementById("pl-current-weight").textContent = latest.weight ?? "-";
      document.getElementById("pl-current-bodyfat").textContent = latest.body_fat ?? "-";
      document.getElementById("pl-status").textContent = "Loaded";
    } else {
      document.getElementById("pl-status").textContent = "No record yet";
    }
  } catch (e) {
    console.error(e);
  }
}

document.addEventListener("submit", async function(e) {
  if (!e.target || e.target.id !== "progresslog-form") return;
  e.preventDefault();

  const weight = parseInt(document.getElementById("pl-weight").value, 10);
  const body_fat = parseInt(document.getElementById("pl-bodyfat").value, 10);

  try {
    const res = await apiRequest("/progresslog", {
      method: "POST",
      body: { weight, body_fat }
    });

    document.getElementById("pl-status").textContent = res.action || "saved";
    await loadProgresslog();
  } catch (err) {
    alert(err.message);
  }
});

window.addEventListener("hashchange", function() {
  if (window.location.hash === "#progresslog") loadProgresslog();
});

document.addEventListener("DOMContentLoaded", function() {
  if (window.location.hash === "#progresslog") loadProgresslog();
});