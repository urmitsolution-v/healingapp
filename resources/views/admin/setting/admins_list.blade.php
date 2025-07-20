@extends('layout.admin')
@section('content')
  <main class="nxl-container">
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">व्यवस्थापक की सूची</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">डैशबोर्ड</a></li>
                        <li class="breadcrumb-item">व्यवस्थापक की सूची</li>
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
                      @if(canaddNewData('admins'))
                    <div class="col-12">
                        <div>
                        <a href="/new-admin" class="btn btn-primary d-inline-block mb-3">नया व्यवस्थापक जोड़ें</a>
                        </div>
                    </div>
                    @endif
                    <div class="col-lg-12">
                         @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                        <div class="card stretch stretch-full">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="dataTable">
                                        <thead>
<tr>
    <th>क्रम</th>
    <th>गतिविधि</th>
    <th>व्यवस्थापक का नाम</th>
    <th>व्यवस्थापक मोबाइल नंबर</th>
    <th>व्यवस्थापक ईमेल</th>
    <th>पता</th>
</tr>

</thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
      {{-- footer  --}}
    </main>


    @section('css')
    <!--! END: Bootstrap CSS-->
    <!--! BEGIN: Vendors CSS-->
    <link rel="stylesheet" type="text/css" href="{{ url('admin') }}/assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="{{ url('admin') }}/assets/vendors/css/dataTables.bs5.min.css">
    <link rel="stylesheet" type="text/css" href="{{ url('admin') }}/assets/vendors/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="{{ url('admin') }}/assets/vendors/css/select2-theme.min.css">
    <!--! END: Vendors CSS-->
    <!--! BEGIN: Custom CSS-->
    @endsection

    @section('scripts')
  {{-- <script src="{{ url('admin') }}/assets/vendors/js/vendors.min.js"></script> --}}
    <!-- vendors.min.js {always must need to be top} -->
    <script src="{{ url('admin') }}/assets/vendors/js/dataTables.min.js"></script>
    <script src="{{ url('admin') }}/assets/vendors/js/dataTables.bs5.min.js"></script>
    <script src="{{ url('admin') }}/assets/vendors/js/select2.min.js"></script>
    <script src="{{ url('admin') }}/assets/vendors/js/select2-active.min.js"></script>
    <!--! END: Vendors JS !-->
    <!--! BEGIN: Apps Init  !-->
    <script src="{{ url('admin') }}/assets/js/customers-init.min.js"></script>

    <script>
$(document).ready(function () {
    var table = $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('setting.admins_list') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false },
            { data: 'name', name: 'name', orderable: false, searchable: false },
            { data: 'phone', name: 'phone', orderable: false, searchable: false },
            { data: 'email', name: 'email' },
            { data: 'address', name: 'address' },
        ]
    });

    // Status toggle
    $(document).on('change', '.toggle-status', function () {
        var id = $(this).data('id');
        var status = $(this).is(':checked') ? "Y" : "N";

        $.ajax({
            url: '{{ route("product.status.update", ":id") }}'.replace(':id', id),
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                status: status
            },
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function () {
                toastr.error('कुछ त्रुटि हुई।');
            }
        });
    });
});
</script>



@endsection
@endsection