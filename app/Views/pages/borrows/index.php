<?= $this->extend('layout/layout'); ?>

<?= $this->section('styles'); ?>
<link rel="stylesheet" href="<?= base_url('assets/css/table.css') ?>">
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="content">
    <div class="card-header">
        <h1 class="card-title">Borrow Transaction List</h1>
    </div>
    <div class="card-body">
        <div class="modal fade" id="borrowTransactionModal" tabindex="-1" aria-labelledby="borrowTransactionModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="borrowTransactionForm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="borrowTransactionModalLabel">Add Borrow Transaction</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="transactionId" name="id">
                            <div class="mb-3">
                                <label for="book_id" class="form-label">Book</label>
                                <select class="form-select" id="book_id" name="book_id" required>
                                    <option value="">Select Book</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="member_id" class="form-label">Member</label>
                                <select class="form-select" id="member_id" name="member_id" required>
                                    <option value="">Select Member</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="borrow_date" class="form-label">Borrow Date</label>
                                <input type="date" class="form-control" id="borrow_date" name="borrow_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="return_date" class="form-label">Return Date</label>
                                <input type="date" class="form-control" id="return_date" name="return_date">
                            </div>
                            <div class="mb-3">
                                <label for="due_date" class="form-label">Due Date</label>
                                <input type="date" class="form-control" id="due_date" name="due_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="borrowed">Borrowed</option>
                                    <option value="returned">Returned</option>
                                    <option value="overdue">Overdue</option>
                                </select>
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
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#borrowTransactionModal">
            Add New Borrow Transaction
        </button>
        <div class="table-responsive">
            <table id="borrowTransactionTable" class="table table-bordered table-hover table-striped datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Book Title</th>
                        <th>Member Name</th>
                        <th>Borrow Date</th>
                        <th>Return Date</th>
                        <th>Due Date</th>
                        <th>Status</th>
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
        $('#borrowTransactionTable').DataTable({
            ajax: {
                url: '<?= base_url('api/borrows'); ?>',
                dataSrc: 'data'
            },
            columns: [
                { data: 'id' },
                { data: 'book_title' },
                { data: 'member_name' },
                { data: 'borrow_date' },
                { data: 'return_date' },
                { data: 'due_date' },
                { data: 'status' },
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
        const bookPromise = $.getJSON('<?= base_url('api/books'); ?>').then(response => {
            const $bookSelect = $('#book_id');
            $bookSelect.empty().append('<option value="">Select Book</option>');
            response.data.forEach(book => {
                $bookSelect.append(`<option value="${book.id}">${book.title}</option>`);
            });
        });

        const memberPromise = $.getJSON('<?= base_url('api/members'); ?>').then(response => {
            const $memberSelect = $('#member_id');
            $memberSelect.empty().append('<option value="">Select Member</option>');
            response.data.forEach(member => {
                $memberSelect.append(`<option value="${member.id}">${member.name}</option>`);
            });
        });

        Promise.all([bookPromise, memberPromise]).then(callback);
    }

    $('#borrowTransactionModal').on('show.bs.modal', function () {
        loadSelectOptions();
    });

    $('#borrowTransactionForm').on('submit', function (e) {
        e.preventDefault();
        const transactionId = $('#transactionId').val();
        const formArray = $(this).serializeArray();
        const formData = {};
        formArray.forEach(field => {
            formData[field.name] = field.value;
        });

        const url = transactionId
            ? `<?= base_url('api/borrows'); ?>/${transactionId}`
            : `<?= base_url('api/borrows'); ?>`;

        const method = transactionId ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            method: method,
            data: transactionId ? JSON.stringify(formData) : $(this).serialize(),
            contentType: transactionId ? 'application/json' : 'application/x-www-form-urlencoded; charset=UTF-8',
            success: function (res) {
                $('#borrowTransactionForm')[0].reset();
                $('#transactionId').val('');
                $('#borrowTransactionModal').modal('hide');
                $('#borrowTransactionTable').DataTable().ajax.reload();
            },
            error: function (xhr, status, error) {
                console.error("Error saving data:", xhr.responseText);
                alert('Failed to save data! Check console for more details.');
            }
        });
    });

    $(document).on('click', '.edit-btn', function () {
        const transactionId = $(this).data('id');

        $.getJSON(`<?= base_url('api/borrows'); ?>/${transactionId}`, function (res) {
            const transaction = res.data;

            loadSelectOptions(function () {
                $('#transactionId').val(transaction.id);
                $('#book_id').val(String(transaction.book_id));
                $('#member_id').val(String(transaction.member_id));
                $('#borrow_date').val(transaction.borrow_date);
                $('#return_date').val(transaction.return_date);
                $('#due_date').val(transaction.due_date);
                $('#status').val(transaction.status);
                $('#borrowTransactionModal').modal('show');
            });
        });
    });

    $(document).on('click', '.delete-btn', function () {
        const transactionId = $(this).data('id');

        if (confirm('Are you sure you want to delete this borrow transaction?')) {
            $.ajax({
                url: `<?= base_url('api/borrows'); ?>/${transactionId}`,
                method: 'DELETE',
                success: function () {
                    $('#borrowTransactionTable').DataTable().ajax.reload();
                },
                error: function () {
                    alert('Failed to delete data!');
                }
            });
        }
    });
</script>
<?= $this->endSection(); ?>
