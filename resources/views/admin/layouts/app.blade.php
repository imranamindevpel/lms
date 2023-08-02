{{-- 
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
  <div class="w3-container w3-row">
    <div class="w3-col s4">
      <img src="/w3images/avatar2.png" class="w3-circle w3-margin-right" style="width:46px">
    </div>
    <div class="w3-col s8 w3-bar">
      <span>Welcome, <strong>Mike</strong></span><br>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-envelope"></i></a>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-user"></i></a>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-cog"></i></a>
    </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Dashboard</h5>
  </div>
  <div class="w3-bar-block">
    <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Close Menu</a>
    <a href="#" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fa fa-users fa-fw"></i>  Overview</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-eye fa-fw"></i>  Views</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-users fa-fw"></i>  Traffic</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-bullseye fa-fw"></i>  Geo</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-diamond fa-fw"></i>  Orders</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-bell fa-fw"></i>  News</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-bank fa-fw"></i>  General</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-history fa-fw"></i>  History</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-cog fa-fw"></i>  Settings</a><br><br>
  </div>
</nav> --}}


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Dashboard Panel with Sidebar and Data Table</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
  <!-- Add Font Awesome CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body>

  <!-- Sidebar -->
  <div class="container-fluid">
    <div class="row">
    <nav class="col-md-2 d-none d-md-block bg-light sidebar">
        <div class="sidebar-sticky">
            <!-- Logo -->
            <div class="text-center py-3">
                <a href="{{url('/home')}}" class="logo">
                    <img src="{{asset('assets/images/logo-light.png')}}" class="logo-lg" alt="" height="57">
                    <img src="{{asset('assets/images/logo-sm.png')}}" class="logo-sm" alt="" height="28">
                </a>
                {{-- config('app.name', 'Laravel') --}}
            </div>
            <!-- End Logo -->

            <ul class="nav flex-column">
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
                        <span class="profile-username">
                            {{ Auth::user()->name }} <span class="mdi mdi-chevron-down font-15"></span>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="javascript:void(0)" class="dropdown-item"> {{ Auth::user()->role }}</a></li>
                        <li>
                            <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </ul>
                </li>
                @php
               $user = auth()->user();
               $courses = $user->courses;
                if ($user && $user->role === 'admin') {
                    $courses = \App\Models\Course::all(); // Replace '\App\Models\Course' with the actual namespace of your Course model
                }
                @endphp
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="lecturesDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Lectures
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="lecturesDropdown">
                        @foreach($courses as $course)
                        @if($course->name)
                        <li>
                            <a href="{{ route('lectures.folder_id', ['id' => $course->name]) }}">
                                {{ $course->name }}
                            </a>
                        </li>
                        @endif
                        @endforeach
                    </ul>
                </li>
                @if(auth()->check() && (auth()->user()->role !== 'student'))
                    <li class="nav-item">
                        <a href="{{ url('/users') }}" class="nav-link">Users</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/courses') }}" class="nav-link">Courses</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/quizzes') }}" class="nav-link">Quizzes</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/logged_in_users') }}" class="nav-link">
                            <i class="ti-home"></i>
                            {{ auth()->user()->role === 'teacher' ? 'Approvals' : (auth()->user()->role === 'admin' ? 'Reports' : '') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/logs') }}" class="nav-link">Logs</a>
                    </li>
                @endif
            </ul>
        </div>
    </nav>


      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
        <div class="wrapper">
          <div class="container-fluid">
              @yield('content')
              <!-- end container-fluid -->
          </div>
        </div>
      </main>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <style> .dropdown-div { display: none; } </style>
        <!-- jQuery  -->
        <script src="{{asset('assets/js/jquery.min.js')}}"></script>
         <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
        <script>
            $(document).ready(function() {
                // for user email
                $('#email').on('input', function() {
                    var inputValue = $(this).val();
                    var filteredValue = inputValue.replace(/@/g, '');
                    $(this).val(filteredValue);
                });
                // for edit case
                // var selectedRole = $('#role').val();
                // var courseSelect = $('#course');
                
                // if (selectedRole === "teacher") {
                //     courseSelect.prop('multiple', true);
                // } else {
                //     courseSelect.prop('multiple', false);
                // }
                // // for create case
                // $('#role').change(function() {
                //     var selectedRole = $(this).val();
                //     var courseSelect = $('#course');

                //     if (selectedRole === "teacher") {
                //         courseSelect.prop('multiple', true);
                //     } else {
                //         courseSelect.prop('multiple', false);
                //     }
                // });
                // for getting course users
                $('.courseDropdown').change(function () {
                    var courseId = $(this).val();
                    if (courseId !== '') {
                        $.ajax({
                            url: "{{route('get_course_users')}}",
                            type: 'POST',
                            dataType: 'json',
                            data: {
                            id: courseId,
                            _token: "{{csrf_token()}}"
                            },
                            success: function (response) {
                                var userDropdown = $('#userDropdown');
                                userDropdown.empty();

                                if (response.length > 0) {
                                    userDropdown.append('<option value="">Select User</option>');

                                    $.each(response, function (index, user) {
                                        userDropdown.append('<option value="' + user.id + '">' + user.name + '</option>');
                                    });

                                    userDropdown.removeClass('hidden');
                                } else {
                                    userDropdown.addClass('hidden');
                                }
                            }
                        });
                    } else {
                        $('#userDropdown').addClass('hidden');
                    }
                });
            });
        </script>
</body>
</html>
<style>
/* Add hover effect to the sidebar items */
.nav-sidebar li.nav-item:hover {
    background-color: #f8f9fa; /* Change the background color on hover */
}

/* Add hover effect to the dropdown items */
.nav-sidebar li.nav-item.dropdown:hover .dropdown-menu {
    display: block;
    margin: 0;
    opacity: 1;
    visibility: visible;
}
</style>