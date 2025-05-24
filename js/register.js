document.addEventListener("DOMContentLoaded", function () {
  const registerForm = document.querySelector("form");

  registerForm.addEventListener("submit", function (e) {
    const fullName = registerForm.full_name.value.trim();
    const username = registerForm.username.value.trim();
    const email = registerForm.email.value.trim();
    const password = registerForm.password.value.trim();
    const confirmPassword = registerForm.confirm_password.value.trim();

    if (!fullName || !username || !email || !password || !confirmPassword) {
      alert("All fields are required.");
      e.preventDefault();
      return;
    }

    if (password !== confirmPassword) {
      alert("Passwords do not match.");
      e.preventDefault();
    }

    const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
    if (!email.match(emailPattern)) {
      alert("Please enter a valid email address.");
      e.preventDefault();
    }
  });
});
