<?= $this->extend('layout/layout'); ?>

<?= $this->section('styles'); ?>
<link rel="stylesheet" href="<?= base_url('assets/css/table.css') ?>">
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="content">
    <div class="card-header">
        <h1 class="card-title">Member List</h1>
    </div>
    <div class="card-body">
        <div class="modal fade" id="memberModal" tabindex="-1">
            <div class="modal-dialog">
                <form id="memberForm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="memberModalLabel">Add Member</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="memberId" name="id">
                            <div class="mb-3">
                                <label for="member_name" class="form-label">Member Name</label>
                                <input type="text" class="form-control" id="member_name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="member_address" class="form-label">Address</label>
                                <textarea class="form-control" id="member_address" name="address" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="member_phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="member_phone" name="phone">
                            </div>
                            <div class="mb-3">
                                <label for="member_email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="member_email" name="email">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#memberModal">Add Member</button>
        <div class="table-responsive">
            <table id="memberTable" class="table table-bordered table-hover table-striped datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Email</th>
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
        // Initialize DataTable
        $('#memberTable').DataTable({
            ajax: {
                url: '<?= base_url('api/members'); ?>',
                dataSrc: 'data'
            },
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'address' },
                { data: 'phone' },
                { data: 'email' },
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


        $('#memberForm').on('submit', function (e) {
            e.preventDefault();
            const memberId = $('#memberId').val();
            const formArray = $(this).serializeArray();
            const formData = {};
            formArray.forEach(field => {
              formData[field.name] = field.value;
            });

            const url = memberId
                ? `<?= base_url('api/members'); ?>/${memberId}`
                : `<?= base_url('api/members'); ?>`;

            const method = memberId ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                method: method,
                data: memberId ? JSON.stringify(formData) : $(this).serialize(),
                success: function (res) {
                    $('#memberForm')[0].reset();
                    $('#memberId').val('');
                    $('#memberModal').modal('hide');
                    $('#memberTable').DataTable().ajax.reload();
                },
                error: function (xhr, status, error) {
                    console.error("Error saving data:", xhr.responseText);
                    alert('Failed to save data! Please check the console for details.');
                }
            });
        });

        $(document).on('click', '.edit-btn', function () {
            const memberId = $(this).data('id');
            $('.modal-title').text('Edit Member');

            $.getJSON(`<?= base_url('api/members'); ?>/${memberId}`, function (res) {
                const member = res.data;
                console.log("Member data to populate form:", member);
                $('#memberId').val(member.id);
                $('#member_name').val(member.name);
                $('#member_address').val(member.address || '');
                $('#member_phone').val(member.phone || '');
                $('#member_email').val(member.email || '');
                $('#memberModal').modal('show');
            }).fail(function() {
                alert('Failed to fetch member data for editing!');
            });
        });

        $(document).on('click', '.delete-btn', function () {
            const memberId = $(this).data('id');

            if (confirm('Are you sure you want to delete this member?')) {
                $.ajax({
                    url: `<?= base_url('api/members'); ?>/${memberId}`,
                    method: 'DELETE',
                    success: function () {
                        $('#memberTable').DataTable().ajax.reload();
                    },
                    error: function (xhr, status, error) {
                        console.error("Error deleting data:", xhr.responseText);
                        alert('Failed to delete data! Please check the console for details.');
                    }
                });
            }
        });
    });
</script>
<?= $this->endSection(); ?>
