<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register - Permit Verification System</title>
  <link rel="stylesheet" href="css/register.css" />
</head>
<body>
  <div class="auth-container">
    <h2>Create Account</h2>
    <form action="reg.php" method="POST">
    <label for="full_name">Full Name:</label>
    <input type="text" name="full_name" required>

    <label for="username">Username:</label>
    <input type="text" name="username" required>

    <label for="email">Email:</label><br>
    <input type="email" name="email" required>

    <label for="password">Password:</label>
    <input type="password" name="password" required>

    <label for="role">Select Role:</label><br>
    <select name="role" required>
      <option value="">--Select Role--</option>
      <option value="admin">Admin</option>
      <option value="user">User</option>
      <option value="verifier">Verifier</option>
    </select><br><br>

    <button type="submit">Register</button>

    <p class="link-text">Already have an account? <a href="login.html">Log In</a></p>
  </form>
  </div>

  <!-- JavaScript file -->
  <script src="js/register.js"></script>
</body>
</html>
