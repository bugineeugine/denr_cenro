



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Permits - Permit Verification System</title>
  <?php  include('includes/styles.php') ?>  <!-- Bootstrap Icons -->

  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/users.css">

</head>
<body>

  <div class="main-layout">
    <?php
      $activePage = 'permits'; 
      include('includes/sidebar.php');
    ?>

    <!-- Main Content -->
    <main class="container-fluid">
        <div class="dashboard-header">
        <div class="logo-title">
         <h1>PERMITS</h1>
        </div>
      </div>

      <section class="content">
  
        <div class="actions">
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPermitModal">Add permit</button>
        </div>

      <div >
        <table id="permits-table" class="table table-striped table-responsive">
          <thead class="table ">
            <tr>
              <th>Permit ID</th>
              <th>Holder</th>
                <th>Permit Type</th>
              <th>Status</th>
              <th>Date Issued</th>
              <th>Action</th>
            </tr>
          </thead>
        </table>
      </div>
    </main>
  </div>

   <div class="modal fade" id="addPermitModal" tabindex="-1" aria-labelledby="addPermitModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addPermitModalLabel">Add New User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="addPermitForm" novalidate>
            <div class="mb-3">
              <label for="holder_name" class="form-label">Holder</label>
              <select id="holder_name" name="holder_name" class="form-select" required style="width: 100%;">
             
              </select>
              <div class="invalid-feedback">Please select a holder.</div>
            </div>
            <div class="mb-3">
              <label for="permit_type" class="form-label">Permit Type</label>
              <select id="permit_type" name="permit_type" class="form-select" required>
                <option value="" disabled selected>Select permit type</option>
                <option value="Transport">Transport</option>
                <option value="Construction">Construction</option>
                <option value="Business">Business</option>
                <option value="Event">Event</option>

              </select>
              <div class="invalid-feedback">Please select a permit type.</div>
            </div>
            <div class="mb-3">
              <label for="issued_date" class="form-label">Date Issued</label>
              <input type="datetime-local" class="form-control" id="issued_date" name="issued_date" required>
              <div class="invalid-feedback">Please enter Date Issued.</div>
            </div>
     
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="savePermit">Save Permit</button>
        </div>
      </div>
    </div>
  </div>



  <?php  include('includes/script.php') ?>  

<script>
  $(document).ready(function(){
  const form = document.getElementById('addPermitForm');
  const table = new DataTable("#permits-table",{
    ajax: {
      url: 'backend/permits/getAllPermits.php',
      dataSrc: 'data',
    },
    columnDefs: [
      { targets: [0, 1,2,3 ], className: 'text-start' },
      { targets: 2, className: 'text-capitalize' },    
    ],
    columns: [
      { data: 'id' },

      { data: 'holder.email' },
            { data: 'permit_type' },
       {
        data: 'status',
        render: function(data, type, row) {
          let badgeClass = 'secondary';
          if (data === 'approved') badgeClass = 'success';
          else if (data === 'rejected') badgeClass = 'danger';
          else if (data === 'pending') badgeClass = 'warning';

          return `<span class="badge bg-${badgeClass} text-capitalize">${data}</span>`;
        }
      },
     { data: 'issued_date' },
    {
        data: null,
        render: function (data, type, row) {
          const { id, status } = row;
          let buttons = '';

          if (status === 'pending' || status === 'rejected') {
            buttons += `
              <button 
                class="btn btn-primary btn-sm approved-btn" 
                data-id="${id}" 
                title="Approve Permit"
              >
                Approve
              </button>
            `;
          }

          if (status === 'pending' || status === 'approved') {
            buttons += `
              <button 
                class="btn btn-warning btn-sm rejected-btn" 
                data-id="${id}" 
                title="Reject Permit"
              >
                Reject
              </button>
            `;
          }
  buttons += `
              <button 
                class="btn btn-danger btn-sm delete-btn" 
                data-id="${id}" 
                title="Delete Permit"
              >
                Delete
              </button>
            `;
          return buttons.trim();
        }
      }
    ]
  });



  $('#addPermitModal').on('hidden.bs.modal', function() {
    form.reset();
    form.classList.remove('was-validated');
     $('#holder_name').val(null).trigger('change');

  });
$('#addPermitModal').on('shown.bs.modal', function () {

    $('#holder_name').select2({
      placeholder: 'Select a holder',
      dropdownParent: $('#addPermitModal'), 
      width: 'resolve',
      ajax: {
        url: 'backend/users/getAllUsers.php',
        dataType: 'json',
        processResults: function (data) {
          return {
            results: data.data.map(function (user) {
              return { id: user.id, text: user.full_name };
            })
          };
        },
        cache: true
      }
    });



});



$('#savePermit').on('click', function () {
  const form = document.getElementById('addPermitForm');

  if (!form.checkValidity()) {
    form.classList.add('was-validated');
    return;
  }

    const holderId = $('#holder_name').val();
    const issuedDate = $('#issued_date').val();
    const permitType = $('#permit_type').val();

      $.ajax({
        url: 'backend/permits/insertPermit.php',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
          holder_id: holderId,
          issued_date: issuedDate,
          permit_type:permitType
        }),
        success: function (response) {
          if (response.success) {
            $('#addPermitModal').modal('hide');
            $('#permits-table').DataTable().ajax.reload();
            alert('Permit saved successfully!');
          } else {
            alert(response.message || 'Something went wrong.');
          }
        },
        error: function () {
          alert('Error saving permit.');
        }
      });
  });
    $(document).on('click', '.btn-danger.delete-btn', function() {
    const permitId = $(this).data('id');

      if (confirm('Are you sure you want to delete this permit?')) {
             $.ajax({
              url: `backend/permits/deletePermit.php?id=${permitId}`,

              success: function(response) {
                if (response.success) {
                  table.ajax.reload();
                  alert(`Permit delete successfully!`);
                } else {
                  alert(response.message || `Error delete permit.`);
                }
              },
              error: function() {
                alert(`Error delete permit.`);
              }
            });
      }
    });

    $(document).on('click', '.btn-primary.approved-btn', function() {
    const permitId = $(this).data('id');

      if (confirm('Are you sure you want to approve this permit?')) {
          updateStatus(permitId,'approved')
      }
    });
    $(document).on('click', '.btn-warning.rejected-btn', function() {
    const permitId = $(this).data('id');

      if (confirm('Are you sure you want to reject this permit?')) {
          updateStatus(permitId,'rejected')
      }
    });


  function updateStatus(permitId,status){
        $.ajax({
        url: `backend/permits/approvePermit.php`,
        method: 'POST',
        data: JSON.stringify({ permitId,status}), 
        contentType: 'application/json',     
        success: function(response) {
          if (response.success) {
            table.ajax.reload();
            alert(`Permit ${status} successfully!`);
          } else {
            alert(response.message || `Error ${status} permit.`);
          }
        },
        error: function() {
          alert(`Error ${status} permit.`);
        }
      });
  }

})
</script>



</body>
</html>
