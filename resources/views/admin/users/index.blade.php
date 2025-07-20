@extends('layout.admin')
@section('content')
        <div class="app-container">
          <div class="app-hero-header d-flex align-items-center">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <i class="ri-home-8-line lh-1 pe-3 me-3 border-end"></i>
                <a href="/dashboard">Home</a>
              </li>
              <li class="breadcrumb-item text-primary" aria-current="page">
                Users List
              </li>
            </ol>
            <!-- Breadcrumb ends -->

            <!-- Sales stats starts -->
       

          </div>
          <!-- App Hero header ends -->

          <!-- App body starts -->
          <div class="app-body">

            <!-- Row starts -->
            <div class="row gx-3">
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title">Users List</h5>
                    <a href="/admin/add-user" class="btn btn-primary ms-auto">Add User</a>
                  </div>
                  <div class="card-body">

                    <!-- Table starts -->
                    <div class="table-responsive">

                        <div class="row mb-3">
    <div class="col-md-4 mb-2">
        <label for="from_date">From Date:</label>
        <input type="date" id="from_date" class="form-control">
    </div>
    <div class="col-md-4 mb-2">
        <label for="to_date">To Date:</label>
        <input type="date" id="to_date" class="form-control">
    </div>
    <div class="col-md-4 mb-2 d-flex align-items-end">
        <button id="filterDate" class="btn btn-primary me-2">Filter</button>
        <button id="resetFilter" class="btn btn-secondary">Reset</button>
    </div>
</div>


                     <table id="datatableid" class="table truncate m-0 align-middle">
    <thead>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>DOB</th>
            <th>Address</th>
            <th>registered_at</th>
            <th>Status</th>
            <th>Block Status</th>
            <th>Actions</th>
        </tr>
    </thead>
</table>

                    </div>
                    <!-- Table ends -->

                    <!-- Modal Delete Row -->
                    <div class="modal fade" id="delRow" tabindex="-1" aria-labelledby="delRowLabel" aria-hidden="true">
                      <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="delRowLabel">
                              Confirm
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            Are you sure you want to delete the user from list?
                          </div>
                          <div class="modal-footer">
                            <div class="d-flex justify-content-end gap-2">
                              <button class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                aria-label="Close">No</button>
                              <button class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Yes</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>
            <!-- Row ends -->

          </div>
        </div>


        @section('css')
 <link rel="stylesheet" href="{{ url('') }}/newadmin/assets/vendor/datatables/dataTables.bs5.css">
    <link rel="stylesheet" href="{{ url('') }}/newadmin/assets/vendor/datatables/dataTables.bs5-custom.css">
    <link rel="stylesheet" href="{{ url('') }}/newadmin/assets/vendor/datatables/buttons/dataTables.bs5-custom.css">
        @endsection

        @section('scripts')

    <script src="{{ url('') }}/newadmin/assets/vendor/datatables/dataTables.min.js"></script>
    <script src="{{ url('') }}/newadmin/assets/vendor/datatables/dataTables.bootstrap.min.js"></script>
    <script src="{{ url('') }}/newadmin/assets/vendor/datatables/custom/custom-datatables.js"></script>

    


   <script>
   $(document).ready(function () {
    let statusType = "{{ request()->get('type') }}";

    let table = $('#datatableid').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.getUserdata') }}",
            data: function (d) {
                d.type = statusType;
                d.from_date = $('#from_date').val();
                d.to_date = $('#to_date').val();
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'phone', name: 'phone' },
            { data: 'email', name: 'email' },
            { data: 'dob', name: 'dob' },
            { data: 'address', name: 'address' },
            { data: 'registered_at', name: 'registered_at' },
            { data: 'status', name: 'status' },
            { data: 'is_block', name: 'is_block' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]
    });

    // Filter button
    $('#filterDate').click(function () {
        table.ajax.reload();
    });

    // Reset filter
    $('#resetFilter').click(function () {
        $('#from_date').val('');
        $('#to_date').val('');
        table.ajax.reload();
    });
});

   </script>

    <script>
$(document).on('change', '.user-status', function () {
    var userId = $(this).data('user-id');
    var newStatus = $(this).val();

    $.ajax({
        url: "{{ route('admin.updateUserStatus') }}",
        type: 'POST',
        data: {
            _token: "{{ csrf_token() }}",
            user_id: userId,
            status: newStatus
        },
       success: function (response) {
    if (response.success) {
        toastr.success('User status updated to ' + newStatus.charAt(0).toUpperCase() + newStatus.slice(1));
        $('#datatableid').DataTable().ajax.reload(null, false); // 🔄 Reload table without resetting pagination
    } else {
        toastr.error('Failed to update user status');
    }
},
        error: function () {
            toastr.error('Something went wrong while updating status');
        }
    });
});


$(document).on('change', '.user-block-status', function () {
    var userId = $(this).data('user-id');
    var newBlockStatus = $(this).val();

    $.ajax({
        url: "{{ route('admin.updateUserBlockStatus') }}",
        type: 'POST',
        data: {
            _token: "{{ csrf_token() }}",
            user_id: userId,
            block_status: newBlockStatus
        },
        success: function (response) {
            if (response.success) {
                toastr.success('User block status updated to ' + newBlockStatus.charAt(0).toUpperCase() + newBlockStatus.slice(1));
                $('#datatableid').DataTable().ajax.reload(null, false);
            } else {
                toastr.error('Failed to update block status');
            }
        },
        error: function () {
            toastr.error('Something went wrong while updating block status');
        }
    });
});
</script>

        @endsection

        @endsection