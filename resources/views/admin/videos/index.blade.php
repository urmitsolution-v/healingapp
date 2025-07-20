@extends('layout.admin')
@section('content')
<main class="nxl-container">
    <div class="nxl-content">
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">वीडियो सूची</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">डैशबोर्ड</a></li>
                    <li class="breadcrumb-item">वीडियो सूची</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
                <div class="d-flex">
                    <a href="javascript:void(0)" onclick="window.history.back();" class="page-header-right-close-toggle">
                        <i class="feather-arrow-left me-2"></i>
                        <span>पीछे</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="main-content">
            <div class="row">
                <div class="col-lg-12">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="card stretch stretch-full">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover" id="videoTable">
                                    <thead>
                                        <tr>
                                            <th>क्रम</th>
                                            <th>मोबाइल नंबर</th>
                                            <th>गांव</th>
                                            <th>विवरण</th>
                                            <th>वीडियो</th>
                                             <th>कैप्चर कोड</th>
                                            <th>अपलोड समय</th>
                                            <th>कार्य</th>
                                           
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</main>

@section('scripts')
<script src="{{ url('admin') }}/assets/vendors/js/dataTables.min.js"></script>
<script src="{{ url('admin') }}/assets/vendors/js/dataTables.bs5.min.js"></script>
<script>
$(document).ready(function () {
    $('#videoTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('/videos') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'mobile_number', name: 'mobile_number' },
            { data: 'village', name: 'village' },
            { data: 'description', name: 'description' },
            { data: 'video', name: 'video', orderable: false, searchable: false },
            { data: 'capture_code', name: 'capture_code'},
            // { data: 'status', name: 'status' },
            { data: 'created_at', name: 'created_at' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false },
        ]
    });
});
</script>
@endsection
@endsection
