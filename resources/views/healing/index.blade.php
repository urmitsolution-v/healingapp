@extends('healing.layout.layout')

@section('content')

<style>
   #submitBtn{
      margin-top: 10px;
   }

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

.myHealingRequests {
   width: 100%;
}
</style>

      <div class="main-container">
         <div id="app">
            <div class="view view-main view-init ios-edges">
               <div class="page page-home page-with-subnavbar home-main-page">
                  <div class="tabs">
                     <div id="tab-home" class="tab tab-active tab-home">
                        <!-- home -->
                         @include('healing.layout.topbar')

  <div class="services-section doctors-box px-15 pt-0">
                                 <div class="special-main pt-0-important">
                                    <div class="special-box">
                                       <div class="special-text-box">
                                          <div class="roboto-img">
                                             <div class="box_round_firm">
                                                <span>6</span>

                                                </div>
                                          </div>
                                          <div class="roboto-text">
                                             <span><a href="javascript:void(0)">Response</a></span>
                                            
                                          </div>
                                       </div>
                                    </div>
                                      <div class="special-box">
                                       <div class="special-text-box">
                                          <div class="roboto-img">
                                             <div class="box_round_firm">
                                                <span> {{ $wallet->credit ?? 0 }}</span>

                                                </div>
                                          </div>
                                          <div class="roboto-text">
                                             <span><a href="javascript:void(0)">Healing Cr</a></span>
                                          </div>
                                       </div>
                                    </div>

                                        <div class="special-box">
                                       <div class="special-text-box">
                                          <div class="roboto-img">
                                             <div class="box_round_firm">
                                                <span>{{ $wallet->debit ?? 0 }}</span>

                                                </div>
                                          </div>
                                          <div class="roboto-text">
                                             <span><a href="javascript:void(0)">Healing Dr</a></span>
                                            
                                          </div>
                                       </div>
                                    </div>

                                        <div class="special-box">
                                       <div class="special-text-box">
                                          <div class="roboto-img">
                                             <div class="box_round_firm">
                                                <span>{{ ($wallet->credit ?? 0) - ($wallet->debit ?? 0) }}</span>

                                                </div>
                                          </div>
                                          <div class="roboto-text">
                                             <span><a href="javascript:void(0)">Balance</a></span>
                                            
                                          </div>
                                       </div>
                                    </div>


                                 </div>
                              </div>


                              <div class="services-section doctors-box px-15 pt-0">
                              

                                 <div class="medicine-cart lab-test-lists p-0-x">
                              <div class="medicine-product">
                                 <div class="medicine-right medicine-right-updated">
                                   
                                    <div class="select-button bidds_button">
                                        <a href="/view-open-bids">View Open Bids <span class="bidscount">{{ $totalRequests ?? 0 }}</span> </a>
                                       <a href="/assigned-healings">Your Healings Today</a>
                                       <a href="/healing-requests">Your Request For Healing</a>
                                       <a href="/reports">Reports</a>
                                    </div>
                                 </div>
                              </div>
                           </div>

                           <div class="todayHealth medicine-product">
                                    <div class="myHealingRequests bidsbox">

                                       <h5><b>Your Healings Today</b></h5>

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
                           </div>

                     </div>
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