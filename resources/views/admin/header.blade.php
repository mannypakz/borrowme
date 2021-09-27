<header id="listing-header">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6">
        <div class="row align-items-center">
          <div class="col-md-4">
            <div class="logo">
              <a href="/">
                <img src="{{ asset('/images/logo-borrowme.png') }}" />
              </a>
            </div>
          </div>
          <div class="col-md-8">
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="header-right text-right"> 
          <div class="dropdown">
            <a>
              @if(null != $user->profile_image)
                <img src="{{asset('uploads')}}{{'/'.$user->profile_image}}" class="user-icon" alt="Image" width="30px" height="30px">
              @elseif(null != $user->company_logo)
                <img src="{{asset('uploads/')}}{{'/'. $user->company_logo}}" class="user-icon" alt="Image" width="24px" height="24px">
              @else
                <img src="{{asset('/uploads/default6738888.jpg')}}" class="user-icon" alt="Image" width="24px" height="24px">
              @endif
              
            </a>
            <div class="dropdown-content">
              <ul class="">
                  <li class="" style="list-style: none"><a href="/profile">My Profile</a></li>
                  <li class="" style="list-style: none">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                      @csrf
                      <a  href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                      {{ __('Logout') }}
                    </a>
                    </form>
                  </li>
                </ul> 
            </div>
          </div> 
        </div>
      </div>
    </div>
  </div>
</header>