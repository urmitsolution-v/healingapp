@extends('layout.admin')

@section('content')
<main class="nxl-container">
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">सप्लायर</h5>
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
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <div class="mb-5 d-flex align-items-center justify-content-between">
                                    <h5 class="fw-bold mb-0 me-4">
                                        <span class="d-block mb-2">सप्लायर अपडेट करें</span>
                                    </h5>
                                </div>

                                <div class="row justify-content-center">
                                    <div class="col-lg-6 mb-4">
                                        <label class="form-label">सप्लायर का नाम *</label>
                                        <input type="text" name="name" class="form-control" placeholder="नाम दर्ज करें" value="{{ old('name', $supplier->name) }}">
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6 mb-4">
                                        <label class="form-label">मोबाइल नंबर *</label>
                                        <input type="text" name="phone" class="form-control" placeholder="मोबाइल नंबर दर्ज करें" value="{{ old('phone', $supplier->phone) }}">
                                        @error('phone')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6 mb-4">
                                        <label class="form-label">पासवर्ड (यदि बदलना हो)</label>
                                        <input type="password" name="password" class="form-control" placeholder="पासवर्ड दर्ज करें">
                                        @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6 mb-4">
                                        <label class="form-label">पासवर्ड की पुष्टि करें</label>
                                        <input type="password" name="password_confirmation" class="form-control" placeholder="पासवर्ड की पुष्टि करें">
                                        @error('password_confirmation')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6 mb-4">
                                        <label class="form-label">राज्य *</label>
                                        <input type="text" name="state" class="form-control" placeholder="राज्य दर्ज करें" value="{{ old('state', $supplier->state) }}">
                                        @error('state')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6 mb-4">
                                        <label class="form-label">शहर *</label>
                                        <input type="text" name="city" class="form-control" placeholder="शहर दर्ज करें" value="{{ old('city', $supplier->city) }}">
                                        @error('city')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6 mb-4">
                                        <label class="form-label">गांव *</label>
                                        <select name="village" class="form-select">
                                            <option value="">गांव चुनें</option>
                                            @foreach (App\Models\Locations::where('type', 'village')->orderBy('name')->get() as $village)
                                                <option value="{{ $village->id }}" {{ old('village', $supplier->village) == $village->id ? 'selected' : '' }}>
                                                    {{ $village->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('village')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-12 text-center d-flex justify-content-center">
                                        <button type="submit" class="btn btn-info me-2">अपडेट करें</button>
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
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('select[multiple]').select2({
                placeholder: "गांव चुनें"
            });
        });
    </script>
@endsection
