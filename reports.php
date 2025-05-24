<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Reports - Permit Verification System</title>
  <link rel="stylesheet" href="css/reports.css" />
</head>
<body>
  <div class="container">
    <?php
      $activePage = 'reports'; 
      include('includes/sidebar.php');
    ?>


    <main class="dashboard">
      <div class="dashboard-header">
        <div class="logo-title">
          <h1>REPORTS - Violations</h1>
        </div>
      </div>

      <section class="content">
        <div class="actions">
          <input type="text" placeholder="Search applications..." class="search-bar">
        </div>

        
        <table class="reports-table">
          <thead>
            <tr>
              <th>User ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Violation</th>
              <th>Date Reported</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="reportData">
            <!-- Data loads here -->
          </tbody>
        </table>
      </section>
    </main>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function () {
      function loadReports() {
        $.getJSON('get_violations.php', function(data) {
          let rows = '';
          data.forEach(report => {
            rows += `
              <tr>
                <td>${report.user_id}</td>
                <td>${report.name}</td>
                <td>${report.email}</td>
                <td>${report.violation}</td>
                <td>${report.date_reported}</td>
                <td><button class="view-btn">View</button></td>
              </tr>
            `;
          });
          $('#reportData').html(rows);
        });
      }

      loadReports();
    });
  </script>
</body>
</html>
