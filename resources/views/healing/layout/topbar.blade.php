   <div class="home-top-bar">
                           {{-- <div class="bell-icon"><span class="bell"></span></div> --}}
                           <div class="home-top-text">
                              {{-- <span>Hi, Lucy Martin</span> --}}
                              <strong>Welcome {{ Auth::user()->name ?? "Guest" }}</strong>
                              <div>Healing Bank A/C {{ Auth::user()->user_code ?? "N/A" }}</div>
                           </div>
                        </div>
