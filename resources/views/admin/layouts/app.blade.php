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

  <style>
    body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    color: #333;
    background-color: #b5b5b5;
    margin: 0;
    padding: 0;
    }
  .modal-content{
    background-color: #5a5f85;
    }
  .card {
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border-radius: 4px;
    background-color: #5a5f85;
    color: white;
  }
    /* Custom styles for the sidebar */
    .sidebar {
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      z-index: 100; /* Ensures it stays on top of other elements */
      padding: 20px;
      background-color: #343a40; /* Sidebar background color */
      color: #fff;
    }

    .sidebar-sticky {
      padding-top: 20px;
    }

    .nav-item {
      margin-bottom: 10px; /* Space between menu items */
    }

    .nav-item a {
      color: #fff;
      text-decoration: none;
      padding: 10px;
      display: block;
    }

    .nav-item a:hover {
      background-color: #5e656c; /* Hover background color */
      color: #fff;
    }

    .nav-item.dropdown ul.dropdown-menu {
      background-color: #454d55; /* Submenu background color */
    }

    .nav-item.dropdown ul.dropdown-menu li a {
      color: #fff;
    }

    .nav-item.dropdown ul.dropdown-menu li a:hover {
      background-color: #5e656c; /* Submenu hover background color */
      color: #fff;
    }

    /* Custom styles for the main content area */
    .main-content {
      margin-left: 240px; /* Sidebar width */
    }

    /* Additional styles for the page content */
    .page-content {
      padding: 20px;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <nav class="col-md-2 d-none d-md-block sidebar">
    <div class="sidebar-sticky">
      <!-- Logo -->
      <div class="text-center py-3">
        <a href="{{url('/home')}}" class="logo">
          <img src="{{asset('assets/images/logo-light.png')}}" class="logo-lg" alt="" height="57">
        </a>
      </div>
      <!-- End Logo -->

      <ul class="nav flex-column">
        <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
            <span class="profile-username">
              {{ Auth::user()->name }} <i class="fa fa-chevron-down font-15"></i>
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
        @if(auth()->check() && (auth()->user()->role !== 'student'))
          <li class="nav-item">
            <a href="{{ url('/users') }}" class="nav-link">
              <i class="fa fa-users"></i> Users
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('/courses') }}" class="nav-link">
              <i class="fa fa-book"></i> Courses
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('/quizzes') }}" class="nav-link">
              <i class="fa fa-question"></i> Quizzes
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('/logged_in_users') }}" class="nav-link">
              <i class="fa fa-home"></i> Reports
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('/logs') }}" class="nav-link">
              <i class="fa fa-file-alt"></i> Logs
            </a>
          </li>
        @endif
        <li class="nav-item">
          <a href="{{ url('/lectures') }}" class="nav-link">
            <i class="fa fa-book"></i> Lectures
          </a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Main Content -->
  <main role="main" class="col-md-10 pt-3 px-4 main-content">
    <div class="wrapper">
      <div class="container-fluid page-content">
        @yield('content')
        <!-- end container-fluid -->
      </div>
    </div>
  </main>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get a reference to the input field
        var inputField = document.getElementById('correct_option');
        
        // Add an input event listener to the input field
        inputField.addEventListener('input', function() {
            // Get the current value of the input field
            var inputValue = this.value;
            
            // Remove any characters that are not 'a', 'b', 'c', or 'd'
            inputValue = inputValue.replace(/[^abcd]/g, '');
            
            // Ensure that the input value is only one character long
            if (inputValue.length > 1) {
                inputValue = inputValue.substring(0, 1);
            }
            
            // Update the input field value with the filtered value
            this.value = inputValue;
        });
    });
  </script>     
</body>
</html>
