<?= $this->extend('layout/layout'); ?>

<?= $this->section('styles'); ?>
<link rel="stylesheet" href="<?= base_url('assets/css/table.css') ?>">
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="content">
    <div class="card-header">
        <h1 class="card-title">Publisher List</h1>
    </div>
    <div class="card-body">
        <!-- publisher Modal -->
        <div class="modal fade" id="publisherModal" tabindex="-1">
          <div class="modal-dialog">
            <form id="publisherForm">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Add Publisher</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  <input type="hidden" id="publisherId" name="id">
                  <div class="mb-3">
                    <label for="publisher_name" class="form-label">Publisher Name</label>
                    <input type="text" class="form-control" id="publisher_name" name="name" required>
                  </div>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button class="btn btn-primary">Save</button>
                </div>
              </div>
            </form>
          </div>
        </div>

        <!-- Tombol dan Tabel -->
        <button class="btn btn-primary mb-3 publisher_title" data-bs-toggle="modal" data-bs-target="#publisherModal">Add Publisher</button>
        <div class="table-responsive">
          <table id="publisherTable" class="table table-bordered table-hover table-striped datatable">
              <thead>
                  <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody></tbody>
          </table>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>

<link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.css" />
  
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>

<script>
  $(document).ready(function () {
      $('#publisherTable').DataTable({
          ajax: {
              url: '<?= base_url('api/publishers'); ?>',
              dataSrc: 'data'
          },
          columns: [
              { data: 'id' },
              { data: 'name' },
              {
                  data: 'id',
                  render: function (data, type, row) {
                      return `
                          <button class="btn btn-sm btn-warning edit-btn" data-id="${data}">Edit</button>
                          <button class="btn btn-sm btn-danger delete-btn" data-id="${data}">Delete</button>
                      `;
                  }
              }
          ]
      });
  });

  $('#publisherForm').on('submit', function (e) {
    e.preventDefault();
    const publisherId = $('#publisherId').val();
    const formArray = $(this).serializeArray();
    const formData = {};
    formArray.forEach(field => {
      formData[field.name] = field.value;
    });

    const url = publisherId
      ? `<?= base_url('api/publishers'); ?>/${publisherId}`
      : `<?= base_url('api/publishers'); ?>`;

    const method = publisherId ? 'PUT' : 'POST';

    $.ajax({
      url: url,
      method: method,
      data: publisherId ? JSON.stringify(formData) : $(this).serialize(),
      success: function (res) {
        $('#publisherForm')[0].reset();
        $('#publisherId').val('');
        $('#publisherModal').modal('hide');
        $('#publisherTable').DataTable().ajax.reload();
      },
      error: function () {
        alert('Failed to save data!');
      }
    });
  });


  $(document).on('click', '.edit-btn', function () {
    const publisherId = $(this).data('id');
    $('#publisherModal').modal('show');
    $('.publisher-title').text('Edit Member');

    $.getJSON(`<?= base_url('api/publishers'); ?>/${publisherId}`, function (res) {
      const publisher = res.data;
      $('#publisherId').val(publisher.id);
      $('#publisher_name').val(publisher.name);
    });
  });


  $(document).on('click', '.delete-btn', function () {
    const publisherId = $(this).data('id');

    if (confirm('Are you sure you want to delete this publisher?')) {
      $.ajax({
        url: `<?= base_url('api/publishers'); ?>/${publisherId}`,
        method: 'DELETE',
        success: function () {
          $('#publisherTable').DataTable().ajax.reload();
        },
        error: function () {
          alert('Failed to delete data!');
        }
      });
    }
  });
</script>
<?= $this->endSection(); ?>
