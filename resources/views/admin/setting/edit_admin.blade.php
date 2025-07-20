@extends('layout.admin')
@section('content')
<main class="nxl-container">
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">व्यवस्थापक</h5>
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
                <div class="col-lg-12">
                    <form method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card stretch stretch-full">
                            <div class="card-body lead-status">
                                <div class="mb-5 d-flex align-items-center justify-content-between">
                                    <h5 class="fw-bold mb-0 me-4">
                                        <span class="d-block mb-2">
                                            {{ isset($admin) ? 'व्यवस्थापक अपडेट करें' : 'नया व्यवस्थापक जोड़ें' }}
                                        </span>
                                    </h5>
                                </div>
                                <div class="row justify-content-center">
                                    <!-- Full Name -->
                                    <div class="col-lg-6 mb-4">
                                        <label class="form-label">व्यवस्थापक पूरा नाम *</label>
                                        <input type="text" name="name" class="form-control" placeholder="व्यवस्थापक पूरा नाम" value="{{ old('name', $admin->name ?? '') }}">
                                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <!-- Role -->
                                    <div class="col-lg-6 mb-4">
                                        <label class="form-label">भूमिका चुनें *</label>
                                        <select name="role" class="form-select">
                                            <option value="">भूमिका चुनें</option>
                                            @foreach (App\Models\Role::latest()->get() as $role)
                                                <option value="{{ $role->id }}"
                                                    {{ old('role', $admin->role_id ?? '') == $role->id ? 'selected' : '' }}>
                                                    {{ $role->role_name }} 
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('role') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    @php
    $oldOrderVillages = old('order_villages') ?? (isset($admin) ? $admin->order_villages : []);
@endphp

<div class="col-lg-6 mb-4">
    <label class="form-label">ऑर्डर के लिए गांव चुनें *</label>
    <select name="order_villages[]" class="form-select" multiple>
        @foreach (App\Models\Locations::where('type', 'village')->orderBy('id', 'DESC')->get() as $village)
            <option value="{{ $village->id }}" 
                {{ in_array($village->id, $oldOrderVillages) ? 'selected' : '' }}>
                {{ $village->name }}
            </option>
        @endforeach
    </select>
    @error('order_villages')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>


                                    <!-- Stock Villages -->
 @php
    $oldStockVillages = old('stock_villages') ?? (isset($admin) ?$admin->stock_villages : []);
@endphp

<div class="col-lg-6 mb-4">
    <label class="form-label">स्टॉक प्रबंधन के लिए गांव चुनें *</label>
    <select name="stock_villages[]" class="form-select" multiple>
        @foreach (App\Models\Locations::where('type', 'village')->orderBy('id', 'DESC')->get() as $village)
            <option value="{{ $village->id }}" 
                {{ in_array($village->id, $oldStockVillages) ? 'selected' : '' }}>
                {{ $village->name }}
            </option>
        @endforeach
    </select>
    @error('stock_villages')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>


                                    <!-- Mobile -->
                                    <div class="col-lg-6 mb-4">
                                        <label class="form-label">व्यवस्थापक मोबाइल नंबर *</label>
                                        <input type="text" name="mobile" class="form-control" placeholder="मोबाइल नंबर दर्ज करें" value="{{ old('mobile', $admin->phone ?? '') }}">

                                        @error('mobile') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="col-lg-6 mb-4">
                                        <label class="form-label">व्यवस्थापक ईमेल *</label>
                                        <input type="email" name="email" class="form-control" placeholder="ईमेल दर्ज करें" value="{{ old('email', $admin->email ?? '') }}">
                                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <!-- Address -->
                                    <div class="col-lg-12 mb-4">
                                        <label class="form-label">व्यवस्थापक का पता *</label>
                                        <textarea name="address" class="form-control" placeholder="पता दर्ज करें" rows="3">{{ old('address', $admin->address ?? '') }}</textarea>
                                        @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <!-- Password -->
                                    <div class="col-lg-6 mb-4">
                                        <label class="form-label">पासवर्ड {{ isset($admin) ? '(यदि बदलना हो तो भरें)' : '*' }}</label>
                                        <input type="password" name="password" class="form-control" placeholder="पासवर्ड दर्ज करें">
                                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="col-lg-6 mb-4">
                                        <label class="form-label">पासवर्ड की पुष्टि करें {{ isset($admin) ? '(यदि बदलना हो तो भरें)' : '*' }}</label>
                                        <input type="password" name="password_confirmation" class="form-control" placeholder="पासवर्ड की पुष्टि करें">
                                        @error('password_confirmation') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <!-- Buttons -->
                                    <div class="col-12 text-center d-flex justify-content-center">
                                        <button type="submit" class="btn btn-info me-2">सेव करें</button>
                                        <button type="button" class="btn btn-secondary" onclick="window.history.back();">रद्द करें</button>
                                    </div>
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

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('select[multiple]').select2({
            placeholder: "गांव चुनें"
        });
    });
</script>
@endsection
@endsection
