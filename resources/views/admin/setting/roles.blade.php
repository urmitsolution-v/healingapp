@extends('layout.admin')
@section('content')
  <main class="nxl-container">
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">भूमिका की सूची</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">डैशबोर्ड</a></li>
                        <li class="breadcrumb-item">भूमिका की सूची</li>
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
                    <div class="col-12">
                        <div>
                        <a href="/new-role" class="btn btn-primary d-inline-block mb-3">नया भूमिका जोड़ें</a>
                        </div>
                    </div>
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
    <th>भूमिका का नाम</th>
</tr>

</thead>

<tbody>
@foreach($roles as $key => $role)
<tr>
    <td>{{ $key + 1 }}</td>
    <td>
        <div class="d-flex gap-2">
            <a href="/edit-role/{{ $role->id }}" class="btn btn-sm btn-success">
                <i class="feather feather-edit"></i>
            </a>
            <a href="/delete-role/{{ $role->id }}" onclick="return confirm('Are you sure you want to delete this role?');" class="btn btn-sm btn-danger">
                <i class="feather feather-trash"></i>
            </a>
             <a href="/role-permissions/{{ $role->id }}" class="btn btn-sm btn-warning">
                <i class="feather feather-key"></i>
            </a>
        </div>
    </td>
    <td>{{ $role->role_name }}</td>
</tr>
@endforeach

</tbody>

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





@endsection