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
        {{ $user ? 'Edit User' : 'Add User' }}
      </li>
    </ol>
  </div>

  <div class="app-body">
    <div class="row gx-3">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">{{ $user ? 'Edit User' : 'Add User' }}</h5>
          </div>

          <form method="POST" action="">
            @csrf

            <div class="card-body">
              <div class="row gx-3">

                <div class="col-lg-4">
                  <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                      value="{{ old('name', $user->name ?? '') }}" placeholder="Enter Name">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                  </div>
                </div>

                <div class="col-lg-4">
                  <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                      value="{{ old('email', $user->email ?? '') }}" placeholder="Enter Email">
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                  </div>
                </div>

                <div class="col-lg-4">
                  <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                      placeholder="{{ $user ? 'Leave blank to keep current password' : 'Enter Password' }}">
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                  </div>
                </div>

                <div class="col-lg-4">
                  <div class="mb-3">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" name="dob" class="form-control @error('dob') is-invalid @enderror"
                      value="{{ old('dob', $user->dob ?? '') }}">
                    @error('dob') <div class="invalid-feedback">{{ $message }}</div> @enderror
                  </div>
                </div>

                <div class="col-lg-4">
                  <div class="mb-3">
                    <label class="form-label">Address</label>
                    <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                      value="{{ old('address', $user->address ?? '') }}" placeholder="Enter Address">
                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                  </div>
                </div>

                <div class="col-lg-4">
                  <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                      value="{{ old('phone', $user->phone ?? '') }}" placeholder="Enter Phone Number">
                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                  </div>
                </div>

                <div class="col-12">
                  <div class="d-flex justify-content-end gap-2">
                    <a href="/admin/users-list" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                      {{ $user ? 'Update User' : 'Add User' }}
                    </button>
                  </div>
                </div>

              </div>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
