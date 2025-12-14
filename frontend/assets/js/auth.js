const API_BASE = "../backend";

const Auth = {
  getToken() {
    return localStorage.getItem("token");
  },
  getUser() {
    const raw = localStorage.getItem("user");
    try { return raw ? JSON.parse(raw) : null; } catch (e) { return null; }
  },
  setSession(userWithToken) {
    // expects { token, ...userFields }
    localStorage.setItem("token", userWithToken.token);
    const u = { ...userWithToken };
    delete u.token;
    localStorage.setItem("user", JSON.stringify(u));
  },
  clearSession() {
    localStorage.removeItem("token");
    localStorage.removeItem("user");
  },
  isLoggedIn() {
    return !!this.getToken();
  }
};

// Shared API request helper used by other scripts
async function apiRequest(path, options = {}) {
  const headers = options.headers ? { ...options.headers } : {};

  // JSON body convenience
  if (options.body && typeof options.body === "object" && !(options.body instanceof FormData)) {
    headers["Content-Type"] = "application/json";
    options.body = JSON.stringify(options.body);
  }

  const token = Auth.getToken();
  if (token) headers["Authentication"] = token;

  const res = await fetch(API_BASE + path, { ...options, headers });
  const text = await res.text();

  let data = null;
  try { data = text ? JSON.parse(text) : null; } catch (e) { data = { raw: text }; }

  if (!res.ok) {
    const msg = (data && (data.error || data.message))
      ? (data.error || data.message)
      : ("Request failed (" + res.status + ")");
    throw new Error(msg);
  }

  return data;
}


document.addEventListener("submit", async function(e) {
  // Login
  if (e.target && e.target.id === "login-form") {
    e.preventDefault();

    const email = document.getElementById("login-email").value.trim();
    const password = document.getElementById("login-password").value;

    try {
      const res = await apiRequest("/auth/login", {
        method: "POST",
        body: { email, password }
      });

      // backend returns { success:true, data:{...user, token} }
      Auth.setSession(res.data);
      updateNav();
      window.location.hash = "#profile";
    } catch (err) {
      alert(err.message);
    }
  }

  // Register
  if (e.target && e.target.id === "register-form") {
    e.preventDefault();

    const name = document.getElementById("register-username").value.trim();
    const email = document.getElementById("register-email").value.trim();
    const password = document.getElementById("register-password").value;

    try {
      const res = await apiRequest("/auth/register", {
        method: "POST",
        body: { name, email, password }
      });

      alert("Registered. Please login.");
      window.location.hash = "#login";
    } catch (err) {
      alert(err.message);
    }
  }
});

document.addEventListener("click", function(e) {
  if (e.target && (e.target.id === "logout-link" || e.target.id === "logout-btn")) {
    e.preventDefault();
    Auth.clearSession();
    updateNav();
    window.location.hash = "#home";
  }
});

window.addEventListener("hashchange", function() {
  updateNav();

  // Simple route protection (optional)
  const protectedViews = ["#activities", "#progresslog", "#profile"];
  if (protectedViews.includes(window.location.hash) && !Auth.isLoggedIn()) {
    window.location.hash = "#login";
  }
});

document.addEventListener("DOMContentLoaded", function() {
  updateNav();
});