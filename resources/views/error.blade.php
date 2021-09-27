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
            </div>
          </div>
        </header>

        @include('layouts/main_menu')
        
        <div class="container">
            <div class="row" style="height: 500px;">
                <div class="col-md-12 align-middle">
                    <center class="v-center">Page not found!</center>
                </div>
            </div>   
        </div>

        @include('layouts/footer')
        <style type="text/css">
            .hide {
                display: none;
            }
            .v-center {
                margin-top: 20%;
                font-size: 24px;
                color: #ccc;
            }
        </style>
    </body>
</html>
