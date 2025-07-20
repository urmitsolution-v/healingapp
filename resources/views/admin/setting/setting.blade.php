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

                    
                    <div class="col-lg-12">
           <form method="post" enctype="multipart/form-data">
    @csrf
    <div class="card stretch stretch-full">
        <div class="card-body lead-status">
            <div class="mb-5 d-flex align-items-center justify-content-between">
                <h5 class="fw-bold mb-0 me-4">
                    <span class="d-block mb-2">समय अपडेट करें</span>
                </h5>
            </div>

            {{-- समूह एक --}}
            <div class="row ">
                <h6>समूह एक</h6>
                <div class="col-md-3 mb-4">
                    <label class="form-label">दिन</label>
                    <input type="number" name="groupone[days]" class="form-control" value="{{ old('groupone.days', $model->groupone['days'] ?? 0) }}">
                </div>
                <div class="col-md-3 mb-4">
                    <label class="form-label">घंटे</label>
                    <input type="number" name="groupone[hours]" class="form-control" value="{{ old('groupone.hours', $model->groupone['hours'] ?? 0) }}">
                </div>
                <div class="col-md-3 mb-4">
                    <label class="form-label">मिनट</label>
                    <input type="number" name="groupone[minutes]" class="form-control" value="{{ old('groupone.minutes', $model->groupone['minutes'] ?? 0) }}">
                </div>
                <div class="col-md-3 mb-4">
                    <label class="form-label">डिलीवरी चार्ज (₹)</label>
                    <input type="number" name="groupone_charge" class="form-control" min="0" value="{{ old('groupone_charge', $model->groupone_charge ?? 0) }}">
                </div>
            </div>

            {{-- समूह दो --}}
            <div class="row ">
                <h6>समूह दो</h6>
                <div class="col-md-3 mb-4">
                    <label class="form-label">दिन</label>
                    <input type="number" name="grouptwo[days]" class="form-control" value="{{ old('grouptwo.days', $model->grouptwo['days'] ?? 0) }}">
                </div>
                <div class="col-md-3 mb-4">
                    <label class="form-label">घंटे</label>
                    <input type="number" name="grouptwo[hours]" class="form-control" value="{{ old('grouptwo.hours', $model->grouptwo['hours'] ?? 0) }}">
                </div>
                <div class="col-md-3 mb-4">
                    <label class="form-label">मिनट</label>
                    <input type="number" name="grouptwo[minutes]" class="form-control" value="{{ old('grouptwo.minutes', $model->grouptwo['minutes'] ?? 0) }}">
                </div>
                 <div class="col-md-3 mb-4">
                    <label class="form-label">डिलीवरी चार्ज (₹)</label>
                    <input type="number" name="grouptwo_charge" class="form-control" min="0" value="{{ old('grouptwo_charge', $model->grouptwo_charge ?? 0) }}">
                </div>
            </div>

            {{-- समूह तीन --}}
            <div class="row ">
                <h6>समूह तीन</h6>
                <div class="col-md-3 mb-4">
                    <label class="form-label">दिन</label>
                    <input type="number" name="groupthree[days]" class="form-control" value="{{ old('groupthree.days', $model->groupthree['days'] ?? 0) }}">
                </div>
                <div class="col-md-3 mb-4">
                    <label class="form-label">घंटे</label>
                    <input type="number" name="groupthree[hours]" class="form-control" value="{{ old('groupthree.hours', $model->groupthree['hours'] ?? 0) }}">
                </div>
                <div class="col-md-3 mb-4">
                    <label class="form-label">मिनट</label>
                    <input type="number" name="groupthree[minutes]" class="form-control" value="{{ old('groupthree.minutes', $model->groupthree['minutes'] ?? 0) }}">
                </div>
                 <div class="col-md-3 mb-4">
                    <label class="form-label">डिलीवरी चार्ज (₹)</label>
                    <input type="number" name="groupthree_charge" class="form-control" min="0" value="{{ old('groupthree_charge', $model->groupthree_charge ?? 0) }}">
                </div>
            </div>

            {{-- डिलीवरी चार्ज --}}
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label">डिलीवरी चार्ज (₹)</label>
                    <input type="number" name="delivery_charge" class="form-control" value="{{ old('delivery_charge', $model->delivery_charge ?? 0) }}">
                </div>
            </div>

            <div class="col-12 text-center d-flex justify-content-center">
                <button type="submit" class="btn btn-info me-2">सेव करे</button>
                <button type="button" class="btn btn-secondary" onclick="window.history.back();">रद्द करें</button>
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



    @section('scripts')
  
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const wrapper = document.getElementById('product-type-wrapper');

        wrapper.addEventListener('click', function (e) {
            if (e.target.classList.contains('add-more')) {
                const uniqueId = Math.floor(Math.random() * 100000); // JS rand equivalent

                const newField = document.createElement('div');
                newField.classList.add('row', 'product-type-group', 'mb-3');

                newField.innerHTML = `
                    <div class="col-lg-5">
                        <label class="form-label">उत्पाद प्रकार</label>
                        <input type="text" name="product[${uniqueId}][type]" class="form-control" placeholder="🛒 उत्पाद प्रकार">
                    </div>
                    <div class="col-lg-5">
                        <label class="form-label">उत्पाद प्रकार की कीमत</label>
                        <input type="number" name="product[${uniqueId}][price]" class="form-control" placeholder="₹ उत्पाद प्रकार की कीमत">
                    </div>
                    <div class="col-lg-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger remove">−</button>
                    </div>
                `;
                wrapper.appendChild(newField);
            }

            if (e.target.classList.contains('remove')) {
                e.target.closest('.product-type-group').remove();
            }
        });
    });
</script>



@endsection
@endsection