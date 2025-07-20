@extends('layout.admin')
@section('content')
        <!-- App container starts -->
        <div class="app-container">

          <!-- App hero header starts -->
          <div class="app-hero-header d-flex align-items-center">

            <!-- Breadcrumb starts -->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <i class="ri-home-8-line lh-1 pe-3 me-3 border-end"></i>
                <a href="index.html">Home</a>
              </li>
              <li class="breadcrumb-item text-primary" aria-current="page">
                Dashboard
              </li>
            </ol>
            <!-- Breadcrumb ends -->

           

          </div>
          <!-- App Hero header ends -->

          <!-- App body starts -->
          <div class="app-body">

            <!-- Row starts -->
            <div class="row gx-3">
              <div class="col-xxl-12 col-sm-12">
                <div class="card mb-3 bg-2">
                  <div class="card-body">
                    <div class="py-4 px-3 text-white">
                      @php
    date_default_timezone_set('Asia/Kolkata');
    $hour = date('H'); // 24-hour format
    $greeting = 'Hello';

    if ($hour >= 5 && $hour < 12) {
        $greeting = 'Good Morning';
    } elseif ($hour >= 12 && $hour < 17) {
        $greeting = 'Good Afternoon';
    } elseif ($hour >= 17 && $hour < 21) {
        $greeting = 'Good Evening';
    } else {
        $greeting = 'Good Night';
    }
@endphp

<h6>{{ $greeting }},</h6>
<h2>{{ Auth::user()->name ?? "" }}</h2>
                   
                   
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Row ends -->

            <!-- Row starts -->
            <div class="row gx-3">
              <div class="col-xl-3 col-sm-6 col-12">
                <div class="card mb-3">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="p-2 border border-success rounded-circle me-3">
                        <div class="icon-box md bg-success-subtle rounded-5">
                          <i class="ri-surgical-mask-line fs-4 text-success"></i>
                        </div>
                      </div>
                      <div class="d-flex flex-column">
                        <h2 class="lh-1">10</h2>
                        <p class="m-0">Pending Members</p>
                      </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-1">
                      <a class="text-success" href="javascript:void(0);">
                        <span>View All</span>
                        <i class="ri-arrow-right-line text-success ms-1"></i>
                      </a>
                   
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-sm-6 col-12">
                <div class="card mb-3">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="p-2 border border-primary rounded-circle me-3">
                        <div class="icon-box md bg-primary-subtle rounded-5">
                          <i class="ri-lungs-line fs-4 text-primary"></i>
                        </div>
                      </div>
                      <div class="d-flex flex-column">
                        <h2 class="lh-1">10</h2>
                        <p class="m-0">Pending Bids</p>
                      </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-1">
                      <a class="text-primary" href="javascript:void(0);">
                        <span>View All</span>
                        <i class="ri-arrow-right-line ms-1"></i>
                      </a>
                   
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-sm-6 col-12">
                <div class="card mb-3">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="p-2 border border-danger rounded-circle me-3">
                        <div class="icon-box md bg-danger-subtle rounded-5">
                          <i class="ri-microscope-line fs-4 text-danger"></i>
                        </div>
                      </div>
                      <div class="d-flex flex-column">
                        <h2 class="lh-1">980</h2>
                        <p class="m-0">Total Members</p>
                      </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-1">
                      <a class="text-danger" href="javascript:void(0);">
                        <span>View All</span>
                        <i class="ri-arrow-right-line ms-1"></i>
                      </a>
                  
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-sm-6 col-12">
                <div class="card mb-3">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="p-2 border border-warning rounded-circle me-3">
                        <div class="icon-box md bg-warning-subtle rounded-5">
                          <i class="ri-money-dollar-circle-line fs-4 text-warning"></i>
                        </div>
                      </div>
                      <div class="d-flex flex-column">
                        <h2 class="lh-1">100</h2>
                        <p class="m-0">Reports</p>
                      </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-1">
                      <a class="text-warning" href="javascript:void(0);">
                        <span>View All</span>
                        <i class="ri-arrow-right-line ms-1"></i>
                      </a>
                   
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- App body ends -->

          <!-- App footer ends -->

        </div>
        <!-- App container ends -->

        @endsection