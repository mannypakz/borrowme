<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  @if(null != $user)
   <div class="mobile-menu-user-icon">
        <a>
            @if(null != $user && null != $user->profile_image)
                <img src="{{asset('uploads')}}{{'/'.$user->profile_image}}" class="user-icon" alt="Image" width="30px" height="30px">
            @elseif(null != $user && null != $user->company_logo)
                <img src="{{asset('uploads/')}}{{'/'. $user->company_logo}}" class="user-icon" alt="Image" width="24px" height="24px">
            @else
                <img src="{{asset('/uploads/default6738888.jpg')}}" class="user-icon" alt="Image" width="24px" height="24px">
            @endif
        </a>
        <p>{{$user->first_name}} {{$user->last_name}}</p>
        <div class="line-border"></div>
    </div>
  @endif
  <ul class="navbar-nav" style="padding: 0 20px;">
      <li class="nav-item"><a href="/" class="nav-link">HOME</a></li>
      <li class="nav-item"><a href="/pages/how-it-works" class="nav-link">HOW IT WORKS</a></li>
      <li class="accordion nav-item mega-dropdown">SEARCH CATEGORIES</li>
      <div class="panel">
            <ul class="footer-menu list-unstyled">
                @php
                    $menu_json_arr = json_decode($json_obj);
                @endphp
                @foreach($menu_json_arr as $key => $i)
                    <li class="nav-item mega-dropdown">
                        <a class="nav-link dropdown-toggle text-uppercase">{{$key}}</a><span class="accordion"></span>
                        <div class="panel">

                            @foreach($i as $key1 => $j)
                               <div class="nav-item-sub-link"><a href="/category/{{strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $key1), '-'))}}?level={{$key1}}" class="nav-link-sub-item">{{$key1}}</a><span class="accordion"></span>
                                <div class="panel">
                                    <ul class="list-unstyled grandchild-menu pt-2">
                                    @php
                                        $child_counter = 0;
                                    @endphp
                                    @foreach($j as $key2 => $k)
                                        @if($child_counter < 5)
                                            <li>
                                                <a class="menu-item pl-0" href="/category/{{strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $k), '-'))}}">{{$k}}</a>
                                            </li>
                                        @endif
                                        @php
                                            $child_counter++;
                                        @endphp
                                    @endforeach
                                    @if($child_counter > 5)
                                        <li>
                                            <a href="/category/{{strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $key1), '-'))}}?level={{$key1}}" style="color:#2CB6A9;">More...</a>
                                        </li>
                                    @endif
                                    </ul>
                                </div>
                                </div>
                             @endforeach

                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        @if(null != $user)
        <li class="nav-item"><a href="/products/listing" class="nav-link">LEND YOUR ITEM</a></li>
        <li class="nav-item"><a href="/chat" class="nav-link">INBOX</a></li>
        <li class="nav-item"><a href="/notifications" class="nav-link">NOTIFICATIONS</a></li>
        <li class="nav-item"><a href="/item" class="nav-link">ITEM MANAGEMENT</a></li>
        <li class="nav-item"><a href="/item/history" class="nav-link">ITEM HISTORY</a></li>
        <li class="nav-item"><a href="/orders/history" class="nav-link">ORDERS HISTORY</a></li>
        <li class="nav-item accordion">PROFILE</li>
        <div class="panel">
            <ul class="list-unstyled">
            <li><a href="/profile" class="nav-link">My Contact Details</a></li>
            <li><a href="/profile/favorite" class="nav-link">My Favorite</a></li>
            </ul>
        </div>
        <li class="nav-item accordion">SETTINGS</li>
        <div class="panel">
            <ul class="list-unstyled">
            <li><a href="/setting" class="nav-link">Password Management</a></li>
            <li><a href="/setting/notification" class="nav-link">Notifications</a></li>
            </ul>
        </div>
        @endif
    </ul>
    @if(null != $user)
    <div class="mobile-logout">
        <form id="logout-form" action="{{ route('logout') }}" method="POST">
        @csrf
        <a  href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="mobile-logout">
        {{ __('Log out') }}
        </a>
        </form>
    </div>
    @endif
</div>
@if(isset($menu) && count($menu) > 0)
<div class="content-header main-menu">
	<div class="row">
		<div class="col-md-12">
			<!-- Navbar -->
			<nav class="navbar navbar-expand-lg navbar-dark special-color-dark">
			<!-- Collapse button -->
			<!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent2"
			aria-controls="navbarSupportedContent2" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
			</button> -->

			<!-- Collapsible content -->
			<div class="collapse navbar-collapse" id="navbarSupportedContent2">
			<!-- Links -->
			<ul class="navbar-nav mr-auto">
				@php
					$menu_json_arr = json_decode($json_obj);
				@endphp
				@foreach($menu_json_arr as $key => $i)
					<li class="nav-item mega-dropdown">
						<a class="nav-link dropdown-toggle text-uppercase" id="navbarDropdownMenuLink3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{$key}}</a>
                        <div class="dropdown-menu mega-menu v-2 z-depth-1 special-color py-4 px-3" aria-labelledby="navbarDropdownMenuLink3">
                            <a href="#"><img src="{{ asset('images/exit.png') }}" class="exit-icon"></a>
                                <div class="container">
                                    <div class="row">
                                        @foreach($i as $key1 => $j)
                                            <div class="col-md-3 col-xl-3 sub-menu mb-4">
                                                <a href="/category/{{strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $key1), '-'))}}?level={{$key1}}" class="sub-title black-text">{{$key1}}</a>
                                                <ul class="list-unstyled grandchild-menu pt-2">
                                                @php
                                                    $child_counter = 0;
                                                @endphp
                                                @foreach($j as $key2 => $k)
                                                    @if($child_counter < 5)
                                                        <li>
                                                            <a class="menu-item pl-0" href="/category/{{strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $k), '-'))}}">{{$k}}</a>
                                                        </li>
                                                    @endif
                                                    @php
                                                        $child_counter++;
                                                    @endphp
                                                @endforeach
                                                @if($child_counter > 5)
                                                    <li>
                                                        <a href="/category/{{strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $key1), '-'))}}?level={{$key1}}" style="color:#2CB6A9;">More...</a>
                                                    </li>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                        </div>
					</li>
				@endforeach
			</ul>
			<!-- Links -->
			</div>
			<!-- Collapsible content -->

			</nav>
			<!-- Navbar -->
			</div>
		</div>
	</div>
</div>
@endif

<!-- Modal -->
        <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="login-modalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="login-modalLongTitle">Login or Sign Up</h3>
                            <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button> -->
                        </div>
                        <div class="modal-body">
                            <div class="login-wrapper">
                                <a href="{{route('login')}}">
                                    <button type="button" class="btn btn-outline-primary btn-block mb-3">
                                    <img src="{{ asset('/images/email-icon.png') }}" /></i>Continue with Email
                                    </button>
                                </a>
                                <a href="{{route('google_login')}}">
                                    <button type="button" class="btn btn-outline-secondary btn-block mb-3 google-button">
                                    <img src="{{ asset('/images/google-icon.png') }}" class="google-icon" /></i>Continue with Google
                                    </button>
                                </a>
                                <a href="{{route('facebook_login')}}" class="d-none">
                                    <button type="button" class="btn btn-primary btn-block facebook-login">
                                    <i class="fab fa-facebook-f"></i>Continue with Facebook
                                    </button>
                                </a>
                            </div>

                            <div class="mt-5 register-wrapper">
                                <a href="{{route('register')}}">
                                    <button type="button" class="btn btn-outline-primary btn-block mb-3">
                                    <img src="{{ asset('/images/email-icon.png') }}" /></i>Sign up as an Individual
                                    </button>
                                </a>

                                <a href="{{route('reg_comp')}}">
                                    <button type="button" class="btn btn-primary btn-block">
                                    <i class="fas fa-address-card"></i>Sign up as Rental Business
                                    </button>
                                </a>
                            </div>

                            <div class="mt-4 text-center">
                                <small>By Signing up you agree to our <a href="/pages/terms-of-use" target="_blank">Terms of Service</a> and <a href="/pages/privacy-policy" target="_blank">Privacy Policy</a></small>
                            </div>
                        </div>
                        <div class="modal-footer"></div>
                    </div>
                </div>
        </div>


<style type="text/css">
  .dropdown-menu{
	  border-radius: 0!important;
	  width: 100%;
      margin-top: -2px;
  }
  a.nav-link{
	text-transform: initial!important;
    font-size: 14px;
	color: #fff!important;
	cursor: pointer;
  }
  a.sub-title{
	color: #000;
    font-family: 'Segoe UI Bold';
    font-size: 14px;
  }
  ul.navbar-nav li a.nav-link:hover,
  ul.navbar-nav li.show a.nav-link{
	color: #2cb7aa !important;
    background: #fff;
    outline: 0;
    border-radius: 4px;
  }
  ul.grandchild-menu{}
  ul.grandchild-menu li{}
  ul.grandchild-menu li a{
	color: #000;
	font-size: 13.7px;
  }
  .navbar-nav a:hover{
	  text-decoration: none;
  }
  .dropdown-toggle::after{
	vertical-align: 0.2em!important;
  }
  
  @media only screen and (max-width:767px){
    ul.navbar-nav li a.nav-link:focus, ul.navbar-nav li a.nav-link:hover{
        background: transparent!important;
        color: #fff!important;
    }
    .dropdown-menu .exit-icon{
        right: 20px;
    }
    ul li.nav-item{
        position: relative;
    }
    ul li.nav-item .accordion{
        position: absolute;
        top: 0;
    }
    .nav-link-sub-item{
        color: #fff;
        display: block;
        font-size: 14px;
        margin-bottom: 7px;
    }
    .nav-item-sub-link{
        position: relative;
    }
    .nav-item-sub-link .accordion{
        position: absolute;
        top: -8px!important;
        right: 0;
        width: auto;
    }
  }
</style>
<script>
    /* Set the width of the side navigation to 250px and the left margin of the page content to 250px and add a black background color to body */
    function openNav() {
        document.getElementById("mySidenav").style.width = "320px";
        document.getElementById("main").style.marginLeft = "320px";
        document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
    }

    /* Set the width of the side navigation to 0 and the left margin of the page content to 0, and the background color of body to white */
    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
        document.getElementById("main").style.marginLeft = "0";
        document.body.style.backgroundColor = "white";
    }
</script>
