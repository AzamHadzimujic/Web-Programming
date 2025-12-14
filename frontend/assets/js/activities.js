// Users can create their own activities.
// We fetch only current user's activities to keep it simple.

function renderActivities(list) {
  const container = document.getElementById("activities-container");
  if (!container) return;

  if (!Array.isArray(list) || list.length === 0) {
    container.innerHTML = "<p>No activities found.</p>";
    return;
  }

  container.innerHTML = `
    <table style="width:100%; border-collapse: collapse;">
      <thead>
        <tr>
          <th style="text-align:left; padding:8px; border-bottom:1px solid #ddd;">ID</th>
          <th style="text-align:left; padding:8px; border-bottom:1px solid #ddd;">Category</th>
          <th style="text-align:left; padding:8px; border-bottom:1px solid #ddd;">Name</th>
          <th style="text-align:left; padding:8px; border-bottom:1px solid #ddd;">Duration</th>
          <th style="text-align:left; padding:8px; border-bottom:1px solid #ddd;">Date</th>
        </tr>
      </thead>
      <tbody>
        ${list.map(a => `
          <tr>
            <td style="padding:8px; border-bottom:1px solid #eee;">${a.activity_id ?? ""}</td>
            <td style="padding:8px; border-bottom:1px solid #eee;">${a.category_id ?? ""}</td>
            <td style="padding:8px; border-bottom:1px solid #eee;">${a.name ?? ""}</td>
            <td style="padding:8px; border-bottom:1px solid #eee;">${a.duration ?? ""} min</td>
            <td style="padding:8px; border-bottom:1px solid #eee;">${a.date ?? ""}</td>
          </tr>
        `).join("")}
      </tbody>
    </table>
  `;
}

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

// Create activity (USER allowed now)
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