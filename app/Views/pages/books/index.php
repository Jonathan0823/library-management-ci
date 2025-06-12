<?= $this->extend('layout/layout'); ?>

<?= $this->section('styles'); ?>
<link rel="stylesheet" href="<?= base_url('assets/css/table.css') ?>">
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="content">
    <div class="card-header">
        <h1 class="card-title">Book List</h1>
    </div>
    <div class="card-body">
        <div class="modal fade" id="bookModal" tabindex="-1" aria-labelledby="bookModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <form id="bookForm">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="bookModalLabel">Add Book</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                  <input type="hidden" id="bookId" name="id">
                  <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                  </div>
                  <div class="mb-3">
                    <label for="author_id" class="form-label">Author</label>
                    <select class="form-select" id="author_id" name="author_id" required>
                      <option value="">Select Author</option>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="publisher_id" class="form-label">Publisher</label>
                    <select class="form-select" id="publisher_id" name="publisher_id" required>
                      <option value="">Select Publisher</option>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="year" class="form-label">Publication Year</label>
                    <input type="number" class="form-control" id="year" name="publication_year" required>
                  </div>

                  <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" required>
                  </div>

                  <div class="mb-3">
                    <label for="available" class="form-label">Available Quantity</label>
                    <input type="number" class="form-control" id="available" name="available_quantity" required>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary">Save</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#bookModal">
          Add New Book
        </button>
        <div class="table-responsive">
          <table id="bookTable" class="table table-bordered table-hover table-striped datatable">
              <thead>
                  <tr>
                      <th>ID</th>
                      <th>Title</th>
                      <th>Author</th>
                      <th>Publisher</th>
                      <th>Publication Year</th>
                      <th>Quantity</th>
                      <th>Available Quantity</th>
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
      $('#bookTable').DataTable({
          ajax: {
              url: '<?= base_url('api/books'); ?>',
              dataSrc: 'data'
          },
          columns: [
              { data: 'id' },
              { data: 'title' },
              { data: 'author_name' },
              { data: 'publisher_name' },
              { data: 'publication_year' },
              { data: 'quantity' },
              { data: 'available_quantity' },
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

  function loadSelectOptions(callback) {
    const authorPromise = $.getJSON('<?= base_url('api/authors'); ?>').then(response => {
      const $authorSelect = $('#author_id');
      $authorSelect.empty().append('<option value="">Pilih Penulis</option>');
      response.data.forEach(author => {
        $authorSelect.append(`<option value="${author.id}">${author.name}</option>`);
      });
    });

    const publisherPromise = $.getJSON('<?= base_url('api/publishers'); ?>').then(response => {
      const $publisherSelect = $('#publisher_id');
      $publisherSelect.empty().append('<option value="">Pilih Penerbit</option>');
      response.data.forEach(publisher => {
        $publisherSelect.append(`<option value="${publisher.id}">${publisher.name}</option>`);
      });
    });

    Promise.all([authorPromise, publisherPromise]).then(callback);
  }

  $('#bookModal').on('show.bs.modal', function () {
    loadSelectOptions();
  });

  $('#bookForm').on('submit', function (e) {
    e.preventDefault();
    const bookId = $('#bookId').val();
    const formArray = $(this).serializeArray();
    const formData = {};
    formArray.forEach(field => {
      formData[field.name] = field.value;
    });

    const url = bookId
      ? `<?= base_url('api/books'); ?>/${bookId}`
      : `<?= base_url('api/books'); ?>`;

    const method = bookId ? 'PUT' : 'POST';

    $.ajax({
      url: url,
      method: method,
      data: bookId ? JSON.stringify(formData) : $(this).serialize(),
      success: function (res) {
        $('#bookForm')[0].reset();
        $('#bookId').val('');
        $('#bookModal').modal('hide');
        $('#bookTable').DataTable().ajax.reload();
      },
      error: function () {
        alert('Gagal menyimpan data!');
      }
    });
  });


  $(document).on('click', '.edit-btn', function () {
    const bookId = $(this).data('id');

    $.getJSON(`<?= base_url('api/books'); ?>/${bookId}`, function (res) {
      const book = res.data;

      loadSelectOptions(function () {
        $('#bookId').val(book.id);
        $('#title').val(book.title);
        $('#year').val(book.publication_year);
        $('#quantity').val(book.quantity);
        $('#available').val(book.available_quantity);

        $('#author_id').val(String(book.author_id));
        $('#publisher_id').val(String(book.publisher_id));

        $('#bookModal').modal('show');
      });
    });
  });


  $(document).on('click', '.delete-btn', function () {
    const bookId = $(this).data('id');

    if (confirm('Are you sure you want to delete this book?')) {
      $.ajax({
        url: `<?= base_url('api/books'); ?>/${bookId}`,
        method: 'DELETE',
        success: function () {
          $('#bookTable').DataTable().ajax.reload();
        },
        error: function () {
          alert('Failed to delete data!');
        }
      });
    }
  });
</script>
<?= $this->endSection(); ?>
