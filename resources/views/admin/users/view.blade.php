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
            </table>
            <a href="/admin/users-list" class="btn btn-secondary mt-3">Back</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
