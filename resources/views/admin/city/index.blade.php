@extends('layout.admin')
@section('content')
  <main class="nxl-container">
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">सिटी सूची</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">डैशबोर्ड</a></li>
                        <li class="breadcrumb-item">सिटी सूची</li>
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
                    @if(canaddNewData('location_master'))
                    <div class="col-12">
                        <div>
                        <a href="/new-city" class="btn btn-primary d-inline-block mb-3">नया सिटी जोड़े</a>
                        </div>
                    </div>
                    @endif
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
                                    <table class="table table-hover" id="dataTable">
                                        <thead>
                                            <tr>
                                               
                                                <th>क्रम</th>
                                                <th>गतिविधि</th>
                                                <th>राज्य</th>
                                                <th>सिटी का नाम</th>
                                            </tr>
                                        </thead>
                                        {{-- <tbody>
                                            <tr class="single-item">
                                             
                                                <td> --}}
                                                   {{-- 1 --}}
                                                    {{-- <a href="customers-view.html" class="hstack gap-3">
                                                        <div class="avatar-image avatar-md">
                                                            <img src="{{ url('admin') }}/assets/images/avatar/1.png" alt="" class="img-fluid">
                                                        </div>
                                                        <div>
                                                            <span class="text-truncate-1-line">Alexandra Della</span>
                                                        </div>
                                                    </a> --}}
                                                {{-- </td>
                                                <td>
                                                  1  
                                                </td>
                                                <td>
                                                  1  
                                                </td>
                                                <td>
                                                  1  
                                                </td>
                                                <td>
                                                   1
                                                </td>
                                                <td><a href="tel:">+1 (375) 9632 548</a></td>
                                                <td>2023-04-05, 00:05PM</td>
                                                <td>
                                                    <select class="form-control" data-select2-selector="status">
                                                        <option value="success" data-bg="bg-success" selected>Active</option>
                                                        <option value="warning" data-bg="bg-warning">Inactive</option>
                                                        <option value="danger" data-bg="bg-danger">Declined</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <a href="customers-view.html" class="avatar-text avatar-md">
                                                            <i class="feather feather-eye"></i>
                                                        </a>
                                                        <div class="dropdown">
                                                            <a href="javascript:void(0)" class="avatar-text avatar-md" data-bs-toggle="dropdown" data-bs-offset="0,21">
                                                                <i class="feather feather-more-horizontal"></i>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:void(0)">
                                                                        <i class="feather feather-edit-3 me-3"></i>
                                                                        <span>Edit</span>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item printBTN" href="javascript:void(0)">
                                                                        <i class="feather feather-printer me-3"></i>
                                                                        <span>Print</span>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:void(0)">
                                                                        <i class="feather feather-clock me-3"></i>
                                                                        <span>Remind</span>
                                                                    </a>
                                                                </li>
                                                                <li class="dropdown-divider"></li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:void(0)">
                                                                        <i class="feather feather-archive me-3"></i>
                                                                        <span>Archive</span>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:void(0)">
                                                                        <i class="feather feather-alert-octagon me-3"></i>
                                                                        <span>Report Spam</span>
                                                                    </a>
                                                                </li>
                                                                <li class="dropdown-divider"></li>
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:void(0)">
                                                                        <i class="feather feather-trash-2 me-3"></i>
                                                                        <span>Delete</span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                   
                                        </tbody> --}}
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
$(document).ready(function() {
    $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('city_list') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },

            { data: 'actions', name: 'actions', orderable: false, searchable: false },

            { data: 'state_name', name: 'state_name'},
            { data: 'name', name: 'name'},
        ]
    });
});
</script>

    @endsection

@endsection