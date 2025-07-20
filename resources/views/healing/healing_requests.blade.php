@extends('healing.layout.layout')

@section('content')

    <style>
        .page.page-home {
    padding-bottom: 90px !important;
}
    </style>

      <div class="main-container">
         <div id="app">
            <div class="view view-main view-init ios-edges">
               <div class="page page-home page-with-subnavbar home-main-page">
                  <div class="tabs">
                     <div id="tab-home" class="tab tab-active tab-home">
                        <!-- home -->
                      <div class="navbar navbar-home">
                        <div class="navbar-inner header-top-bar">
                           <div class="back-link">
                            <a class="link back" href="/">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M10.8284 12.0007L15.7782 16.9504L14.364 18.3646L8 12.0007L14.364 5.63672L15.7782 7.05093L10.8284 12.0007Z"></path></svg>
                        </a></div>
                           <div class="header-title">Healing Request</div>
                           <div class="">
                           </div>
                        </div>
                     </div>

    
                        <div class="yourrequestsBox">
                          <div class="d-flex justify-content-between align-items-center mb-2">
        <p class="left0crbox"> (<span id="loadedCount">0</span>/<span id="totalCount">0</span>)</p>
        <div class="d-flex minorbox">
            <input type="date" id="filterDate" class="form-control me-2" style="max-width: 200px;">
            <button id="searchDateBtn" class="btn btn-primary">
                <svg width="15" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z"></path></svg>

            </button>
        </div>
    </div>

                            
                          <div class="newRequestBox">
                                <div>
                                    <a href="/new-healing-request">
                                        New Request 
                                        <svg width="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z"></path></svg>
                                    </a>
                                </div>
                            </div>

                        </div>


           <div class="myHealingRequests" id="healingRequestList"></div>


                <div id="healingLoader" style="display:none; text-align:center;">
                    <img src="{{ url('newadmin') }}/loader.gif" style="width: 111px;height: 50px;object-fit: contain;" alt="Loading..." />
                </div>

                        {{-- <div class="myHealingRequests">


                            <div class="newRequestBox">
                                <div>
                                    <a href="/new-healing-request">
                                        New Request 
                                        <svg width="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z"></path></svg>
                                    </a>
                                </div>
                            </div>

                            <div class="listBox">
                                <div class="left-box">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM13 12V7H11V14H17V12H13Z"></path></svg>
                                </div>
                                <div class="right-box">
                                    <p>Today at 10:00 AM - For Stomach Ache</p>
                                    <div>
                                        <span>Unassigned Yet</span>
                                        <button>Cancel Request</button>
                                    </div>
                                </div>
                            </div>

                              <div class="listBox">
                                <div class="left-box">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM13 12V7H11V14H17V12H13Z"></path></svg>
                                </div>
                                <div class="right-box">
                                    <p>Today at 10:00 AM - For Stomach Ache</p>
                                    <div>
                                        <span>Unassigned Yet</span>
                                        <button>Cancel Request</button>
                                    </div>
                                </div>
                            </div>


                              <div class="listBox">
                                <div class="left-box">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM13 12V7H11V14H17V12H13Z"></path></svg>
                                </div>
                                <div class="right-box">
                                    <p>Today at 10:00 AM - For Stomach Ache</p>
                                    <div>
                                        <span>Unassigned Yet</span>
                                        <button>Cancel Request</button>
                                    </div>
                                </div>
                            </div>

                            <!-- -success  -->

                             <div class="listBox successbox">
                                <div class="left-box">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M9.9997 15.1709L19.1921 5.97852L20.6063 7.39273L9.9997 17.9993L3.63574 11.6354L5.04996 10.2212L9.9997 15.1709Z"></path></svg>
                                </div>
                                <div class="right-box">
                                    <p>Today at 10:00 AM - For Stomach Ache</p>
                                   
                                </div>
                            </div>


                             <div class="listBox successbox">
                                <div class="left-box">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M9.9997 15.1709L19.1921 5.97852L20.6063 7.39273L9.9997 17.9993L3.63574 11.6354L5.04996 10.2212L9.9997 15.1709Z"></path></svg>
                                </div>
                                <div class="right-box">
                                    <p>Today at 10:00 AM - For Stomach Ache</p>
                                   
                                </div>
                            </div>
                        </div> --}}
                  </div>
                 @include('healing.layout.bottombar')
               </div>
            </div>
         </div>
      </div>


      @section('scripts')
<script>
let page = 1;
let loading = false;
let allLoaded = false;
let selectedDate = '';

function loadHealingRequests(reset = false) {
    if (loading || allLoaded) return;

    loading = true;
    $('#healingLoader').show();

    if (reset) {
        $('#healingRequestList').empty();
        page = 1;
        allLoaded = false;
        $('#loadedCount').text('0');
    }

    $.ajax({
        url: '/user/healing-requests',
        type: 'GET',
        data: { page: page, date: selectedDate },
        success: function(response) {
            $('#healingLoader').hide();
            loading = false;

            if (reset && response.data.length === 0) {
                $('#healingRequestList').html('<p>No Healing Requests Found.</p>');
                $('#totalCount').text(0);
                $('#loadedCount').text(0);
                return;
            }

            if (response.data.length === 0) {
                allLoaded = true;
                return;
            }

            $('#totalCount').text(response.total);

            response.data.forEach(item => {
                let html = '';
                let dateText = item.formatted_datetime;
                let requirement = item.healing_requirement;

                if (item.status === 'pending') {
                    html += `
                        <div class="listBox">
                            <div class="left-box">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM13 12H17V14H11V7H13V12Z"></path></svg>
                            </div>
                            <div class="right-box">
                                <p>${dateText} - For ${requirement}</p>
                                <div>
                                    <span>Unassigned Yet</span>
                                    <button data-id="${item.id}" class="cancelRequestBtn">Cancel Request</button>
                                </div>
                            </div>
                        </div>`;
                } else if (item.status === 'assigned') {
                    html += `
                        <div class="listBox successbox">
                            <div class="left-box">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M9.9997 15.1709L19.1921 5.97852L20.6063 7.39273L9.9997 17.9993L3.63574 11.6354L5.04996 10.2212L9.9997 15.1709Z"></path></svg>
                            </div>
                            <div class="right-box">
                                <p>${dateText} - For ${requirement}</p>
                            </div>
                        </div>`;
                } else if (item.status === 'cancelled') {
                    html += `
                        <div class="listBox">
                            <div class="left-box">
                               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M11.9997 10.5865L16.9495 5.63672L18.3637 7.05093L13.4139 12.0007L18.3637 16.9504L16.9495 18.3646L11.9997 13.4149L7.04996 18.3646L5.63574 16.9504L10.5855 12.0007L5.63574 7.05093L7.04996 5.63672L11.9997 10.5865Z"></path></svg>
                            </div>
                            <div class="right-box">
                                <p>${dateText} - For ${requirement}</p>
                                <div>
                                    <span style="color: red; font-weight: bold;">Cancelled</span>
                                </div>
                            </div>
                        </div>`;
                }

                $('#healingRequestList').append(html);
            });

            // Update loaded count after appending
            $('#loadedCount').text($('#healingRequestList .listBox, #healingRequestList .successbox').length);

            page++;
        },
        error: function() {
            $('#healingLoader').hide();
            loading = false;
        }
    });
}

$(document).ready(function() {
    // Load on page
    loadHealingRequests();

    // Infinite Scroll
    $(window).scroll(function() {
        if ($(window).scrollTop() + window.innerHeight >= $(document).height() - 100) {
            loadHealingRequests();
        }
    });

    // Search button click
    $('#searchDateBtn').on('click', function() {
        selectedDate = $('#filterDate').val();
        loadHealingRequests(true);
    });

    // Optional: Allow Enter key to trigger search
    $('#filterDate').on('keypress', function(e) {
        if (e.which === 13) {
            $('#searchDateBtn').click();
        }
    });

    // Cancel Request
$(document).on('click', '.cancelRequestBtn', function () {
    const id = $(this).data('id');
    if (confirm('Cancel this healing request?')) {
        $.ajax({
            url: '/user/cancel-healing-request',
            type: 'POST',
            data: {
                id: id,
                _token: $('meta[name="csrf-token"]').attr('content') // Make sure CSRF token exists in your HTML
            },
            success: function (response) {
                if (response.success) {
                    loadHealingRequests(true); // Reload list
                } else {
                    alert(response.message || 'Something went wrong.');
                }
            },
            error: function () {
                alert('Server error. Please try again.');
            }
        });
    }
});
});
</script>
@endsection
@endsection