@extends('layout.admin')
@section('content')
<main class="nxl-container">
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">सेटिंग</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">डैशबोर्ड</a></li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
                <div class="page-header-right-items">
                    <div class="d-flex">
                        <a href="javascript:void(0)" onclick="window.history.back();" class="page-header-right-close-toggle">
                            <i class="feather-arrow-left me-2"></i>
                            <span>पीछे</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ page-header ] end -->

        <!-- [ Main Content ] start -->
        <div class="main-content">
            <div class="row">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="col-lg-6">
                    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.profile.update') }}">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">प्रोफ़ाइल अपडेट करें</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">प्रोफ़ाइल फोटो</label>
                                    <input type="file" name="profile_photo" class="form-control">
                                    @if(Auth::user()->profile_photo)
                                        <img src="{{ asset('uploads/profile/' . Auth::user()->profile_photo) }}" width="80" class="mt-2">
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">नाम</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', Auth::user()->name) }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">पता</label>
                                    <textarea name="address" class="form-control">{{ old('address', Auth::user()->address) }}</textarea>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success">सेव करें</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Password Change Section -->
                <div class="col-lg-6">
                 <form method="POST" action="{{ route('admin.password.update') }}">
    @csrf
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">पासवर्ड बदलें</h5>
        </div>
        <div class="card-body">

            {{-- Current Password --}}
            <div class="mb-3 position-relative">
                <label class="form-label">वर्तमान पासवर्ड</label>
                <div class="input-group">
                    <input type="password" id="current_password" name="current_password" class="form-control @error('current_password') is-invalid @enderror">
                    <button type="button" class="btn btn-outline-secondary toggle-password" data-target="current_password">
                        👁️
                    </button>
                </div>
                @error('current_password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            {{-- New Password --}}
            <div class="mb-3 position-relative">
                <label class="form-label">नया पासवर्ड</label>
                <div class="input-group">
                    <input type="password" id="new_password" name="new_password" class="form-control @error('new_password') is-invalid @enderror">
                    <button type="button" class="btn btn-outline-secondary toggle-password" data-target="new_password">
                        👁️
                    </button>
                </div>
                @error('new_password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="mb-3 position-relative">
                <label class="form-label">पासवर्ड की पुष्टि करें</label>
                <div class="input-group">
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control">
                    <button type="button" class="btn btn-outline-secondary toggle-password" data-target="new_password_confirmation">
                        👁️
                    </button>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-warning">पासवर्ड अपडेट करें</button>
            </div>
        </div>
    </div>
</form>



                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</main>

<script>
    document.querySelectorAll('.toggle-password').forEach(function(button) {
        button.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            if (input.type === "password") {
                input.type = "text";
                this.innerHTML = "🙈"; // Change icon when shown
            } else {
                input.type = "password";
                this.innerHTML = "👁️"; // Change icon when hidden
            }
        });
    });
</script>


@endsection
