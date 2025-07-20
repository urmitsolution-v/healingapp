@extends('healing.layout.layout')
@section('content')

<style>
    .listBox{
            margin-bottom: 20px;
    }
    .submitButton{
            display: block;
    width: 100%;
    margin-top: 14px;
    }
    
    .home-main-page {
    min-height: 80vh;
}

#healingList .text-center.text-muted{
    margin-bottom:13px; 
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
                           <div class="header-title">Your Healings for Today</div>
                           <div class="">
                           </div>
                        </div>
                     </div>
{{-- 
                        <div class="yourrequestsBox">
                            <p></p>
                        </div> --}}

                        <div class="myHealingRequests bidsbox">

   <form id="healingForm">
    <div id="healingList"></div>

    <!-- Remarks input wrapped in div for show/hide -->
    <div id="remarksBox" class="mt-2">
        <input type="text" placeholder="Remarks" class="healing-input form-control mt-3" id="remarks" />
    </div>

    <!-- Submit button -->
    <button type="submit" class="submitButton mt-2" id="submitBtn">
        <span id="btnText">Mark as Done</span>
        <i id="btnSpinner" class="fas fa-spinner fa-spin" style="display: none;"></i>
    </button>
</form>

<!-- Loading text -->
<div id="loadingText" class="text-center text-muted mt-2">Loading healing requests...</div>

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
    <p>Today at 10:00 AM - For Stomach Ache</p>
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
    <p>Today at 10:00 AM - For Stomach Ache</p>
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
    <p>Today at 10:00 AM - For Stomach Ache</p>
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
    <p>Today at 10:00 AM - For Stomach Ache</p>
    <div>
    
    </div>
  </div>
</label>
        <input type="text" placeholder="Remarks" class="healing-input form-control" />
        <button class="submitButton">Mark Done</button>
    </div> --}}

                  </div>
                    @include('healing.layout.bottombar')
               </div>
            </div>
         </div>
      </div>


      @section('scripts')

 
<script>
    $(document).ready(function () {
    fetchHealings();

    function fetchHealings() {
        $("#healingList").html('');
        $("#loadingText").show();

        // Hide remarks and button initially
        $("#remarksBox").hide();
        $("#submitBtn").hide();

        $.get("/healer/today-healings", function (data) {
            $("#loadingText").hide();

            if (data.length === 0) {
                $("#healingList").html('<div class="text-center text-muted">No healing assigned for today.</div>');
                return;
            }

            // Show remarks and button only if data exists
            $("#remarksBox").show();
            $("#submitBtn").show();

            data.forEach(function (item) {
                const time = new Date('1970-01-01T' + item.time).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                const box = `
                    <label class="listBox">
                        <div class="left-box">
                            <label class="custom-checkbox">
                                <input type="checkbox" name="selected_requests[]" value="${item.id}" />
                                <span class="custom-checkbox"></span>
                            </label>
                        </div>
                        <div class="right-box">
                            <p>${time} - For ${item.healing_requirement}</p>
                        </div>
                    </label>`;
                $("#healingList").append(box);
            });
        });
    }

    $("#healingForm").on("submit", function (e) {
        e.preventDefault();

        const selected = $("input[name='selected_requests[]']:checked").map(function () {
            return this.value;
        }).get();

        if (selected.length === 0) {
            toastr.warning("Please select at least one healing.");
            return;
        }

        const remarks = $("#remarks").val();

        $("#submitBtn").prop("disabled", true);
        $("#btnText").hide();
        $("#btnSpinner").show();

        $.ajax({
            url: "/healer/mark-done",
            method: "POST",
            data: {
                selected_requests: selected,
                remarks: remarks,
                _token: "{{ csrf_token() }}"
            },
            success: function (res) {
                toastr.success(res.message);
                $("#remarks").val('');
                fetchHealings(); // reload updated list
            },
            error: function () {
                toastr.error("Something went wrong.");
            },
            complete: function () {
                $("#submitBtn").prop("disabled", false);
                $("#btnText").show();
                $("#btnSpinner").hide();
            }
        });
    });
});

</script>

     @endsection
     @endsection