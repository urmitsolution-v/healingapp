@extends('layout.admin')
@section('content')
  <main class="nxl-container">
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">राज्य</h5>
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
                    {{-- <div class="d-md-none d-flex align-items-center">
                        <a href="javascript:void(0)" class="page-header-right-open-toggle">
                            <i class="feather-align-right fs-20"></i>
                        </a>
                    </div> --}}

                    
                </div>
            </div>
         
            <!-- [ page-header ] end -->
            <!-- [ Main Content ] start -->
            <div class="main-content">
                <div class="row">
                    
                    <div class="col-lg-12">
                        
                <form method="post">
                            @csrf
                        <div class="card stretch stretch-full">
                            <div class="card-body lead-status">
                               <div class="mb-5 d-flex align-items-center justify-content-between">
                                    <h5 class="fw-bold mb-0 me-4">
                                        <span class="d-block mb-2">राज्य का नाम बदलिये</span>
                                    </h5>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-lg-4 mb-4">
                                        <label class="form-label">राज्य का नाम *</label>
                                       <input type="text" name="state_name" value="{{ $state->name ?? "" }}" class="form-control">
                                         @error('state_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                                    </div>
                                    <div class="col-12 text-center d-flex justify-content-center ">
                                        <button type="save" class="btn btn-info me-2">सेव करे</button>
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