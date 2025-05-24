document.addEventListener("DOMContentLoaded", function () {
  const loginForm = document.querySelector("form");

  loginForm.addEventListener("submit", function (e) {
    const username = loginForm.username.value.trim();
    const password = loginForm.password.value.trim();

    if (!username || !password) {
      alert("Please fill in both username and password.");
      e.preventDefault();
    }
  });
});
