<!DOCTYPE html>
<html lang="en">
<head>
  <title>Dashboard Panel with Sidebar and Data Table</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
</head>
<body>

  <!-- Sidebar -->
  <div class="container-fluid">
    <div class="row">
      <nav class="col-md-2 d-none d-md-block bg-light sidebar">
        <div class="sidebar-sticky">
            <!-- Logo-->
            <div>
                <a href="{{url('/home')}}" class="logo">
                    <img src="{{asset('assets/images/logo-light.png')}}" class="logo-lg" alt="" height="57">
                    <img src="{{asset('assets/images/logo-sm.png')}}" class="logo-sm" alt="" height="28">
                </a>
                {{-- config('app.name', 'Laravel') --}}
            </div>
            <!-- End Logo-->
            

        <ul class="nav flex-column">
            <li class="dropdown">
                <a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
                    <span class="profile-username">
                    {{ Auth::user()->name }} <span class="mdi mdi-chevron-down font-15"></span>
                    </span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="javascript:void(0)" class="dropdown-item"> {{ Auth::user()->role }}</a></li>
                    <li>
                        <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                        </a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </ul>
            </li>
            <li class="">
                <a href="{{ url('/dashboard') }}">Dashboard</a>
            </li>
            @if(auth()->check() && (auth()->user()->role !== 'student'))
                <li class="">
                    <a href="{{ url('/users') }}">Users</a>
                </li>
                <li class="">
                    <a href="{{ url('/courses') }}">Courses</a>
                </li>
                <li class="">
                    <a href="{{ url('/quizzes') }}">Quizzes</a>
                </li>
                <li class="">
                    <a href="{{ url('/logged_in_users') }}"><i class="ti-home"></i>
                        {{ auth()->user()->role === 'teacher' ? 'Approvals' : (auth()->user()->role === 'admin' ? 'Reports' : '') }}
                    </a>
                </li>
                <li class="">
                    <a href="{{ url('/logs') }}">Logs</a>
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
                var selectedRole = $('#role').val();
                var courseSelect = $('#course');
                
                if (selectedRole === "teacher") {
                    courseSelect.prop('multiple', true);
                } else {
                    courseSelect.prop('multiple', false);
                }
                // for create case
                $('#role').change(function() {
                    var selectedRole = $(this).val();
                    var courseSelect = $('#course');

                    if (selectedRole === "teacher") {
                        courseSelect.prop('multiple', true);
                    } else {
                        courseSelect.prop('multiple', false);
                    }
                });
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