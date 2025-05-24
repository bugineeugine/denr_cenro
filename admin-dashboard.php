<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard - Permit Verification System</title>
  <link rel="stylesheet" href="css/admin-dashboard.css" />
</head>
<body>
  <div class="container">
   <?php
      $activePage = 'dashboard'; 
      include('includes/sidebar.php');
    ?>



    <main class="dashboard">
        <div class="dashboard-header">
            <div class="logo-title">
              <h1>DASHBOARD</h1>  

      <div class="stats">
        <a  href="permits.html">
        <div class="card">
          <h3>Verified Permits</h3>
          <p>326</p>
          

          </a>
        </div>
        <div class="card">
          <a  href="applications.html">
          <h3>Pending Applications</h3>
          <p>48</p>
          </a>
        </div>
        <div class="card">
          <a  href="rejected.html">
          <h3>Rejected Permits</h3>
          <p>12</p>
          </a>
        </div>

      </div>

      <div class="chart-box">
        <h2>Monthly Permit Activity</h2>
        <canvas id="permitChart" width="600" height="300"></canvas>
      </div>
    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const ctx = document.getElementById('permitChart').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
          label: 'Permits Processed',
          data: [12, 19, 15, 22, 18, 24],
          backgroundColor: '#388e3c'
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: true }
        }
      }
    });
  </script>
</body>
</html>
