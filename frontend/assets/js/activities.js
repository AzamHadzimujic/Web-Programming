// Users can create their own activities.
// We fetch only current user's activities to keep it simple.

function updateActivityStats(list) {
  const totalEl = document.getElementById("total-activities");
  const distEl = document.getElementById("total-distance");   // keep existing UI
  const durEl = document.getElementById("total-duration");    // keep existing UI

  if (totalEl) totalEl.textContent = Array.isArray(list) ? list.length : 0;

  const totalMinutes = (Array.isArray(list) ? list : []).reduce(
    (sum, a) => sum + (parseInt(a.duration, 10) || 0), 0
  );

  if (distEl) distEl.textContent = totalMinutes; // reuse: "distance" -> minutes
  if (durEl) durEl.textContent = totalMinutes;
}

async function loadActivitiesFromApi() {
  if (!Auth.isLoggedIn()) return;

  const user = Auth.getUser();
  if (!user || !user.user_id) return;

  try {
    const list = await apiRequest(`/activities/user/${user.user_id}`, { method: "GET" });
    renderActivities(list);
    updateActivityStats(list);
  } catch (e) {
    console.error(e);
  }
}

document.addEventListener("submit", async function(e) {
  if (!e.target || e.target.id !== "activity-form") return;
  e.preventDefault();

  const name = document.getElementById("activity-name").value.trim();
  const duration = parseInt(document.getElementById("activity-duration").value, 10);
  const category_id = parseInt(document.getElementById("activity-category").value, 10);

  try {
    // user_id is enforced server-side from JWT for normal users
    const res = await apiRequest("/activities", {
      method: "POST",
      body: { category_id, name, duration }
    });

    e.target.reset();
    await loadActivitiesFromApi();
  } catch (err) {
    alert(err.message);
  }
});

window.addEventListener("hashchange", function() {
  if (window.location.hash === "#activities") loadActivitiesFromApi();
});

document.addEventListener("DOMContentLoaded", function() {
  if (window.location.hash === "#activities") loadActivitiesFromApi();
});