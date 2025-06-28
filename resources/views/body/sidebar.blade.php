		<!-- partial:partials/_sidebar.html -->
		<nav class="sidebar">
            <div class="sidebar-header">
              <a href="#" class="sidebar-brand">
                Room<span>Pro</span>
              </a>
              <div class="sidebar-toggler not-active">
                <span></span>
                <span></span>
                <span></span>
              </div>
            </div>
            <div class="sidebar-body">
              <ul class="nav">
                {{-- <li class="nav-item nav-category">Main</li> --}}
                <li class="nav-item">
                  <a href="{{route('dashboard')}}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                  </a>
                </li>

                @php
                    $user = auth()->user();
                    $route = ($user->usertype === 'superadmin' || $user->usertype === 'staff') 
                      ? route('indexapplication') 
                      : route('mainresidentapplication');
                @endphp

                @can('read_application')
                <li class="nav-item">
                    <a href="{{ $route }}" class="nav-link">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">Application</span>
                    </a>
                </li>
                @endcan

                @can('read_complaint')
                <li class="nav-item">
                  <a href="{{route('indexcomplaint')}}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Complaint</span>
                  </a>
                </li>
                @endcan

                {{-- @can('read_user') --}}
                @if(auth()->user() && auth()->user()->usertype === 'superadmin')
                <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="collapse" href="#users" role="button"
                      aria-expanded="false" aria-controls="users">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">User</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                  </a>
                  <div class="collapse {{ request()->routeIs('adminroles.*') ? 'show' : '' }}" id="users">
                    <ul class="nav sub-menu">
                      <li class="nav-item">
                        <a href="{{ route('mainuser') }}" class="nav-link">User</a>
                      </li>
                      <li class="nav-item">
                        {{-- <a href="{{ route('adminroles.index') }}" class="nav-link {{request()->routeIs('admin/roles*') ? 'active' : ''}}">User Access</a> --}}
                        <a href="{{ route('adminroles.index') }}" class="nav-link {{ request()->routeIs('adminroles.*') ? 'active' : '' }}">User Access</a>
                      </li>
                    </ul>
                  </div>
                </li>
                @endif
                {{-- @endcan --}}
                
                @can('read_room')
                <li class="nav-item">
                  <a href="{{route('mainroom')}}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Room</span>
                  </a>
                </li>
                @endcan
                  
                @php
                  $resident = auth()->user();
                  $resident_route = (isset($resident) && ($resident->usertype === 'superadmin' || $resident->usertype === 'staff'))
                      ? route('indexresident')
                      : route('mainresidentresident');
                @endphp


                @can('read_resident')
                <li class="nav-item">
                    <a href="{{ $resident_route }}" class="nav-link">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">Resident</span>
                    </a>
                </li>
                @endcan

                @can('read_announcement')
                <li class="nav-item">
                  <a href="{{route('mainannouncement')}}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Announcement</span>
                  </a>
                </li>
                @endcan
                
                @can('read_visitation')
                <li class="nav-item">
                  <a href="{{ route('mainvisitation')}}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Visitation</span>
                  </a>
                </li>
                @endcan

                @can('read_user')
                <li class="nav-item">
                  <a href="{{ route('mainsemester')}}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Semester</span>
                  </a>
                </li>
                @endcan
            
                @can('read_facility')
                <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="collapse" href="#facilities" role="button"
                      aria-expanded="false" aria-controls="facilities">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Facility</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                  </a>
                  <div class="collapse" id="facilities">
                    <ul class="nav sub-menu">
                      <li class="nav-item">
                        <a href="{{ route('mainfacility') }}" class="nav-link">Facility</a>
                      </li>
                      @can('read_facility_type')
                      <li class="nav-item">
                        <a href="{{ route('mainfacilitytype') }}" class="nav-link">Facility Type</a>
                      </li>
                      @endcan
                    </ul>
                  </div>
                </li>
                @endcan
            </div>
          </nav>

{{-- <script>
              $(document).ready(function() {
                let currentUrl = window.location.href;
                
                $('.sub-menu .nav-link').each(function() {
                  if (this.href === currentUrl) {
                    $(this).addClass('active');
                    $(this).closest('.collapse').addClass('show');
                    $(this).closest('.collapse').prev('.nav-link').attr('aria-expanded', 'true');
                  }
                });
              });
</script> --}}

<script>
  $(document).ready(function() {
      let currentPath = window.location.pathname;
      
      $('.nav-link').each(function() {
          if (this.pathname === currentPath) {
              $(this).addClass('active');
              let parentCollapse = $(this).closest('.collapse');
              if (parentCollapse.length) {
                  parentCollapse.addClass('show');
                  parentCollapse.prev('.nav-link').attr('aria-expanded', 'true');
              }
          }
      });
  });
  </script>
  