
    <!-- Sidebar -->
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse " style="background-color: aqua">
      <div class="position-sticky">
        <div class="list-group list-group-flush mx-3 " style="margin-top: -77px;">
            {{-- <a href="#" class="list-group-item list-group-item-action py-2 ripple">
                <img src="{{ asset('img/logo_dark.png') }}" class="navbar-logo pt-3" alt="logo"
                style="height: 75px;width:240px;margin-left: -36px;margin-top: -91px;">
              </a> --}}
          {{-- <a
            href="#"
            class="list-group-item list-group-item-action py-2 ripple"
            aria-current="true"
          >
           --}}
           <img src="{{ asset('img/logo_dark.png') }}" class="navbar-logo pt-3" alt="logo"
           style="height: 75px;width:240px;margin-left: -36px;margin-top: -80px;">
            <h5 class="py-2 ripple  list-group-item bg-success mt-5">Dashboards</h5>
          </a>
          {{-- <a href="#" class="list-group-item list-group-item-action py-2 ripple ">
            <i class="fas fa-chart-area fa-fw me-3"></i><span>Webiste traffic</span>
          </a> --}}
          <a href="{{ route('role.index') }}" class="list-group-item list-group-item-action py-2 ripple {{ request()->routeIs('role.*') ? 'active' : '' }}"
            ><i class="fa-brands fa-critical-role"></i><span>Roles</span></a
          >

          <a href="{{ route('permission.index') }}" class="list-group-item list-group-item-action py-2 ripple {{ request()->routeIs('permission.*') ? 'active' : '' }}"
            ><i class="fas fa-chart-line fa-fw me-3"></i><span>Permission</span></a
          >
          <h5 class="py-2 ripple  list-group-item bg-success">Users</h5>
          <a href="{{ route('admin.index') }}" class="list-group-item list-group-item-action py-2 ripple {{ request()->routeIs('admin.*') ? 'active' : '' }} ">
            <i class="fas fa-chart-pie fa-fw me-3"></i><span>Admin User</span>
          </a>
          <a href="{{ route('employee.index') }}" class="list-group-item list-group-item-action py-2 ripple menu  {{ request()->routeIs('employee.*') ? 'active' : '' }}"
            ><i class="fas fa-chart-bar fa-fw me-3"></i><span>Employee User</span></a
          >
          <a href="{{ route('customer.index') }}" class="list-group-item list-group-item-action py-2 ripple {{ request()->routeIs('customer.*') ? 'active' : '' }} "
            ><i class="fa-brands fa-critical-role"></i><span>Customer User</span></a
          >

          <a href="{{ route('move-customer') }}" class="list-group-item list-group-item-action py-2 ripple {{ request()->routeIs('move-customer') ? 'active' : '' }} "
            ><i class="fa-brands fa-critical-role"></i><span>Move Customers</span></a
          >

          <h5 class="py-2 ripple  list-group-item bg-success">Employee Task</h5>
          <a href="#" class="list-group-item list-group-item-action py-2 ripple"
            ><i class="fa-brands fa-critical-role"></i><span>My Task</span></a
          >
          <a href="{{ route('all-tasks') }}" class="list-group-item list-group-item-action py-2 ripple {{ request()->routeIs('all-tasks') ? 'active' : '' }} "
            ><i class="fa-brands fa-critical-role"></i><span>All Assigned Task</span></a
          >
          <a href="{{ route('tasks.index') }}" class="list-group-item list-group-item-action py-2 ripple"
            ><i class="fa-brands fa-critical-role"></i><span>Manage Task</span></a
          >
          <a href="{{ route('assign-tasks') }}" class="list-group-item list-group-item-action py-2 ripple menu  {{ request()->routeIs('assign-tasks') ? 'active' : '' }}"
            ><i class="fa-brands fa-critical-role"></i><span>Assign Task</span></a
          >
		  <h5 class="py-2 ripple  list-group-item bg-success">Manage Category</h5>
          <a href="{{ route('category.index') }}" class="list-group-item list-group-item-action py-2 ripple"
            ><i class="fa-brands fa-critical-role"></i><span>Category</span></a
          >
		  <h5 class="py-2 ripple  list-group-item bg-success"> Manage Packages</h5>
          <a href="{{ route('package.index') }}" class="list-group-item list-group-item-action py-2 ripple"
            ><i class="fa-brands fa-critical-role"></i><span>Packages</span></a
          >
        </div>
      </div>
    </nav>



