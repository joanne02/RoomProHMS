<style>
.notification-badge {
    position: absolute;
    top: 4px;     /* adjust for bell icon alignment */
    right: 6px;
    background-color: #dc3545;
    color: white;
    font-size: 10px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    line-height: 1;
    z-index: 1;
}

.object-fit-cover {
    object-fit: cover;
}

</style>
<nav class="navbar">
  @php
      $user = auth()->user();
  @endphp
    <a href="#" class="sidebar-toggler">
        <i data-feather="menu"></i>
    </a>
    <div class="navbar-content">
        {{-- <form class="search-form"> --}}
            {{-- <div class="input-group">
                <div class="input-group-text">
                  <i data-feather="search"></i>
                </div>
                <input type="text" class="form-control" id="navbarForm" placeholder="Search here...">
            </div> --}}
            
            <div class="d-flex align-items-center">
              <h4 class="mb-0 text-capitalize">{{ $pageTitle ?? 'Dashboard' }}</h4>
          </div>



        {{-- </form> --}}
        <ul class="navbar-nav">
            {{-- <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="flag-icon flag-icon-us mt-1" title="us"></i> <span class="ms-1 me-1 d-none d-md-inline-block">English</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="languageDropdown">
                <a href="javascript:;" class="dropdown-item py-2"><i class="flag-icon flag-icon-us" title="us" id="us"></i> <span class="ms-1"> English </span></a>
                <a href="javascript:;" class="dropdown-item py-2"><i class="flag-icon flag-icon-fr" title="fr" id="fr"></i> <span class="ms-1"> French </span></a>
                <a href="javascript:;" class="dropdown-item py-2"><i class="flag-icon flag-icon-de" title="de" id="de"></i> <span class="ms-1"> German </span></a>
                <a href="javascript:;" class="dropdown-item py-2"><i class="flag-icon flag-icon-pt" title="pt" id="pt"></i> <span class="ms-1"> Portuguese </span></a>
                <a href="javascript:;" class="dropdown-item py-2"><i class="flag-icon flag-icon-es" title="es" id="es"></i> <span class="ms-1"> Spanish </span></a>
                </div>
           </li> --}}
            {{-- <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="appsDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="grid"></i>
                </a>
                <div class="dropdown-menu p-0" aria-labelledby="appsDropdown">
    <div class="px-3 py-2 d-flex align-items-center justify-content-between border-bottom">
                        <p class="mb-0 fw-bold">Web Apps</p>
                        <a href="javascript:;" class="text-muted">Edit</a>
                    </div>
    <div class="row g-0 p-1">
      <div class="col-3 text-center">
        <a href="pages/apps/chat.html" class="dropdown-item d-flex flex-column align-items-center justify-content-center wd-70 ht-70"><i data-feather="message-square" class="icon-lg mb-1"></i><p class="tx-12">Chat</p></a>
      </div>
      <div class="col-3 text-center">
        <a href="pages/apps/calendar.html" class="dropdown-item d-flex flex-column align-items-center justify-content-center wd-70 ht-70"><i data-feather="calendar" class="icon-lg mb-1"></i><p class="tx-12">Calendar</p></a>
      </div>
      <div class="col-3 text-center">
        <a href="pages/email/inbox.html" class="dropdown-item d-flex flex-column align-items-center justify-content-center wd-70 ht-70"><i data-feather="mail" class="icon-lg mb-1"></i><p class="tx-12">Email</p></a>
      </div>
      <div class="col-3 text-center">
        <a href="pages/general/profile.html" class="dropdown-item d-flex flex-column align-items-center justify-content-center wd-70 ht-70"><i data-feather="instagram" class="icon-lg mb-1"></i><p class="tx-12">Profile</p></a>
      </div>
      <div class="col-3 text-center">
        <a href="pages/general/profile.html" class="dropdown-item d-flex flex-column align-items-center justify-content-center wd-70 ht-70">
            <img src="{{ $user->image ? asset('storage/' . $user->image) : 'https://via.placeholder.com/100x0' }}"
                alt="Profile Image"
                class="rounded-circle mb-1"
                width="100" height="100">
            <p class="tx-12">Profile</p>
        </a>
      </div>

    </div>
                    <div class="px-3 py-2 d-flex align-items-center justify-content-center border-top">
                        <a href="javascript:;">View all</a>
                    </div>
                </div>
            </li> --}}
            {{-- <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="mail"></i>
                </a>
                <div class="dropdown-menu p-0" aria-labelledby="messageDropdown">
                    <div class="px-3 py-2 d-flex align-items-center justify-content-between border-bottom">
                        <p>9 New Messages</p>
                        <a href="javascript:;" class="text-muted">Clear all</a>
                    </div>
    <div class="p-1">
      <a href="javascript:;" class="dropdown-item d-flex align-items-center py-2">
        <div class="me-3">
          <img class="wd-30 ht-30 rounded-circle" src="https://via.placeholder.com/30x30" alt="userr">
        </div>
        <div class="d-flex justify-content-between flex-grow-1">
          <div class="me-4">
            <p>Leonardo Payne</p>
            <p class="tx-12 text-muted">Project status</p>
          </div>
          <p class="tx-12 text-muted">2 min ago</p>
        </div>	
      </a>
      <a href="javascript:;" class="dropdown-item d-flex align-items-center py-2">
        <div class="me-3">
          <img class="wd-30 ht-30 rounded-circle" src="https://via.placeholder.com/30x30" alt="userr">
        </div>
        <div class="d-flex justify-content-between flex-grow-1">
          <div class="me-4">
            <p>Carl Henson</p>
            <p class="tx-12 text-muted">Client meeting</p>
          </div>
          <p class="tx-12 text-muted">30 min ago</p>
        </div>	
      </a>
      <a href="javascript:;" class="dropdown-item d-flex align-items-center py-2">
        <div class="me-3">
          <img class="wd-30 ht-30 rounded-circle" src="https://via.placeholder.com/30x30" alt="userr">
        </div>
        <div class="d-flex justify-content-between flex-grow-1">
          <div class="me-4">
            <p>Jensen Combs</p>
            <p class="tx-12 text-muted">Project updates</p>
          </div>
          <p class="tx-12 text-muted">1 hrs ago</p>
        </div>	
      </a>
      <a href="javascript:;" class="dropdown-item d-flex align-items-center py-2">
        <div class="me-3">
          <img class="wd-30 ht-30 rounded-circle" src="https://via.placeholder.com/30x30" alt="userr">
        </div>
        <div class="d-flex justify-content-between flex-grow-1">
          <div class="me-4">
            <p>Amiah Burton</p>
            <p class="tx-12 text-muted">Project deatline</p>
          </div>
          <p class="tx-12 text-muted">2 hrs ago</p>
        </div>	
      </a>
      <a href="javascript:;" class="dropdown-item d-flex align-items-center py-2">
        <div class="me-3">
          <img class="wd-30 ht-30 rounded-circle" src="https://via.placeholder.com/30x30" alt="userr">
        </div>
        <div class="d-flex justify-content-between flex-grow-1">
          <div class="me-4">
            <p>Yaretzi Mayo</p>
            <p class="tx-12 text-muted">New record</p>
          </div>
          <p class="tx-12 text-muted">5 hrs ago</p>
        </div>	
      </a>
    </div>
                    <div class="px-3 py-2 d-flex align-items-center justify-content-center border-top">
                        <a href="javascript:;">View all</a>
                    </div>
                </div>
            </li> --}}

            @php
              $daysLimit = 7; // Number of days to consider
              $maxNotifications = 10;

              $notifications = auth()->user()
                  ->notifications() // includes both read and unread
                  ->where('created_at', '>=', now()->subDays($daysLimit))
                  ->latest()
                  ->take($maxNotifications)
                  ->get();

              $notificationCount = auth()->user()->unreadNotifications->count();
          @endphp

          <li class="nav-item dropdown">
            {{-- <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button"
              data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i data-feather="bell"></i>
                <div class="indicator">
                    <div class="circle"></div>
                    <span class="badge bg-danger">{{ $notificationCount }}</span>
                </div>
            </a> --}}
            <a class="nav-link dropdown-toggle position-relative" href="#" id="notificationDropdown" role="button"
              data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i data-feather="bell"></i>
                <span class="notification-badge">{{ $notificationCount }}</span>
            </a>

            <div class="dropdown-menu p-0" aria-labelledby="notificationDropdown">
                <div class="px-3 py-2 d-flex align-items-center justify-content-between border-bottom">
                    <p>{{ $notificationCount }} New Notifications</p>
                    <a href="{{ route('notifications.clear') }}" class="text-muted">Clear all</a>
                </div>

                @if($notifications->count())
                    @foreach($notifications as $notification)
                        <a href="{{ route('notifications.read', $notification->id) }}"
                          class="dropdown-item d-flex px-3 py-2 {{ is_null($notification->read_at) ? 'bg-light' : '' }}">
                            <div class="me-3">
                                <i data-feather="alert-circle" class="text-primary"></i>
                            </div>
                            <div>
                                <p class="mb-0 small">{{ $notification->data['message'] ?? 'New Notification' }}</p>
                                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                            </div>
                        </a>
                    @endforeach
                @else
                    <div class="px-3 py-2 text-center text-muted">
                        No recent notifications
                    </div>
                @endif
            </div>
          </li>

                    {{-- <div class="p-1">
                      <a href="javascript:;" class="dropdown-item d-flex align-items-center py-2">
                        <div class="wd-30 ht-30 d-flex align-items-center justify-content-center bg-primary rounded-circle me-3">
                                                <i class="icon-sm text-white" data-feather="gift"></i>
                        </div>
                        <div class="flex-grow-1 me-2">
                                                <p>New Order Recieved</p>
                                                <p class="tx-12 text-muted">30 min ago</p>
                        </div>	
                      </a>
                      <a href="javascript:;" class="dropdown-item d-flex align-items-center py-2">
                        <div class="wd-30 ht-30 d-flex align-items-center justify-content-center bg-primary rounded-circle me-3">
                                                <i class="icon-sm text-white" data-feather="alert-circle"></i>
                        </div>
                        <div class="flex-grow-1 me-2">
                                                <p>Server Limit Reached!</p>
                                                <p class="tx-12 text-muted">1 hrs ago</p>
                        </div>	
                      </a>
                      <a href="javascript:;" class="dropdown-item d-flex align-items-center py-2">
                        <div class="wd-30 ht-30 d-flex align-items-center justify-content-center bg-primary rounded-circle me-3">
                          <img class="wd-30 ht-30 rounded-circle" src="https://via.placeholder.com/30x30" alt="userr">
                        </div>
                        <div class="flex-grow-1 me-2">
                                                <p>New customer registered</p>
                                                <p class="tx-12 text-muted">2 sec ago</p>
                        </div>	
                      </a>
                      <a href="javascript:;" class="dropdown-item d-flex align-items-center py-2">
                        <div class="wd-30 ht-30 d-flex align-items-center justify-content-center bg-primary rounded-circle me-3">
                                                <i class="icon-sm text-white" data-feather="layers"></i>
                        </div>
                        <div class="flex-grow-1 me-2">
                                                <p>Apps are ready for update</p>
                                                <p class="tx-12 text-muted">5 hrs ago</p>
                        </div>	
                      </a>
                      <a href="javascript:;" class="dropdown-item d-flex align-items-center py-2">
                        <div class="wd-30 ht-30 d-flex align-items-center justify-content-center bg-primary rounded-circle me-3">
                                                <i class="icon-sm text-white" data-feather="download"></i>
                        </div>
                        <div class="flex-grow-1 me-2">
                                                <p>Download completed</p>
                                                <p class="tx-12 text-muted">6 hrs ago</p>
                        </div>	
                      </a>
                    </div>
                    <div class="px-3 py-2 d-flex align-items-center justify-content-center border-top">
                        <a href="javascript:;">View all</a>
                    </div> --}}
                
            <li class="nav-item dropdown">
                {{-- <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="wd-30 ht-30 rounded-circle" src="https://via.placeholder.com/30x30" alt="profile">
                </a> --}}
                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('storage/images/Default_pfp.jpg') }}"
                    alt=""
                    class="wd-30 ht-30 rounded-circle object-fit-cover">


                    {{-- <p class="tx-12">Profile</p> --}}
                
                <span class="ms-2 d-none d-md-inline">{{$user->username}}</span>
              </a>

                <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                    <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                        @php
                            $user = auth()->user();
                        @endphp
                        <div class="mb-3">
                          <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('storage/images/Default_pfp.jpg') }}"
                           alt="Profile Image" class="rounded-circle me-2" width="100" height="90">
                            {{-- <img class="wd-80 ht-80 rounded-circle" src="https://via.placeholder.com/80x80" alt=""> --}}
                        </div>
                        <div class="text-center">
                            <p class="tx-16 fw-bolder">{{$user->username}}</p>
                            <p class="tx-12 text-muted">{{$user->email}}</p>
                        </div>
                    </div>
    <ul class="list-unstyled p-1">
      <li class="dropdown-item py-2">
        <a href="{{route('profile.view')}}" class="text-body ms-0">
          <i class="me-2 icon-md" data-feather="user"></i>
          <span>Profile</span>
        </a>
      </li>
      <li class="dropdown-item py-2">
        <a href="{{route('profile.edit')}}" class="text-body ms-0">
          <i class="me-2 icon-md" data-feather="edit"></i>
          <span>Edit Profile</span>
        </a>
      </li>
      <li class="dropdown-item py-2">
        <a href="{{route('changepasswordedit')}}" class="text-body ms-0">
          <i class="me-2 icon-md" data-feather="repeat"></i>
          <span>Change Password</span>
        </a>
      </li>
      <li class="dropdown-item py-2">
        <a href="{{route('logout')}}" class="text-body ms-0">
          <i class="me-2 icon-md" data-feather="log-out"></i>
          <span>Log Out</span>
        </a>
      </li>
    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>