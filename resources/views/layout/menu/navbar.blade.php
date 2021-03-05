<nav class="main-header navbar navbar-expand navbar-white navbar-light sticky-top">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
    <li>
      @if(Auth::user()->isStudent())
      <a class="nav-link" href="{{ url('mahasiswa/home')}}"><b>HOME</b></i></a>
      @elseif(Auth::user()->isCoordinator())
      <a class="nav-link" href="{{ url('koor/dashboard')}}"><b>HOME</b></i></a>
      @elseif(Auth::user()->isAdmin())
      <a class="nav-link" href="{{ url ('admin/mahasiswa') }}"><b>HOME</b></i></a>
      @endif
    </li>
  </ul>
  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    @guest
    @else
    <li class="nav-item">
      <a class="nav-link btn btn-sm" data-widget="control-sidebar" data-slide="true" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
        <b class="mr-1">LOGOUT </b>
        <i class="fas fa-sign-out-alt"></i>
      </a>

      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>

    </li>
    @endguest
  </ul>
</nav>