<!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="height:40px;">
   <div style="float:right;width:150px;margin: 0 0 0 auto;"> 
   <a class="dropdown-item" href="{{ route('logout') }}"
     onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">
      {{ __('Logout') }}
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
      @csrf
    </form>
    </div>
  </nav>
  <!-- /.navbar -->