<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Applications - Permit Verification System</title>
  <link rel="stylesheet" href="css/applications.css" />
</head>
<body>
 <div class="container">
    <?php
      $activePage = 'applications'; 
      include('includes/sidebar.php');
    ?>

    <main class="dashboard">
      <div class="dashboard-header">
        <div class="logo-title">
          <h1>APPLICATIONS</h1>
        </div>
      </div>

      <section class="content">
        <div class="actions">
          <input type="text" placeholder="Search applications..." class="search-bar">
        </div>

        <table class="applications-table">
          <thead>
            <tr>
              <th>Application ID</th>
              <th>Applicant Name</th>
              <th>Type</th>
              <th>Status</th>
              <th>Submitted</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>APP-045</td>
              <td>Maria Santos</td>
              <td>Transport</td>
              <td>Pending</td>
              <td>2025-05-09</td>
              <td>
                <button class="approve-btn">Approve</button>
                <button class="reject-btn">Reject</button>
              </td>
            </tr>
            <!-- More rows -->
          </tbody>
        </table>
      </section>
    </main>
  </div>
</body>
</html>
