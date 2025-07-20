@extends('layout.admin')
@section('content')


<!-- View Healing Request Modal -->
<div class="modal fade" id="viewRequestModal" tabindex="-1" aria-labelledby="viewRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewRequestModalLabel">Healing Request Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>User Name</th>
                            <td id="modalUser"></td>
                        </tr>
                        <tr>
                            <th>Requirement</th>
                            <td id="modalRequirement"></td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td id="modalDate"></td>
                        </tr>
                        <tr>
                            <th>Time</th>
                            <td id="modalTime"></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td id="modalStatus"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Edit Healing Request Modal -->
<div class="modal fade" id="editRequestModal" tabindex="-1" aria-labelledby="editRequestModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editRequestForm" method="POST" action="{{ url('/admin/healing-requests/update') }}">
        @csrf
        <input type="hidden" name="id" id="edit_id">

        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Healing Request</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <div class="modal-body">
              <div class="mb-3">
                  <label>Healing Requirement</label>
                  <input type="text" class="form-control" name="healing_requirement" id="edit_requirement">
              </div>

              <div class="mb-3">
                  <label>Date</label>
                  <input type="date" class="form-control" name="date" id="edit_date">
              </div>

              <div class="mb-3">
                  <label>Time</label>
                  <input type="time" class="form-control" name="time" id="edit_time">
              </div>

              <div class="mb-3">
                  <label>Status</label>
                  <select class="form-control" name="status" id="edit_status">
                      <option value="pending">Pending</option>
                      <option value="assigned">Assigned</option>
                      <option value="cancelled">Cancelled</option>
                  </select>
              </div>

              <div class="mb-3" id="assignedToWrapper" style="display: none;">
    <label>Assigned To</label>
    <select class="form-control" name="user_id" id="edit_user_id">
        @foreach(App\Models\User::get() as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
    </select>
</div>
          </div>

          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </div>
    </form>
  </div>
</div>



<div class="app-container">
    <div class="app-hero-header d-flex align-items-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="ri-home-8-line lh-1 pe-3 me-3 border-end"></i>
                <a href="/dashboard">Home</a>
            </li>
            <li class="breadcrumb-item text-primary" aria-current="page">
                Healing Requests
            </li>
        </ol>
    </div>

    <div class="app-body">
        <div class="row gx-3">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title">Healing Requests</h5>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="from_date">From Date:</label>
                                    <input type="date" id="from_date" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="to_date">To Date:</label>
                                    <input type="date" id="to_date" class="form-control">
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button id="filterDate" class="btn btn-primary me-2">Filter</button>
                                    <button id="resetFilter" class="btn btn-secondary">Reset</button>
                                </div>
                            </div>

                            <table id="healingTable" class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Requirement</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
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

    let table = $('#healingTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.getHealingRequests') }}",
            data: function (d) {
                d.type = statusType;
                d.from_date = $('#from_date').val();
                d.to_date = $('#to_date').val();
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'user_name', name: 'user.name' },
            { data: 'healing_requirement', name: 'healing_requirement' },
            { data: 'date', name: 'date' },
            { data: 'time', name: 'time' },
            { data: 'status', name: 'status' },
            { data: 'actions', name: 'actions' }
        ]
    });

    $('#filterDate').click(function () {
        table.ajax.reload();
    });

    $('#resetFilter').click(function () {
        $('#from_date').val('');
        $('#to_date').val('');
        table.ajax.reload();
    });
});
</script>

<script>
$(document).on('click', '.view-request-btn', function () {
    $('#modalUser').text($(this).data('user'));
    $('#modalRequirement').text($(this).data('requirement'));
    $('#modalDate').text($(this).data('date'));
    $('#modalTime').text($(this).data('time'));
    $('#modalStatus').text($(this).data('status'));
});
</script>


<script>
function toggleAssignedDropdown() {
    let status = $('#edit_status').val();
    if (status === 'assigned') {
        $('#assignedToWrapper').show();
    } else {
        $('#assignedToWrapper').hide();
        $('#edit_user_id').val(''); // clear user if not assigned
    }
}

$(document).ready(function () {
    // On status change in modal
    $('#edit_status').on('change', function () {
        toggleAssignedDropdown();
    });

    // On edit button click (pre-fill)
    $(document).on('click', '.edit-request-btn', function () {
        $('#edit_id').val($(this).data('id'));
        $('#edit_requirement').val($(this).data('requirement'));
        $('#edit_date').val($(this).data('date'));
        $('#edit_time').val($(this).data('time'));
        $('#edit_status').val($(this).data('status')).trigger('change');
        $('#edit_user_id').val($(this).data('user_id'));
        toggleAssignedDropdown();
    });
});
</script>

@endsection



@endsection
