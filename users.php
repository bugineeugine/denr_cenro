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
                <option value="applicant">Applicant</option>
      
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
      url: 'backend/users/getAllUsers.php',
      dataSrc: 'data',
    },
    columnDefs: [
  { targets: [0, 1, 2, 3], className: 'text-start' },
      { targets: 3, className: 'text-capitalize' },    
    { targets: 4, orderable: false }
],
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
     <button class="btn btn-warning btn-sm archive-btn" data-id="${row.id}">
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
      url: 'backend/users/insertUser.php',
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

  // Handle Edit button click
  $(document).on('click', '.edit-btn', function() {
    const userId = $(this).data('id');
    // Fetch user data and populate modal
    $.ajax({
      url: `backend/users/getUserById.php?id=${userId}`,
      type: 'GET',
      success: function(user) {
        if (user) {
          $('#editUserId').val(user.id);
          $('#editFullName').val(user.full_name);
          $('#editUsername').val(user.username);
          $('#editEmail').val(user.email);
          $('#editRole').val(user.role);
          $('#editUserModal').modal('show');
        } else {
          alert('User not found.');
        }
      },
      error: function() {
        alert('Error fetching user data.');
      }
    });
  });

  // Handle Save Changes button click in Edit Modal
  $('#saveEditUser').click(function() {
    const form = document.getElementById('editUserForm');
    const emailInput = document.getElementById('editEmail');

    if (!form.checkValidity()) {
      event.preventDefault();
      event.stopPropagation();
      form.classList.add('was-validated');
      return;
    }

    const formData = {
      id: $('#editUserId').val(),
      full_name: $('#editFullName').val(),
      username: $('#editUsername').val(),
      email: $('#editEmail').val(),
      password: $('#editPassword').val(), // Include password only if changed, or handle separately
      role: $('#editRole').val()
    };

     if (!validateEmail(formData.email)) {
      emailInput.setCustomValidity('Please enter a valid email address');
      form.classList.add('was-validated');
      return;
    }

    $.ajax({
       url: 'backend/users/updateUser.php',
      type: 'PUT',
      data: JSON.stringify(formData),
      contentType: 'application/json',
      success: function(response) {
        if (response.success) {
          $('#editUserModal').modal('hide');
          table.ajax.reload();
          alert('User updated successfully!');
        } else {
          alert(response.message || 'Error updating user');
        }
      },
      error: function() {
        alert('Error updating user.');
      }
    });
  });

   // Reset edit form when modal is closed
  $('#editUserModal').on('hidden.bs.modal', function() {
    const form = document.getElementById('editUserForm');
    form.reset();
    form.classList.remove('was-validated');
     // Clear password field explicitly for security
    $('#editPassword').val('');
  });

  // Real-time email validation for edit form
  $('#editEmail').on('input', function() {
    const form = document.getElementById('editUserForm');
     if (validateEmail(this.value)) {
      this.setCustomValidity('');
      form.classList.remove('was-validated');
       this.classList.remove('is-invalid');
    } else {
      this.setCustomValidity('Please enter a valid email address');
      form.classList.add('was-validated');
       this.classList.add('is-invalid');
    }
  });

  // Handle Archive button click
  $(document).on('click', '.btn-warning.archive-btn', function() {
    const userId = $(this).data('id');
    if (confirm('Are you sure you want to archive this user?')) {
      $.ajax({
        url: `backend/users/archiveUser.php?id=${userId}`, 
        success: function(response) {
          if (response.success) {
            table.ajax.reload();
            alert('User archived successfully!');
          } else {
            alert(response.message || 'Error archiving user.');
          }
        },
        error: function() {
          alert('Error archiving user.');
        }
      });
    }
  });

  // Handle Delete button click
  $(document).on('click', '.delete-btn', function() {
    const userId = $(this).data('id');
    if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
      $.ajax({
        url: `backend/users/deleteUser.php?id=${userId}`,
        type: 'DELETE',
        success: function(response) {
          if (response.success) {
            table.ajax.reload();
            alert('User deleted successfully!');
          } else {
            alert(response.message || 'Error deleting user.');
          }
        },
        error: function() {
          alert('Error deleting user.');
        }
      });
    }
  });
});
  </script>

  <!-- Edit User Modal -->
  <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editUserForm" novalidate>
            <input type="hidden" id="editUserId" name="id">
            <div class="mb-3">
              <label for="editFullName" class="form-label">Full Name</label>
              <input type="text" class="form-control" id="editFullName" name="full_name" required>
              <div class="invalid-feedback">Please enter full name.</div>
            </div>
            <div class="mb-3">
              <label for="editUsername" class="form-label">Username</label>
              <input type="text" class="form-control" id="editUsername" name="username" required>
              <div class="invalid-feedback">Please enter username.</div>
            </div>
            <div class="mb-3">
              <label for="editEmail" class="form-label">Email</label>
              <input type="email" class="form-control" id="editEmail" name="email" required>
              <div class="invalid-feedback">Please enter a valid email address.</div>
            </div>
             <div class="mb-3">
              <label for="editPassword" class="form-label">Password (leave blank if not changing)</label>
              <input type="password" class="form-control" id="editPassword" name="password">
            </div>
            <div class="mb-3">
              <label for="editRole" class="form-label">Role</label>
              <select class="form-select" id="editRole" name="role" required>
                <option value="">Select Role</option>
                <option value="admin">Admin</option>
                <option value="staff">Validations</option>
     
              </select>
              <div class="invalid-feedback">Please select a role.</div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="saveEditUser">Save Changes</button>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
