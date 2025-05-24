$(document).ready(function() {
  function loadArchived() {
    $.getJSON('backend/get_archived_users.php', function(data) {
      let rows = '';
      data.forEach(user => {
        rows += `
          <tr>
            <td>${user.id}</td>
            <td>${user.name}</td>
            <td>${user.email}</td>
            <td>${user.permit_status}</td>
            <td>
              <button class="action-btn restore-btn" data-id="${user.id}">Restore</button>
              <button class="action-btn delete-btn" data-id="${user.id}">Delete</button>
            </td>
          </tr>`;
      });
      $('#archivedTableBody').html(rows);
    });
  }

  loadArchived();

  $(document).on('click', '.restore-btn', function() {
    const id = $(this).data('id');
    if (confirm('Restore this user?')) {
      $.post('backend/restore_user.php', { id }, function(res) {
        if (res === 'success') loadArchived();
      });
    }
  });

  $(document).on('click', '.delete-btn', function() {
    const id = $(this).data('id');
    if (confirm('Are you sure you want to permanently delete this user?')) {
      $.post('backend/delete_user.php', { id }, function(res) {
        if (res === 'success') loadArchived();
      });
    }
  });

  $('#searchInput').on('input', function() {
    const value = $(this).val().toLowerCase();
    $('#archivedTableBody tr').filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
