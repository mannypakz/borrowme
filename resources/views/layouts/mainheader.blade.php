<?php use App\User_groups; ?>
<header id="listing-header">
  <div class="container">
    <div class="desktop-header d-none d-sm-none d-md-block d-lg-block">
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
            <div class="">
              <select class="form-control" id="location" name="location">
                  <option value="All Cities">All Cities (UAE)</option>
                  <option value="Abu Dhabi">Abu Dhabi</option>
                  <option value="Ajman">Ajman</option>
                  <option value="Al Ain">Al Ain</option>
                  <option value="Dubai">Dubai</option>
                  <option value="Fujairah">Fujairah</option>
                  <option value="Ras al Khaimah">Ras al Khaimah</option>
                  <option value="Sharjah">Sharjah</option>
                  <option value="Umm al Quwain">Umm al Quwain</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-md-6">
        @if(null != $user)
        <div class="header-right text-right"> 
          <a href="{{URL::route('product_listing')}}" class="btn btn-secondary">Lend your item</a>
          <a href="/chat"><i class="fas fa-envelope"></i>
             
          </a>
          <a href="/notifications">
            <i class="fas fa-bell"></i>
             <?php 
              $ug = User_groups::where("group_user_id", $user->id)->where("accepted", 0)->get();
              if(count($ug) > 0) {
                echo '<span class="custom_badge">'.count($ug).'</span>';
              }
              ?>
          </a>
          <a href="{{URL::route('profile_favorite')}}"><i class="fas fa-heart"></i></a>
          <div class="dropdown">
            <a>
              @if(null != $user && null != $user->profile_image)
                <img src="{{asset('uploads')}}{{'/'.$user->profile_image}}" class="user-icon" alt="Image" width="30px" height="30px">
              @elseif(null != $user && null != $user->company_logo)
                <img src="{{asset('uploads/')}}{{'/'. $user->company_logo}}" class="user-icon" alt="Image" width="24px" height="24px">
              @else
                <img src="{{asset('/uploads/default6738888.jpg')}}" class="user-icon" alt="Image" width="24px" height="24px">
              @endif
              
            </a>
            <div class="dropdown-content">
              <ul class="">
                  @if(null != $user && $user->role == 1)
                    <li class=""><a href="/admin">Administrator</a></li>
                  @endif
                  <li class=""><a href="/profile">My Profile</a></li>
                  <li class="">
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
        @else
          <div class="header-right text-right">
            <div class="dropdown">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#login-modal">Login or Sign up</button>
            </div>
          </div>
        @endif
      </div>
    </div>
    </div>

    <div class="mobile-header d-md-none d-lg-none">
      <div class="row no-gutters justify-content-center align-items-center">
          <div class="col-4">
              <div class="row no-gutters">
                  <div class="col-4">
                      <!-- Collapse button -->
                      <button class="navbar-toggler" type="button" onclick="openNav()">
                      <i class="fas fa-bars"></i>
                      </button>
                  </div>
                  <div class="col-8">
                    <div class="location-dropdown">
                      <select class="form-control" id="location" name="location">
                          <option value="All Cities">All Cities (UAE)</option>
                          <option value="Abu Dhabi" @if(null != $user && $user->city == 'Abu Dhabi') selected @endif>Abu Dhabi</option>
                          <option value="Ajman" @if(null != $user && $user->city == 'Ajman') selected @endif>Ajman</option>
                          <option value="Al Ain" @if(null != $user && $user->city == 'Al Ain') selected @endif>Al Ain</option>
                          <option value="Dubai" @if(null != $user && $user->city == 'Dubai') selected @endif>Dubai</option>
                          <option value="Fujairah" @if(null != $user && $user->city == 'Fujairah') selected @endif>Fujairah</option>
                          <option value="Ras al Khaimah" @if(null != $user && $user->city == 'Ras al Khaimah') selected @endif>Ras al Khaimah</option>
                          <option value="Sharjah" @if(null != $user && $user->city == 'Sharjah') selected @endif>Sharjah</option>
                          <option value="Umm al Quwain" @if(null != $user && $user->city == 'Umm al Quwain') selected @endif>Umm al Quwain</option>
                      </select>
                    </div>
                  </div>
              </div>
          </div>
          <div class="col-4">
              <div class="logo">
                <a href="/">
                  <img src="{{ asset('/images/logo-borrowme.png') }}" />
                </a>
              </div>
          </div>
          <div class="col-4">
              @if(null != $user)
              <div class="header-right text-right"> 
                <a href="{{URL::route('product_listing')}}" class="btn btn-secondary">Lend your item</a>
                <a href="/chat" class="d-none d-sm-none d-md-block d-lg-block"><i class="fas fa-envelope"></i>
                  
                </a>
                <a href="/notifications" class="d-none d-sm-none d-md-block d-lg-block">
                  <i class="fas fa-bell"></i>
                  <?php 
                    $ug = User_groups::where("group_user_id", $user->id)->where("accepted", 0)->get();
                    if(count($ug) > 0) {
                      echo '<span class="custom_badge">'.count($ug).'</span>';
                    }
                    ?>
                </a>
                <a href="{{URL::route('profile_favorite')}}" class="d-none d-sm-none d-md-block d-lg-block"><i class="fas fa-heart"></i></a>
                <div class="dropdown d-none d-sm-none d-md-block d-lg-block">
                  <a>
                    @if(null != $user && null != $user->profile_image)
                      <img src="{{asset('uploads')}}{{'/'.$user->profile_image}}" class="user-icon" alt="Image" width="30px" height="30px">
                    @elseif(null != $user && null != $user->company_logo)
                      <img src="{{asset('uploads/')}}{{'/'. $user->company_logo}}" class="user-icon" alt="Image" width="24px" height="24px">
                    @else
                      <img src="{{asset('/uploads/default6738888.jpg')}}" class="user-icon" alt="Image" width="24px" height="24px">
                    @endif
                    
                  </a>
                  <div class="dropdown-content">
                    <ul class="">
                        @if(null != $user && $user->role == 1)
                          <li class=""><a href="/admin">Administrator</a></li>
                        @endif
                        <li class=""><a href="/profile">My Profile</a></li>
                        <li class="">
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
              @else
                <div class="header-right text-right">
                  <div class="dropdown">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#login-modal">Login or Sign up</button>
                  </div>
                </div>
              @endif
          </div>
      </div>
    </div>

  </div>
</header>
<style type="text/css">
  .custom_badge {
    position: absolute;
    top: -4px;
    right: 127px;
    padding: 2px 5px;
    border-radius: 50%;
    background: red;
    color: white;
    font-size: 10px
  }
</style>
<script type="text/javascript">
  var loc = localStorage.getItem("location");

  if(!!loc) {
    $("#location").val(loc);
  }

  $("#location").on("change", function(){
    localStorage.setItem("location", this.value);
  });
</script>