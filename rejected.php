<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Rejected Permits - Permit Verification System</title>
  <link rel="stylesheet" href="css/rejected.css" />
</head>
<body>
  <div class="container">
   <?php
      $activePage = 'rejected'; 
      include('includes/sidebar.php');
    ?>


    <main class="dashboard">
      <div class="dashboard-header">
        <div class="logo-title">
          <h1>REJECTED APPLICATIONS</h1>
        </div>
      </div>

      <section class="content">
        <div class="actions">
          <input type="text" placeholder="Search rejected entries..." class="search-bar">
        </div>

        <table class="rejected-table">
          <thead>
            <tr>
              <th>Application ID</th>
              <th>Applicant Name</th>
              <th>Type</th>
              <th>Reason</th>
              <th>Date Rejected</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>APP-030</td>
              <td>Carlos Mendoza</td>
              <td>Transport</td>
              <td>Incomplete documents</td>
              <td>2025-05-08</td>
            </tr>
            <!-- Additional rows -->
          </tbody>
        </table>
      </section>
    </main>
  </div>
</body>
</html>
