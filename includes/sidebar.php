<aside class="sidebar">
  <div class="logo">
    <h2>DENR CENRO<br>  
    <div class="admin-dropdown">
      <button class="dropdown-toggle">Admin</button>
      <div class="dropdown-content">
        <a href="profile.php">My Profile</a>
        <a href="login.php">Log Out</a>
      </div>
    </div></h2>
  </div>

  <nav class="sidebar-nav">
    <ul>
      <li><a href="admin-dashboard.php" class="<?= ($activePage === 'dashboard') ? 'active' : '' ?>">Dashboard</a></li>
      <li><a href="users.php" class="<?= ($activePage === 'users') ? 'active' : '' ?>">Users</a></li>
      <li><a href="permits.php" class="<?= ($activePage === 'permits') ? 'active' : '' ?>">Permits</a></li>
      <li><a href="applications.php" class="<?= ($activePage === 'applications') ? 'active' : '' ?>">Applications</a></li>
      <li><a href="rejected.php" class="<?= ($activePage === 'rejected') ? 'active' : '' ?>">Rejected</a></li>
      <li><a href="archived.php" class="<?= ($activePage === 'archived') ? 'active' : '' ?>">Archived</a></li>
      <li><a href="reports.php" class="<?= ($activePage === 'reports') ? 'active' : '' ?>">Reports</a></li>
    </ul>
  </nav>
</aside>