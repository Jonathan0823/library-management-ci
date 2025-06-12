<?= $this->extend('layout/layout'); ?>

<?= $this->section('styles'); ?>
<link rel="stylesheet" href="<?= base_url('assets/css/table.css') ?>">
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="content">
    <div class="card-header">
        <h1 class="card-title">Author List</h1>
    </div>
    <div class="card-body">
        <!-- Author Modal -->
        <div class="modal fade" id="authorModal" tabindex="-1">
          <div class="modal-dialog">
            <form id="authorForm">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Add Author</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  <input type="hidden" id="authorId" name="id">
                  <div class="mb-3">
                    <label for="author_name" class="form-label">Author Name</label>
                    <input type="text" class="form-control" id="author_name" name="name" required>
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
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#authorModal">Add Author</button>
        <div class="table-responsive">
          <table id="authorTable" class="table table-bordered table-hover table-striped datatable">
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
      $('#authorTable').DataTable({
          ajax: {
              url: '<?= base_url('api/authors'); ?>',
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

  $('#authorForm').on('submit', function (e) {
    e.preventDefault();
    const authorId = $('#authorId').val();
    const formArray = $(this).serializeArray();
    const formData = {};
    formArray.forEach(field => {
      formData[field.name] = field.value;
    });

    const url = authorId
      ? `<?= base_url('api/authors'); ?>/${authorId}`
      : `<?= base_url('api/authors'); ?>`;

    const method = authorId ? 'PUT' : 'POST';

    $.ajax({
      url: url,
      method: method,
      data: authorId ? JSON.stringify(formData) : $(this).serialize(),
      success: function (res) {
        $('#authorForm')[0].reset();
        $('#authorId').val('');
        $('#authorModal').modal('hide');
        $('#authorTable').DataTable().ajax.reload();
      },
      error: function () {
        alert('Failed to save data!');
      }
    });
  });


  $(document).on('click', '.edit-btn', function () {
    const authorId = $(this).data('id');
    $('#authorModal').modal('show');

    $.getJSON(`<?= base_url('api/authors'); ?>/${authorId}`, function (res) {
      const author = res.data;
      $('#authorId').val(author.id);
      $('#author_name').val(author.name);
    });
  });


  $(document).on('click', '.delete-btn', function () {
    const authorId = $(this).data('id');

    if (confirm('Are you sure you want to delete this author?')) {
      $.ajax({
        url: `<?= base_url('api/authors'); ?>/${authorId}`,
        method: 'DELETE',
        success: function () {
          $('#authorTable').DataTable().ajax.reload();
        },
        error: function () {
          alert('Failed to delete data!');
        }
      });
    }
  });
</script>
<?= $this->endSection(); ?>
