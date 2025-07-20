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
        Add User
      </li>
    </ol>
  </div>

  <div class="app-body">
    <div class="row gx-3">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">Add User</h5>
          </div>
          <form  method="POST">
            @csrf
            <div class="card-body">
              <div class="row gx-3">
<div class="col-lg-4">
  <div class="mb-3">
    <label class="form-label" for="name">Name</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror"
           name="name" value="{{ old('name') }}" placeholder="Enter Name" >
    @error('name')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
</div>

<div class="col-lg-4">
  <div class="mb-3">
    <label class="form-label" for="email">Email</label>
    <input type="email" class="form-control @error('email') is-invalid @enderror"
           name="email" value="{{ old('email') }}" placeholder="Enter Email" >
    @error('email')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
</div>

<div class="col-lg-4">
  <div class="mb-3">
    <label class="form-label" for="password">Password</label>
    <input type="password" class="form-control @error('password') is-invalid @enderror"
           name="password" placeholder="Enter Password" >
    @error('password')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
</div>

<div class="col-lg-4">
  <div class="mb-3">
    <label class="form-label" for="dob">Date of Birth</label>
    <input type="date" class="form-control @error('dob') is-invalid @enderror"
           name="dob" value="{{ old('dob') }}" >
    @error('dob')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
</div>

<div class="col-lg-4">
  <div class="mb-3">
    <label class="form-label" for="address">Address</label>
    <input type="text" class="form-control @error('address') is-invalid @enderror"
           name="address" value="{{ old('address') }}" placeholder="Enter Address" >
    @error('address')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
</div>

<div class="col-lg-4">
  <div class="mb-3">
    <label class="form-label" for="phone">Phone</label>
    <input type="text" class="form-control @error('phone') is-invalid @enderror"
           name="phone" value="{{ old('phone') }}" placeholder="Enter Phone Number" >
    @error('phone')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
</div>

                <div class="col-12">
                  <div class="d-flex justify-content-end gap-2">
                    <a href="/admin/users-list" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Add User</button>
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
