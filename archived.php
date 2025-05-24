<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Archived - Permit Verification System</title>
  <link rel="stylesheet" href="css/archived.css" />
</head>
<body>
 <div class="container">
    <!-- Sidebar -->
   <?php
      $activePage = 'archived'; 
      include('includes/sidebar.php');
    ?>


    <!-- Main dashboard content -->
    <main class="dashboard">
      <div class="dashboard-header">
        <div class="logo-title">
          <h1>ARCHIVED USERS</h1>
        </div>
      </div>

      <section class="content">
        <div class="actions">
          <input type="text" placeholder="Search archived users..." class="search-bar" id="searchInput">
        </div>

        <table class="archived-table">
          <thead>
            <tr>
              <th>User ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Permit Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="archivedTableBody">
            <!-- Rows will be dynamically loaded with JS -->
          </tbody>
        </table>
      </section>
    </main>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="js/archived.js"></script>
</body>
</html>
