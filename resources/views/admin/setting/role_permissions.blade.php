@extends('layout.admin')
@section('content')
  <main class="nxl-container">
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">अधिकार</h5>
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
                    <span class="d-block mb-2">नया भूमिका जोड़ें</span>
                </h5>
            </div>
            <div class="row justify-content-center">

                <div class="col-12 mb-4">
                    <label class="form-label fw-bold">अनुमतियाँ चुनें *</label>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>मेनू</th>
                                    <th>जोड़ें</th>
                                    <th>संपादित करें</th>
                                    <th>देखें</th>
                                    <th>हटाएं</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $menus = [
                                        'dashboard' => 'डैशबोर्ड',
                                        'users' => 'उपयोगकर्ताओं',
                                        'location_master' => 'स्थान मास्टर',
                                        'bills' => 'बिल',
                                        'bull_details' => 'बैल विवरण',
                                        'advertisement' => 'विज्ञापन',
                                        'products' => 'उत्पाद',
                                        'order_history' => 'ऑर्डर इतिहास',
                                        'village_count' => 'ग्रामवार गिनती',
                                        'videos' => 'वीडियो',
                                        'settings' => 'सेटिंग',
                                        'admins' => 'व्यवस्थापक जोड़ें',
                                        'helpline' => 'हेल्पलाइन नंबर',
                                    ];

                                    $actions = ['add' => 'add', 'edit' => 'edit', 'view' => 'view', 'delete' => 'delete'];
                                @endphp

                              @foreach ($menus as $key => $label)
<tr class="text-center align-middle">
    <td class="text-start">{{ $label }}</td>
    @foreach ($actions as $actionKey => $action)
        @php
            $isChecked = !empty($rolePermissions[$key][$action]);
        @endphp
        <td>
            <input type="checkbox"
                name="permissions[{{ $key }}][{{ $action }}]"
                value="1"
                class="form-check-input"
                {{ $isChecked ? 'checked' : '' }}>
        </td>
    @endforeach
</tr>
@endforeach

                            </tbody>
                        </table>
                    </div>

                    @error('permissions')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-12 text-center d-flex justify-content-center">
                    <button type="submit" class="btn btn-info me-2">सेव करे</button>
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
      {{-- footer  --}}
    </main>



   
@endsection