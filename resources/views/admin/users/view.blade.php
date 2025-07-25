@extends('layout.admin')
@section('content')

<div class="app-container">
  <div class="app-hero-header d-flex align-items-center">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <i class="ri-home-8-line lh-1 pe-3 me-3 border-end"></i>
        <a href="/dashboard">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="/admin/users-list">User List</a>
      </li>
      <li class="breadcrumb-item text-primary" aria-current="page">
        View User
      </li>
    </ol>
  </div>

 <div class="app-body">
  <div class="row gx-3">
    <div class="col-md-8 mx-auto">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title">User Details</h5>
        </div>
        <div class="card-body">
          <table class="table table-bordered">
            <tr>
              <th>Name</th>
              <td>{{ $user->name }}</td>
            </tr>
            <tr>
              <th>Email</th>
              <td>{{ $user->email }}</td>
            </tr>
            <tr>
              <th>Phone</th>
              <td>{{ $user->phone }}</td>
            </tr>
            <tr>
              <th>Date of Birth</th>
              <td>{{ $user->dob }}</td>
            </tr>
            <tr>
              <th>Address</th>
              <td>{{ $user->address }}</td>
            </tr>
            <tr>
              <th>User Code</th>
              <td>{{ $user->user_code }}</td>
            </tr>
            <tr>
              <th>Status</th>
              <td>{{ ucfirst($user->status) }}</td>
            </tr>
            <tr>
              <th>Role</th>
              <td>{{ ucfirst($user->role) }}</td>
            </tr>

            {{-- Payment Info --}}
            <tr>
              <th>Amount Paid</th>
              <td>₹{{ $user->amount ?? 'N/A' }}</td>
            </tr>
            <tr>
              <th>UTR / Transaction ID</th>
              <td>{{ $user->utr_no ?? 'N/A' }}</td>
            </tr>
            @php
    use Carbon\Carbon;
@endphp

<tr>
  <th>Payment Date</th>
  <td>
    @if($user->payment_date)
      {{ Carbon::parse($user->payment_date)->format('d M Y') }} {{-- e.g., 24 Jul 2025 --}}
    @else
      <span class="text-muted">N/A</span>
    @endif
  </td>
</tr>

<tr>
  <th>Payment Time</th>
  <td>
    @if($user->payment_time)
      {{ Carbon::parse($user->payment_time)->format('h:i A') }} {{-- e.g., 03:45 PM --}}
    @else
      <span class="text-muted">N/A</span>
    @endif
  </td>
</tr>

            <tr>
              <th>Payment Screenshot</th>
              <td>
                @if($user->screenshot)
                 <a href="{{ asset('uploads/screenshots/'.$user->screenshot) }}" target="_blank">
                 <img src="{{ asset('uploads/screenshots/'.$user->screenshot) }}" alt="Screenshot" style="max-width: 150px;"></a>
                @else
                  N/A
                @endif
              </td>
            </tr>
            <tr>
              <th>Certificate</th>
              <td>
                @if($user->certificate)
                 <a href="{{ asset('uploads/certificates/'.$user->certificate) }}" target="_blank">
                 <img src="{{ asset('uploads/certificates/'.$user->certificate) }}" alt="Certificate" style="max-width: 150px;"></a>
                @else
                  N/A
                @endif
              </td>
            </tr>

            <tr>
  <th>Status</th>
  <td>
    <select class="form-select form-select-sm user-status" data-user-id="{{ $user->id }}">
      <option value="approved" {{ $user->status == 'approved' ? 'selected' : '' }}>Approved</option>
      <option value="pending" {{ $user->status == 'pending' ? 'selected' : '' }}>Pending</option>
      <option value="rejected" {{ $user->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
    </select>
  </td>
</tr>

<tr>
  <th>Block Status</th>
  <td>
    <select class="form-select form-select-sm user-block-status" data-user-id="{{ $user->id }}">
      <option value="N" {{ $user->is_block == 'N' ? 'selected' : '' }}>Unblock</option>
      <option value="Y" {{ $user->is_block == 'Y' ? 'selected' : '' }}>Block</option>
    </select>
  </td>
</tr>

          </table>
          <a href="/admin/users-list" class="btn btn-secondary mt-3">Back</a>
        </div>
      </div>
    </div>
  </div>
</div>


</div>


@section('scripts')

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
                    toastr.success('User block status updated to ' + (newBlockStatus === 'Y' ? 'Blocked' : 'Unblocked'));
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
