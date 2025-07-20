@extends('healing.layout.layout')

@section('content')

    <style>
        .page.page-home {
    padding-bottom: 90px !important;
}
.right-box input{
        margin-top: 10px;
}
.text-center.text-muted.py-4 {
    text-align: center;
}

.home-main-page {
    background: #f3f8ff;
    min-height: 80vh;
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
                           <div class="header-title">View Open Bids</div>
                           <div class="">
                           </div>
                        </div>
                      </div>

                        {{-- <div class="yourrequestsBox">
                            <p>View Open Bids</p>
                        </div> --}}

                       
                       <div class="myHealingRequests bidsbox" id="bidsListBox">
    <!-- Filled dynamically via JS -->
</div>

<div class="myHealingRequests bidsbox">
    <button class="submitButton" id="submitBidsBtn">Raise A Bid</button>
</div>


{{-- <div class="myHealingRequests bidsbox">

                          <label class="listBox">
  <div class="left-box">
    <label class="custom-checkbox">
      <input type="checkbox" name="healing_select" />
      <span class="custom-checkbox"></span>
    </label>
  </div>
  <div class="right-box">
    <p>10:00 AM - For Fever</p>
    <div>
    
    </div>
  </div>
</label>

  <label class="listBox">
  <div class="left-box">
    <label class="custom-checkbox">
      <input type="checkbox" name="healing_select" />
      <span class="custom-checkbox"></span>
    </label>
  </div>
  <div class="right-box">
    <p>10:00 AM - For Fever</p>
    <div>
    
    </div>
  </div>
</label>


     <!-- <input type="text" placeholder="Remarks" class="healing-input form-control" /> -->


  <button class="submitButton">Accept</button>

                        </div> --}}

                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>

                  </div>
                      @include('healing.layout.bottombar')
               </div>
            </div>
         </div>
      </div>


      @section('scripts')

     <script>
   function loadAvailableHealingRequests() {
    $.ajax({
        url: '/healer/available-requests',
        type: 'GET',
        success: function (res) {
            let html = '';

            if (res.data.length > 0) {
                res.data.forEach(req => {
                    html += `
<label class="listBox">
  <div class="left-box">
    <label class="custom-checkbox">
      <input type="checkbox" name="healing_select" value="${req.id}" />
      <span class="custom-checkbox"></span>
    </label>
  </div>
  <div class="right-box">
    <p>${req.formatted_datetime} - For ${req.healing_requirement || 'N/A'}</p>
    <input type="text" class="healing-input form-control" name="remarks_${req.id}" placeholder="Remarks (optional)" />
  </div>
</label>
                    `;
                     $('#submitBidsBtn').show();
                });
            } else {
                html = `
<div class="text-center text-muted py-4">
  <i class="fas fa-inbox fa-2x mb-2"></i><br>
  <strong>No healing requests available for bids.</strong>
</div>
                `;
                $('#submitBidsBtn').hide();
            }

            $('#bidsListBox').html(html);
        },
        error: function () {
            $('#bidsListBox').html(`
                <div class="text-center text-danger py-4">
                    <i class="fas fa-exclamation-triangle fa-2x mb-2"></i><br>
                    <strong>Failed to load healing requests. Please try again.</strong>
                </div>
            `);
            $('#submitBidsBtn').hide(); 
        }
    });

}

loadAvailableHealingRequests();

$('#submitBidsBtn').on('click', function () {
    const selectedRequests = [];

    $('input[name="healing_select"]:checked').each(function () {
        const id = $(this).val();
        const remarks = $(`input[name="remarks_${id}"]`).val();
        selectedRequests.push({ id, remarks });
    });

    if (selectedRequests.length === 0) {
        toastr.warning('Please select at least one request.');
        return;
    }

    // Disable button and show spinner
    const $btn = $(this);
    const originalHtml = $btn.html();
    $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Submitting...');

    $.ajax({
        url: '/healer/place-bid',
        method: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            bids: selectedRequests
        },
        success: function (res) {
            if (res.success) {
                toastr.success('Bid(s) placed successfully!');
                loadAvailableHealingRequests();
            } else {
                toastr.error(res.message || 'Failed to place bids.');
            }
        },
        error: function () {
            toastr.error('Server error. Please try again later.');
        },
        complete: function () {
            // Re-enable button and restore original text
            $btn.prop('disabled', false).html(originalHtml);
        }
    });
});

</script>

     @endsection
     @endsection