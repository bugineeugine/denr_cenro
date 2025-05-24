<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Approved Users - DENR CENRO</title>
  <?php  include('includes/styles.php') ?>  <!-- Bootstrap Icons -->

  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/users.css">

</head>
<body>

  <div class="main-layout">
    <?php
      $activePage = 'users'; 
      include('includes/sidebar.php');
    ?>

    <!-- Main Content -->
    <main class="container-fluid">
        <div class="dashboard-header">
        <div class="logo-title">
          <h1>APPROVED USERS</h1>
        </div>
      </div>

      <section class="content">
           <div class="actions">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Add user</button>
        </div>

      <div >
        <table id="users-table" class="table table-striped table-responsive">
          <thead class="table ">
            <tr>
              <th>Full Name</th>
              <th>Username</th>
              <th>Email</th>
              <th>Role</th>
              <th>Actions</th>
            </tr>
          </thead>
       
        </table>
      </div>
    </main>
  </div>

  <!-- Add User Modal -->
  <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="addUserForm" novalidate>
            <div class="mb-3">
              <label for="full_name" class="form-label">Full Name</label>
              <input type="text" class="form-control" id="full_name" name="full_name" required>
              <div class="invalid-feedback">Please enter full name.</div>
            </div>
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name="username" required>
              <div class="invalid-feedback">Please enter username.</div>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" required>
              <div class="invalid-feedback">Please enter a valid email address.</div>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" required>
              <div class="invalid-feedback">Please enter password.</div>
            </div>
            <div class="mb-3">
              <label for="role" class="form-label">Role</label>
              <select class="form-select" id="role" name="role" required>
                <option value="">Select Role</option>
                <option value="admin">Admin</option>
                <option value="staff">Staff</option>
                <option value="verifier">Verifier</option>
              </select>
              <div class="invalid-feedback">Please select a role.</div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="saveUser">Save User</button>
        </div>
      </div>
    </div>
  </div>

  <?php  include('includes/script.php') ?>  

  <script>
$(document).ready(function(){
  // Initialize DataTable
  const table = new DataTable("#users-table",{
    ajax: {
      url: 'backend/users.php',
      dataSrc: 'data',
    },
    columns: [
      { data: 'full_name' },
      { data: 'username' },
      { data: 'email' },
      { data: 'role' },
      { 
        data: null,
        render: function(data, type, row) {
          return `
            <button class="btn btn-info btn-sm edit-btn" data-id="${row.id}">
              <i class="bi bi-pencil"></i>
            </button>
     <button class="btn btn-warning btn-sm edit-btn" data-id="${row.id}">
                <i class="bi bi-archive"></i>
            </button>
      
            <button class="btn btn-danger btn-sm delete-btn" data-id="${row.id}">
              <i class="bi bi-trash"></i>
            </button>
          `;
        }
      }
    ]
  });

  // Form validation
  const form = document.getElementById('addUserForm');
  const emailInput = document.getElementById('email');

  // Email validation function
  function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
  }

  // Handle form submission
  $('#saveUser').click(function() {
    if (!form.checkValidity()) {
      event.preventDefault();
      event.stopPropagation();
      form.classList.add('was-validated');
      return;
    }

    const formData = {
      full_name: $('#full_name').val(),
      username: $('#username').val(),
      email: $('#email').val(),
      password: $('#password').val(),
      role: $('#role').val()
    };


    if (!validateEmail(formData.email)) {
      emailInput.setCustomValidity('Please enter a valid email address');
      form.classList.add('was-validated');
      return;
    }


    $.ajax({
      url: 'backend/users.php',
      type: 'POST',
      data: JSON.stringify(formData),
      contentType: 'application/json',
      success: function(response) {
        if (response.success) {
          $('#addUserModal').modal('hide');
          table.ajax.reload();
          form.reset();
          form.classList.remove('was-validated');
          alert('User added successfully!');
        } else {
          alert(response.message || 'Error adding user');
        }
      },
      error: function() {
        alert('Error adding user');
      }
    });
  });

  // Reset form when modal is closed
  $('#addUserModal').on('hidden.bs.modal', function() {
    form.reset();
    form.classList.remove('was-validated');
  });

  // Real-time email validation
  emailInput.addEventListener('input', function() {
    if (validateEmail(this.value)) {
      this.setCustomValidity('');
    } else {
      this.setCustomValidity('Please enter a valid email address');
    }
  });
});
  </script>

</body>
</html>
