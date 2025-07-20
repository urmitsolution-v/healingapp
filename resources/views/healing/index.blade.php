@extends('healing.layout.layout')

@section('content')

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
                                                <span>6</span>

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
                                                <span>6</span>

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
                     </div>
                  </div>
                  @include('healing.layout.bottombar')
               </div>
            </div>
         </div>
      </div>

  

      
@endsection