<?php use App\User_groups; ?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="facebook-domain-verification" content="7pp2llv7ir1ju2fll9d4pt8gj8xpkz" />
        <title>BorrowMe</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}" />

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            /*html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }*/

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            .custom_badge {
                position: absolute;
                top: -4px;
                right: 127px;
                padding: 2px 5px;
                border-radius: 50%;
                background: red;
                color: white;
                font-size: 10px;
              }
        </style>
        <link href="{{ asset('styles.css') }}" rel="stylesheet">
        <link href="{{ asset('css/main.css') }}" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/b6de54a31f.js" crossorigin="anonymous"></script>

    </head>
    <body>
        <!-- <header id="listing-header">
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
                    <div class="">
                      <select class="form-control" id="location" name="location">
                          <option>All Cities (UAE)</option>
                          <option>Abu Dhabi</option>
                          <option>Ajman</option>
                          <option>Al Ain</option>
                          <option>Dubai</option>
                          <option>Fujairah</option>
                          <option>Ras al Khaimah</option>
                          <option>Sharjah</option>
                          <option>Umm al Quwain</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                @if($logged)
                <div class="header-right text-right">
                  <a href="{{URL::route('product_listing')}}" class="btn btn-secondary">Lend your item</a>
                  <a href="/chat"><i class="fas fa-envelope"></i></a>
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
                          @if($user->role == 1)
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
        </header> -->

        @include('layouts/mainheader')

        @include('layouts/main_menu')

        <div class="home-search-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="home-search">
                            @if($logged)
                                <h2>Together you have more!</h2>
                                <h3>Find out what you can borrow in your area.</h3>
                            @else
                                <h2>Borrow almost anything</h2>
                                <h3>Why buy when you can Borrow</h3>
                            @endif
                            <div class="home-search-form">
                                <form class="" action="/search">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <input type="text" name="q" class="form-control" placeholder="What are you looking for?">
                                            <input type="hidden" name="location_select" value="@if(Auth::check()){{$user->city}}@endif">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-default">Search</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @if($logged)
                                <div class="text-center advance-search mt-4" style="height:200px;">
                                    <a class="btn btn-primary" href="/search">Advance search</a>
                                </div>
                            @else
                                <div class="home-search-buttons">
                                    <div class="row d-flex align-items-end">
                                        <div class="col-md-4">
                                            <a href="/pages/how-it-works">
                                                <button type="button" class="btn btn-light how-it-works">How it works</button>
                                            </a>
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <a href="{{URL::route('product_listing')}}">
                                                <label for="lend" class="lend">Do you have something for rent</label>
                                                <button type="button" class="btn btn-primary" id="lend">Lend your item</button>
                                            </a>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mobile-apps">
                                                <img src="/images/mobile-apps.png" alt="Mobile apps" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(!$logged)
            <div class="featured-column">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="featured-column-content">
                                <div class="icon">
                                    <i class="fas fa-handshake"></i>
                                </div>
                                <h4>Borrow anything</h4>
                                <p>Borrow things from your neighbors instead of buying</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                        <div class="featured-column-content">
                                <div class="icon">
                                    <i class="fas fa-hand-holding-usd"></i>
                                </div>
                                <h4>Save money</h4>
                                <p>Buy less. Rent for a fraction of the cost.</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                        <div class="featured-column-content">
                                <div class="icon">
                                    <i class="fas fa-box"></i>
                                </div>
                                <h4>Lend your goods</h4>
                                <p>60% of your goods are useless make money by lending them.</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                        <div class="featured-column-content">
                                <div class="icon">
                                    <i class="fas fa-rocket"></i>
                                </div>
                                <h4>Boost your business</h4>
                                <p>If you are rental business then you are on the right place.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($logged)
            <div class="container">
                @if(count($new) > 0)
                    <h4 class="section-title text-center mt-5 mb-5">New in your area</h4>
                    @for($n = 0; $n < count($new); )
                        <div class="row new-in-area @if($n >= 3) hide new-area-hidden @endif">
                            @for($j = 0; $n < count($new) && $j < 3; $j++)
                                <div class="col-6 col-md-4">
                                    <div class="home-product-card mb-4">
                                        <div class="home-product-card-image">
                                        <a href="/product/view/{{$new[$n]->id}}">
                                            <img src="{{asset('uploads'). '/' . $new[$n]->primary_img}}" width="350px" height="250px">
                                        </a>
                                        <span class="product-card-price">{{'AED-'.$new[$n]->daily_aed.'/day' ?? ''}}</span>
                                        </div>
                                        <div class="home-product-card-content">
                                            <div class="home-product-card-desc">{{$new[$n]->description}}</div>
                                            <div class="row align-items-center">
                                                <div class="col-6 col-md-6">
                                                    <img src="{{asset('uploads') . '/' . $new[$n]->vendor_img}}" class="vendor-image" width="40px" height="40px">
                                                    <span class="vendor-name">
                                                        {{$new[$n]->vendor_name}}
                                                    </span>
                                                </div>
                                                <div class="col-6 col-md-6">
                                                    <span class="d-block text-right rating">
                                                        @for($x = 0; $x < $new[$n]->rating; $x++)
                                                            <i class="fas fa-star" aria-hidden="true"></i>
                                                        @endfor
                                                        ({{ceil($new[$n]->rating)}})
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $n++
                                @endphp
                            @endfor
                        </div>
                    @endfor
                @endif
                @if(count($new) > 0 && $n > 3)
                    <div class="text-center mt-5 mb-5">
                        <button type="button" class="btn btn-outline-primary" id="new-products">View more</button>
                    </div>
                @endif
            </div>

            <div class="container">
                @if(count($most) > 0)
                    <h4 class="section-title text-center mt-5 mb-5">Most borrowed</h4>
                    @for($i = 0; $i < count($most); )
                        <div class="row most-borrowed @if($i >= 3) hide most-borrowed-hidden @endif">
                            @for($j = 0; $i < count($most) && $j < 3; $j++)
                                <div class="col-6 col-md-4">
                                    <div class="home-product-card mb-4">
                                        <div class="home-product-card-image">
                                            <a href="/product/view/{{$most[$i]->id}}">
                                                <img src="{{asset('uploads'). '/' . $most[$i]->primary_img}}" width="350px" height="250px">
                                            </a>
                                            <span class="product-card-price">{{'AED-'.$most[$i]->daily_aed.'/day' ?? ''}}</span>
                                        </div>
                                        <div class="home-product-card-content">
                                            <div class="home-product-card-desc">{{$most[$i]->description}}</div>
                                            <div class="row align-items-center">
                                                <div class="col-6 col-md-6">
                                                    <img src="{{asset('uploads') . '/' . $most[$i]->vendor_img}}" class="vendor-image" width="40px" height="40px">
                                                    <span class="vendor-name">
                                                        {{$most[$i]->vendor_name}}
                                                    </span>
                                                </div>
                                                <div class="col-6 col-md-6">
                                                    <span class="d-block text-right rating">
                                                        @for($x = 0; $x < $most[$i]->rating; $x++)
                                                            <i class="fas fa-star" aria-hidden="true"></i>
                                                        @endfor
                                                        ({{ceil($most[$i]->rating)}})
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $i++;
                                @endphp
                            @endfor
                        </div>
                    @endfor
                @endif
                @if(count($most) > 0 && $i > 3)
                    <div class="text-center mt-5 mb-5">
                        <button type="button" class="btn btn-outline-primary" id="most-borrowed">View more</button>
                    </div>
                @endif
            </div>

            <!-- <div class="container">
                @if(count($other) > 0)
                    <h4 class="section-title text-center mt-5 mb-5">Other products</h4>
                    @for($a = 0; $a < count($other); )
                        <div class="row other-products @if($a >= 6) hide @endif">
                            @for($b = 0; $a < count($other) && $b < 3; $b++)
                                <div class="col-6 col-md-4">
                                    <div class="home-product-card mb-4">
                                        <div class="home-product-card-image">
                                            <a href="/product/view/{{$other[$a]->id}}">
                                                <img src="{{asset('uploads'). '/' . $other[$a]->primary_img}}" width="350px" height="250px">
                                            </a>
                                            <span class="product-card-price">{{'AED-'.$other[$a]->daily_aed.'/day' ?? ''}}</span>
                                        </div>
                                        <div class="home-product-card-content">
                                            <div class="home-product-card-desc">{{$other[$a]->description}}</div>
                                            <div class="row align-items-center">
                                                <div class="col-6 col-md-6">
                                                    <img src="{{asset('uploads') . '/' . $other[$a]->vendor_img}}" class="vendor-image" width="40px" height="40px">
                                                    <span class="vendor-name">{{$other[$a]->vendor_name}}</span>
                                                </div>
                                                <div class="col-6 col-md-6">
                                                    <span class="d-block text-right rating">
                                                    @for($y = 0; $y < $other[$a]->rating; $y++)
                                                        <i class="fas fa-star" aria-hidden="true"></i>
                                                    @endfor
                                                    ({{$other[$a]->rating}})
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $a++;
                                @endphp
                            @endfor
                        </div>
                    @endfor
                @endif
                @if(count($other) > 0 && $a > 6)
                    <div class="text-center mt-5 mb-5">
                        <button type="button" class="btn btn-outline-primary" id="other-products">View more</button>
                    </div>
                @endif
            </div> -->
        @else
            <div class="container">
                <div class="featured-video">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8 text-center">
                            <h4 class="section-title mb-5">Intro to Borrowme!</h4>
                            <center><iframe src="https://player.vimeo.com/video/479552651" width="100%" height="360" frameborder="0" allow="autoplay; fullscreen" allowfullscreen=""></iframe></center>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
                <div class="featured-products">
                    @if(count($other) > 0)
                            <h4 class="section-title mb-5 text-center">Popular products</h4>
                            @for($q = 0; $q < count($other); )
                                <div class="row popular-products @if($q >= 3) hide popular-product-hidden @endif">
                                    @for($r = 0; $q < count($other) && $r < 3; $r++)
                                    <div class="col-6 col-md-4">
                                        <div class="home-product-card mb-4">
                                            <div class="home-product-card-image">
                                                <a href="/product/view/{{$other[$q]->id}}">
                                                    <img src="{{asset('uploads') . '/' .$other[$q]->primary_img}}" width="350px" height="250px">
                                                </a>
                                                <span class="product-card-price">{{'AED-'.$other[$q]->daily_aed.'/day' ?? ''}}</span>
                                            </div>
                                            <div class="home-product-card-content">
                                                <div class="home-product-card-desc">{{$other[$q]->description}}</div>
                                                <div class="row align-items-center">
                                                    <div class="col-6 col-md-6">
                                                        <img src="{{asset('uploads') . '/' . $other[$q]->vendor_img}}" class="vendor-image" width="40px" height="40px">
                                                        <span class="vendor-name">{{$other[$q]->vendor_name}}</span>
                                                    </div>
                                                    <div class="col-6 col-md-6">
                                                        <span class="d-block text-right rating">
                                                            @for($o = 0; $o < $other[$q]->rating; $o++)
                                                                <i class="fas fa-star" aria-hidden="true"></i>
                                                            @endfor
                                                            ({{ceil($other[$q]->rating)}})
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        $q++;
                                    @endphp
                                    @endfor
                                </div>
                            @endfor
                    @endif
                    @if(count($other) > 0 && $q > 3)
                        <div class="text-center mt-5 mb-5">
                            <button type="button" class="btn btn-outline-primary" id="popular-products">View more</button>
                        </div>
                    @endif
                </div>
                <div class="testimonials">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h4 class="section-title mt-4 mb-4">Testimonials</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor<br>incididunt ut labore</p>
                        </div>
                        <div class="col-md-4">
                            <div class="testimonial-content">
                                <p class="testimonial-desc">I'm a frequent visitor to Dubai. I'm often faced with the challenge of deciding between buying things I need when I'm here or going without to save money. With BorrowMe, I now rent the things I need and return them when I leave.
                                </p>
                                <div class="testimonial-author">
                                    <div class="row">
                                        <div class="col-4">
                                        <img src="{{asset('uploads/default6738888.jpg')}}" width="50" height="50">
                                        </div>
                                        <div class="col-8">
                                            <p class="author-name">Jay</p>
                                            <p class="location">Dubai</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="testimonial-content">
                                <p class="testimonial-desc">I have tons of supplies I bought for my wedding reception. Before, they were just lying around occupying space, but with BorrowMe, I rent them out to different couples almost every weekend and make cash doing it.</p>
                                <div class="testimonial-author">
                                    <div class="row">
                                        <div class="col-4">
                                        <img src="{{asset('uploads/default6738888.jpg')}}" width="50" height="50">
                                        </div>
                                        <div class="col-8">
                                            <p class="author-name">Jasmine</p>
                                            <p class="location">Dubai</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="testimonial-content">
                                <p class="testimonial-desc">BorrowMe is a must-have if your line of work requires frequent use of different equipment and you don't want to purchase it all. BorrowMe is a Godsend.</p>
                                <div class="testimonial-author">
                                    <div class="row">
                                        <div class="col-4">
                                        <img src="{{asset('uploads/default6738888.jpg')}}" width="50" height="50">
                                        </div>
                                        <div class="col-8">
                                            <p class="author-name">Rami</p>
                                            <p class="location">Dubai</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @include('layouts/footer')
        <script src="https://kit.fontawesome.com/c2c710899b.js" crossorigin="anonymous"></script>
        <script type="text/javascript">
            $("#new-products").on("click", function(){
                var txt = $(this).text();
                if(txt == 'View more') {
                    $(this).text('View less');
                    $(".new-in-area").removeClass("hide");
                }
                else {
                    $(this).text('View more');
                    $(".new-area-hidden").addClass("hide");
                }
            });
            $("#most-borrowed").on("click", function(){
                var txt_2 = $(this).text();
                if(txt_2 == 'View more') {
                    $(this).text('View less');
                    $(".most-borrowed").removeClass("hide");
                }
                else {
                    $(this).text('View more');
                    $(".most-borrowed-hidden").addClass("hide");
                }
            });
            $("#other-products").on("click", function(){
                $(".other-products").removeClass("hide");
            });

            $("#popular-products").on("click", function(){
                var txt_3 = $(this).text();
                if(txt_3 == 'View more') {
                     $(this).text('View less');
                     $(".popular-products").removeClass("hide");
                }
                else {
                    $(this).text('View more');
                    $(".popular-product-hidden").addClass("hide");
                }
                
            });

        </script>
        <style type="text/css">
            .hide {
                display: none;
            }
        </style>
    </body>
</html>
