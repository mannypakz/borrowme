@if(isset($menu) && count($menu) > 0)
<div class="content-header main-menu mb-2">
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
                            <div class="row">
                                @foreach($i as $key1 => $j)
                                    <div class="col-md-2 col-xl-2 sub-menu mb-md-0 mb-4">
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

<div class="content-header order-breadcrumb" style="background-color: #fff;">
    <div class="container">
    	<div class="row">
          <div class="col-md-12">
            <p style="font-size: 14px; color: #000;">
              <a href="/category/{{strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $product->category), '-'))}}">{{$product->category}}</a> > 
              <a href="/category/{{strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $product->sub_category), '-'))}}">{{$product->sub_category}}</a> > 
              <a href="/category/{{strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $product->item_type), '-'))}}">{{$product->item_type}}</a>
            </p>
          </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

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
                                <a href="{{route('facebook_login')}}">
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
                                <small>By Signing up you agree to our Terms of Service and Privacy Policy</small>
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
  ul.navbar-nav li a.nav-link:focus,
  ul.navbar-nav li a.nav-link:hover{
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
  }
</style>