  <nav id="sidebar" class="sidebar-wrapper">
          <div class="sidebar-profile">
            {{-- <img src="{{ url('newadmin') }}/assets/images/user6.png" class="img-shadow img-3x me-3 rounded-5" alt="Hospital Admin Templates"> --}}
            <div class="m-0">
              <h5 class="mb-1 profile-name text-nowrap text-truncate">{{ Auth::user()->name ?? "" }}</h5>
              <p class="m-0 small profile-name text-nowrap text-truncate">Admin</p>
            </div>
          </div>
          <div class="sidebarMenuScroll">
            <ul class="sidebar-menu">
              <li class="active current-page">
                <a href="/dashboard">
                  <i class="ri-home-6-line"></i>
                  <span class="menu-text">Dashboard</span>
                </a>
              </li>
           <li class="treeview {{ request()->is('admin/users-list') ? 'active menu-open' : '' }}">
    <a href="#!">
        <i class="ri-nurse-line"></i>
        <span class="menu-text">Members</span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ request()->get('type') == 'pending' ? 'active' : '' }}">
            <a href="/admin/users-list?type=pending">Pending Members</a>
        </li>
        <li class="{{ request()->get('type') == 'approved' ? 'active' : '' }}">
            <a href="/admin/users-list?type=approved">Approved Members</a>
        </li>
        <li class="{{ request()->get('type') == 'rejected' ? 'active' : '' }}">
            <a href="/admin/users-list?type=rejected">Rejected Members</a>
        </li>
    </ul>
</li>

           <li class="treeview {{ request()->is('admin/healing-request') ? 'active menu-open' : '' }}">
    <a href="#!">
        <i class="ri-dossier-line"></i>
        <span class="menu-text">Healing Requests</span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ request()->get('type') == 'today' ? 'active' : '' }}">
            <a href="/admin/healing-request?type=today">Today Healings</a>
        </li>
        <li class="{{ request()->get('type') == 'pending' ? 'active' : '' }}">
            <a href="/admin/healing-request?type=pending">Pending Requests</a>
        </li>
        <li class="{{ request()->get('type') == 'assigned' ? 'active' : '' }}">
            <a href="/admin/healing-request?type=assigned">Assigned Requests</a>
        </li>
        <li class="{{ request()->get('type') == 'cancelled' ? 'active' : '' }}">
            <a href="/admin/healing-request?type=cancelled">Cancelled Requests</a>
        </li>
    </ul>
</li>

              <li class="treeview">
                <a href="#!">
                  <i class="ri-building-2-line"></i>
                  <span class="menu-text">Reports</span>
                </a>
              
              </li>
      
            </ul>
          </div>
     <div class="sidebar-contact">
            <p class="fw-light mb-1 text-nowrap text-truncate">Emergency Contact</p>
            <h5 class="m-0 lh-1 text-nowrap text-truncate">+91 7357791943</h5>
            <i class="ri-phone-line"></i>
          </div>
</nav>