<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Borrow Me</title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}" />

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="/adminlte/dist/css/adminlte.min.css">
  <link href="{{ asset('styles.css') }}" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  <!-- Chosen css -->
  <link rel="stylesheet" type="text/css" href="{{ asset('chosen/chosen.min.css') }}">
  <!-- Chosen jquery -->
  <script type="text/javascript" src="{{ asset('chosen/chosen.jquery.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('chosen/chosen.proto.min.js') }}"></script>
</head>
<body class="hold-transition sidebar-mini page-{{ Route::current()->getName() }}">
<div class="wrapper">

  <!-- Header -->
  @include('layouts/mainheader')
 
  <!-- Content Wrapper. Contains page content -->
  <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        @if(session('listing_status') == 'success')
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Product saved!</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @elseif(session('listing_status') == 'error')
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Error saving!</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif

       <div class="row mb-2 listing-title">
          <div class="step1 br-white">1.Category & Description</div>
          <div class="step2 br-white">2.Price</div>
          <div class="step3 br-white">3.Photos</div>
          <div class="step4 br-white">4.Location</div>
          <div class="step5">5.Review & Confirmation</div>
        </div><!-- /.row -->
        <div class="row listing-header">
          <div class="step1 done">&nbsp</div>
          <div class="step2">&nbsp</div>
          <div class="step3">&nbsp</div>
          <div class="step4">&nbsp</div>
          <div class="step5">&nbsp</div>
          <input type="hidden" id="header-counter" value="0">
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
  <div class="container">
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
          <form enctype="multipart/form-data" method="post" action="{{ route('listing_save') }}">
            @csrf
          <div class="row page0">
            <div class="col-sm-5">
              <div class="form-group">
                <label for="category" class="h2 mb-4 mt-4">Pick a category</label>
                <select class="form-control mb-2" id="category" name="category" required>
                    <option disabled selected value="">Select category</option>
                </select>
                <small class="required">This field is requried</small>
                <select class="form-control mb-2 mt-4" name="sub_category" id="sub-category" required>
                    <option disabled selected value="">Select Sub-category</option>
                </select>
                <small class="required">This field is requried</small>
                <select class="form-control mt-4" name="item_type" id="item-type" required>
                    <option disabled selected value="">Item Type</option>
                </select>
                <small class="required">This field is requried</small>
              </div>

              <div class="form-group">
                <label for="item-name" class="h2 mb-4 mt-4">Title</label>
                <input type="text" name="item_name" class="form-control" id="item-name" required placeholder="Item name" autocomplete="off">
                <small class="required">This field is requried</small>
              </div>

              <div class="form-group">
                <label for="description" class="h2 mb-4 mt-4">Describe your item</label>
                <span class="character-limit">(1600)</span>
                <textarea class="form-control" id="description" name="description" maxlength="1600" required placeholder="Add a detailed description here"></textarea>
                <small class="required">This field is requried</small>
              </div>

              <div class="form-group">
                <label for="item_condition" class="h2 mb-4 mt-4">Your item condition</label>
                <select class="form-control" name="item_condition" id="item-condition">
                  <option>Flawless</option>
                  <option>Excellent</option>
                  <option>Good</option>
                  <option>Average</option>
                  <option>Poor</option>
                </select>
              </div>

              <div class="form-group">
                <label for="age" class="h2 mb-4 mt-4">Add Age</label>
                <select class="form-control" name="age" id="age">
                  <option>Less than 1 year</option>
                  <option>Less than 2 years</option>
                  <option>Less than 5 years</option>
                  <option>Less than 10 years</option>
                  <option>Any age</option>
                </select>
              </div>

              <div class="form-group">
                <label for="phone-code" class="h2 mb-4 mt-4">Add Mobile Number</label>
                <div class="row">
                  <div class="col-md-4">
                    <select class="form-control" name="phone_code" id="phone-code">
                      <option>UAE</option>
                    </select>
                  </div>
                  <div class="col-md-8">
                    <input class="form-control" type="text" name="phone" id="phone" placeholder="+971" autocomplete="off" onkeypress='return isNumberKey(event)'>
                  </div>
                </div>
              </div>

            </div>

            <div class="col-sm-2"></div>
            <div class="col-sm-5">
              <img src="{{ asset('/images/listing-tips.jpg') }}" />
              <h1>Item detail tips:</h1>
              <p class="h2 mb-4 mt-4">1. Read our minds</p>
              <p>Try and anticipate common questions, and include answers in your descript</p>
              <p class="h2 mb-4 mt-4">2. Don't skip on detail</p>
              <p>Explain what's included in the listing (and what's not), describe the condition and flag any faults.</p>
            </div>
          </div>

          <div class="row page1 d-none">
            <div class="col-sm-5">
              <div class="form-group">
                <label class="h2 mb-4">Select rental duration & rates</label>
                <div class="row mb-3">
                  <div class="col-md-3">
                    <div class="checkbox">
                      <label class="container">
                        <input type="checkbox" value="1" name="rental_duration_daily" id="daily-check" checked>
                        <span class="checkmark"></span> Daily
                      </label>
                    </div>
                  </div>
                  <div class="col-md-9">
                    <input class="form-control" type="text" name="daily_aed" id="daily-aed" placeholder="AED" required autocomplete="off" onkeypress='return isNumberKey(event)'>
                    <small class="required" id="daily-req">This field is requried</small>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-3">
                    <div class="checkbox">
                      <label class="container">
                        <input type="checkbox" value="1" name="rental_duration_weekly" id="weekly-check" checked>
                        <span class="checkmark"></span> Weekly
                      </label>
                    </div>
                  </div>
                  <div class="col-md-9">
                    <input class="form-control" type="text" name="weekly_aed" id="weekly-aed" placeholder="AED" required autocomplete="off" onkeypress='return isNumberKey(event)'>
                    <small class="required" id="weekly-req">This field is requried</small>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-3">
                    <div class="checkbox">
                      <label class="container">
                        <input type="checkbox" value="1" name="rental_duration_monthly" id="monthly-check" checked>
                        <span class="checkmark"></span> Monthly
                      </label>
                    </div>
                  </div>
                  <div class="col-md-9">
                    <input class="form-control" type="text" name="monthly_aed" id="monthly-aed" placeholder="AED" required autocomplete="off" onkeypress='return isNumberKey(event)'>
                    <small class="required" id="monthly-req">This field is requried</small>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="h2 mb-4 mt-3">Required cash deposit on collection</label>
                <small class="optional">Optional</small>
                <input class="form-control mb-2" type="number" value="0" name="cash_deposit" id="cash-deposit" placeholder="AED" autocomplete="off" onkeypress='return isNumberKey(event)'>
                <div class="checkbox mt-5">
                      <label class="container">
                        <input type="checkbox" name="available_for_sale" id="avilable-for-sale" value="yes" checked>
                        <span class="checkmark"></span> Items available for sale
                      </label>
                    </div>
              </div>

              <div class="form-group">
                <label class="h2 mb-4">Sale price</label>
                <input type="text" class="form-control" name="sale_price" id="sale-price" placeholder="AED" required autocomplete="off" onkeypress='return isNumberKey(event)'>
                <small class="required" id="sale-req">This field is required</small>
              </div>
            </div>
            <div class="col-sm-2"></div>
            <div class="col-sm-5">
              <img src="{{ asset('/images/listing-tips.jpg') }}" />
              <h1 class="mb-4">Top tips:</h1>
              <p>This figure affects how we verify rental requests on your item. If you're not sure what your item is worth, put what you paid for it.</p>
            </div>
          </div>

          <div class="row page2 d-none">
            <div class="col-sm-5">
              <div class="form-group">
                <label class="h2 mb-4" style="margin-top:7rem;">Add some photos</label>
                <div class="file-upload-wrapper">
                  <label for="product-image" class="listing-image-upload">
                      <i class="far fa-images"></i><br>(Click to upload images)
                  </label>
                  <input type="file" id="product-image" class="file-upload" name="product_image" required/>
                  <div>
                    <small id="image-req" class="required">This is a required field</small>
                    <small class="img-err d-none" style="color:red;">Format is not supported, please upload .png, .jpeg or .jpg</small>
                  </div>
                  <div id="image-gallery-wrapper" class="d-flex" style="flex-wrap: wrap;">
                    
                  </div>
                </div>
                <input type="hidden" name="primary_img" id="primary-img">
              </div>
            </div>
            <div class="col-sm-2"></div>
            <div class="col-sm-5">
              <img src="{{ asset('/images/listing-tips.jpg') }}" />
              <h1>Image tips:</h1>
              <p class="h2 mb-4 mt-4">1. Landscape's best</p>
              <p>Make sure you photograph the actual item (don't use stock images). People are more likely to request if they can see what they will actually be getting</p>
              <p class="h2 mb-4 mt-4">2. Avoid stock images</p>
              <p>People like seeing the actual item they're getting</p>
              <p class="h2 mb-4 mt-4">3. Pick a strong cover photo</p>
              <p>Once uploaded, just drag images to reorder</p>
            </div>
          </div>

          <div class="row page3 d-none">
            <div class="col-sm-5">
              <div class="form-group">
                <label class="h2 mb-4" style="margin-top:6rem;">Item Location</label>
                <p>We automatically populated your location. kindly confirm you location by clicking next or change to your desire location.</p>
              </div>
              <input class="form-control" type="text" id="location-1" name="location_1" placeholder="Flat/Villa No:" required autocomplete="off" value="{{$user->address_line1}}">
              <small class="required">This field is required</small>
              <input class="form-control mt-4" type="text" id="location-2" name="location_2" placeholder="Building/Villa:" required autocomplete="off" value="{{$user->address_line2}}">
              <small class="required">This field is required</small>
              <input class="form-control mt-4" type="text" id="street" name="street" placeholder="Street:" autocomplete="off">
              <small class="required">This field is required</small>
              <input class="form-control mt-4" type="text" id="area" name="area" placeholder="Area:" required autocomplete="off">
              <small class="required">This field is required</small>
              <select class="form-control mt-4" name="city" required id="city">
                <option @if($user->city == 'Abu Dhabi') selected @endif>Abu Dhabi</option>
                <option @if($user->city == 'Ajman') selected @endif>Ajman</option>
                <option @if($user->city == 'Al Ain') selected @endif>Al Ain</option>
                <option @if($user->city == 'Dubai') selected @endif>Dubai</option>
                <option @if($user->city == 'Fujairah') selected @endif>Fujairah</option>
                <option @if($user->city == 'Ras al Khaimah') selected @endif>Ras al Khaimah</option>
                <option @if($user->city == 'Sharjah') selected @endif>Sharjah</option>
                <option @if($user->city == 'Umm al Quwain') selected @endif>Umm al Quwain</option>
              </select>
              <small class="required">This field is required</small>
              <small class="optional">Optional</small>
              @php
                $n = explode(",", $user->neighbourhood);
              @endphp
              <select class="form-control mb-4" id="neighbourhood" name="neighbourhood[]" multiple data-placeholder="Neigbourhood name (You may select more than one neighbourhood)">
              </select>
            </div>
            <div class="col-sm-2"></div>
            <div class="col-sm-5">
              <img src="{{ asset('/images/listing-tips.jpg') }}" />
              <h1>Top tips:</h1>
              <p class="h2 mb-4 mt-3">1. Smart pricing</p>
              <p>Our algorithm generates a discount for borrowers over multiple-day rentals. This generates longer rentals and higher overall lender income. Click here for more info</p>
              <p class="h2 mb-4 mt-3">2. Location</p>
              <p>We won't display your exact location, just a rough indication.</p>
            </div>
          </div>

          <div class="row page4 d-none">
            <div class="col-sm-5">
              <h3 class="confirmation">Confirmation!</h3>
              <h4 class="mt-4 mb-4 font-weight-bold">Title</h4><h5 class="font-normal" id="conf-title"></h5>
              <h4 class="mt-4 mb-4 font-weight-bold">Category</h4><h5 class="font-normal" id="conf-category"></h5>
              <h4 class="mt-4 mb-4 font-weight-bold">Sub-category</h4><h5 class="font-normal" id="conf-sub-cat"></h5>
              <h4 class="mt-4 mb-4 font-weight-bold">Item description</h4><h5 class="font-normal" id="conf-desc" style="white-space: pre-wrap;"></h5>
              <div class="row align-items-center">
                <div class="col-md-6">
                  <h4 class="mt-4 mb-4 font-weight-bold">Item condition</h4>
                </div>
                <div class="col-md-6">
                  <h5 class="font-normal" id="conf-condition"></h5>
                </div>
              </div>
              <div class="row align-items-center">
                <div class="col-md-6">
                  <h4 class="mt-4 mb-4 font-weight-bold">Item age</h4>
                </div>
                <div class="col-md-6">
                  <h5 class="font-normal" id="conf-age"></h5>
                </div>
              </div>
              <div class="row align-items-center">
                <div class="col-md-6">
                  <h4 class="mt-4 mb-4 font-weight-bold">Phone number</h4>
                </div>
                <div class="col-md-6">
                  <h5 class="font-normal" id="conf-phone"></h5>
                </div>
              </div>
              <h4 class="mt-4 mb-4 font-weight-bold" id="rental-label">Rental rates</h4>
              <div class="row" id="rental-area">
                <!-- <div class="col-md-4">
                  <div class="rental-rate" id="daily-label">
                    AED-<span id="conf-daily"></span><br>
                    <label class="font-normal">Per day</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="rental-rate" id="weekly-label">
                    AED-<span id="conf-weekly"></span><br>
                    <label class="font-normal">Per week</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="rental-rate" id="monthly-label">
                    AED-<span id="conf-monthly"></span><br>
                    <label class="font-normal">Per month</label>
                  </div>
                </div> -->
              </div>
              <h4 class="mt-4 mb-4 font-weight-bold" id="cash-deposit-label">Required cash deposit on collection</h4>
              <span class="font-normal" id="conf-cash"></span>
              <br>
              <span class="font-normal" id="conf-avail"></span>
              <div class="row align-items-center">
                <div class="col-md-6">
                  <h4 class="mt-4 mb-4 font-weight-bold" id="sale-price-h4">Sale price</h4>
                </div>
                <div class="col-md-6">
                  <h5 class="font-normal" id="conf-sale-price"></h5>
                </div>
              </div>
              <div class="row align-items-center">
                <div class="col-md-6">
                  <h4 class="mt-4 mb-4 font-weight-bold">Flat number</h4>
                </div>
                <div class="col-md-6">
                  <h5 class="font-normal" id="conf-flat"></h5>
                </div>
              </div>
              <div class="row align-items-center">
                <div class="col-md-6">
                  <h4 class="mt-4 mb-4 font-weight-bold">Building name</h4>
                </div>
                <div class="col-md-6">
                  <h5 class="font-normal" id="conf-building"></h5>
                </div>
              </div>
              <div class="row align-items-center">
                <div class="col-md-6">
                  <h4 class="mt-4 mb-4 font-weight-bold">Street name / number</h4>
                </div>
                <div class="col-md-6">
                  <h5 class="font-normal" id="conf-street"></h5>
                </div>
              </div>
              <div class="row align-items-center">
                <div class="col-md-6">
                  <h4 class="mt-4 mb-4 font-weight-bold">Area name</h4>
                </div>
                <div class="col-md-6">
                  <h5 class="font-normal" id="conf-area"></h5>
                </div>
              </div>
              <div class="row align-items-center">
                <div class="col-md-6">
                  <h4 class="mt-4 mb-4 font-weight-bold">City name</h4>
                </div>
                <div class="col-md-6">
                  <h5 class="font-normal" id="conf-city"></h5>
                </div>
              </div>
              <div class="row align-items-center mb-4">
                <div class="col-md-6">
                  <h4 class="mt-4 mb-4 font-weight-bold">Neighborhood</h4>
                </div>
                <div class="col-md-6">
                  <h5 class="font-normal" id="conf-neighborhood"></h5>
                </div>
              </div>
            </div>
            <div class="col-sm-7 pt-5 text-center">
              <img src="" id="prod-img" height="400px" width="400px" alt="Image">
              <div id="image-gal" class="mt-1 d-flex" style="flex-wrap: wrap; justify-content: center;"></div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              <button type="button" class="btn back-button btn-outline-primary mt-4 d-none">Back</button>
              <button type="button" class="next-button btn btn-primary mt-4">Next</button>
              <button type="button" class="btn submit-button btn-primary mt-4 d-none conf-modal">Submit</button>
            </div>
          </div>
          <!-- Confirmation modal -->
          <div class="modal fade" id="confirmation" tabindex="-1" role="dialog" aria-labelledby="confirmationTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <h3 class="text-center">Borrowme is not liable<br> for any damage.</h3>
                  <div class="text-center">
                    <img src="{{ asset('/images/order-modal.jpg') }}">
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary btn-block">I agree</button>
                  <button type="button" class="btn btn-secondary btn-block cancel-order" data-dismiss="modal">Cancel</button>
                </div>
              </div>
            </div>
          </div>
          </form>
        </div>
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


 <!-- Footer -->
    @include('layouts/footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="/adminlte/dist/js/adminlte.min.js"></script>

<script type="text/javascript">
  var image_counter = 0;
  var rental = 3;

  $(".next-button").on('click', function(){
    var val = parseInt($("#header-counter").val());
    var elements = $(".page"+val).children().find('[required]');
    var errors = 0;

    for(var i = 0; i < elements.length; i++) {
      var valid = elements[i].reportValidity();
      if(!valid) {
        errors++;
      }
    }

    if(errors == 0) {
      $(".page"+val).hide();
      var v = val+1;
      $(".page"+v).removeClass("d-none");
      var children = $(".listing-header").children();
      children[val + 1].classList.add("done");
      $("#header-counter").val(v);
      $(".back-button").removeClass("d-none");
    }

    if(val == 3 && errors == 0) {
      $(".next-button").addClass("d-none");
      $('.submit-button').removeClass("d-none");

      $("#conf-title").text($("#item-name").val());
      $("#conf-category").text($("#category").val());
      $("#conf-sub-cat").text($("#sub-category").val());
      $("#conf-desc").text($("#description").val());
      $("#conf-condition").text($("#item-condition").val());
      $("#conf-age").text($("#age").val());
      $("#conf-phone").text($("#phone").val());
      // $("#conf-daily").text($("#daily-aed").val());
      // $("#conf-weekly").text($("#weekly-aed").val());
      // $("#conf-monthly").text($("#monthly-aed").val());
      if($("#avilable-for-sale").is(':checked')) {
        $("#conf-avail").text("Available for sale");
        $("#conf-sale-price").text("AED-" + $("#sale-price").val());
        $("#sale-price-h4").show();
      }
      else {
        $("#avilable-for-sale").prop('disabled', true);
        $("#conf-avail").text("Not available for sale");
      }

      $("#conf-flat").text($("#location-1").val());
      $("#conf-building").text($("#location-2").val());
      $("#conf-street").text($("#street").val());
      $("#conf-area").text($("#area").val());
      $("#conf-city").text($("#city").val());
      $("#conf-neighborhood").text($("#neighbourhood").val());

      if(rental > 0) {
        $("#rental-label").show();
        var htm = '';
        if(!!$("#daily-aed").val()) {
          // $("#rental-area").html('<div class="col-md-4"><div class="rental-rate" id="daily-label">AED-'+$("#daily-aed").val()+'<span id="conf-daily"></span><br><label class="font-normal">Per day</label></div></div>');
          htm += '<div class="col-md-4"><div class="rental-rate" id="daily-label">AED-'+$("#daily-aed").val()+'<span id="conf-daily"></span><br><label class="font-normal">Per day</label></div></div>';
        }
        if(!!$("#weekly-aed").val()) {
          // $("#rental-area").html('<div class="col-md-4"><div class="rental-rate" id="weekly-label">AED-'+$("#weekly-aed").val()+'<span id="conf-weekly"></span><br><label class="font-normal">Per week</label></div></div>');
          htm += '<div class="col-md-4"><div class="rental-rate" id="weekly-label">AED-'+$("#weekly-aed").val()+'<span id="conf-weekly"></span><br><label class="font-normal">Per week</label></div></div>';
        }
        if(!!$("#monthly-aed").val()) {
          // $("#rental-area").html('<div class="col-md-4"><div class="rental-rate" id="monthly-label">AED-'+$("#monthly-aed").val()+'<span id="conf-monthly"></span><br><label class="font-normal">Per month</label></div></div>');
          htm += '<div class="col-md-4"><div class="rental-rate" id="monthly-label">AED-'+$("#monthly-aed").val()+'<span id="conf-monthly"></span><br><label class="font-normal">Per month</label></div></div>';
        }
        $("#rental-area").html(htm);
      }
      else {
        $("#rental-label").hide();
      }

      if(!!$("#cash-deposit").val()) {
        $("#cash-deposit-label").show();
        $("#conf-cash").text("AED-" + $("#cash-deposit").val());
      }
      else {
        $("#cash-deposit-label").hide();
        $("#conf-cash").hide();
      }
      
      var imgs = $("#image-gal div img");
      $(".img-close").remove();
      for(var cc = 0; cc < imgs.length; cc++) {
        if($("#prod-img").attr("src") == imgs[cc].src) {
          var p_span = $("#image-gal div span.prim-label");
          if(p_span.length > 0) {
            p_span.remove();
          }
          var sp = document.createElement("SPAN");
          sp.style.background = "#2cb7aa";
          sp.style.fontSize = "14px";
          sp.style.padding = "3px 5px";
          sp.id = "p-label2";
          sp.innerText = "Primary photo";
          sp.style.display = "block";
          sp.style.width = "100px";
          sp.style.position = "absolute";
          sp.style.marginTop = "-4%";
          sp.style.color = "#ffffff";
          sp.className = "prim-label";

          imgs[cc].after(sp); 
        }
        else {
          var cl = document.createElement("SPAN");
          cl.innerHTML = "&#10005";
          cl.style.position = "absolute";
          cl.style.background = "black";
          cl.style.color = "#ffffff";
          cl.style.width = "26px";
          cl.style.borderRadius = "50%";
          cl.style.height = "26px";
          cl.style.display = "block";
          cl.style.marginLeft = "12%";
          cl.style.fontWeight = "bold";
          cl.className = "img-close";

          cl.onclick = function() {
            var nxt = $(this).next();
            var hidden_images = $("input[name='images[]']");
            var parent = $(this).parent();

            var form = new FormData();
            form.append('filename', nxt[0].id);
            form.append('mode', 'create');
            form.append('_token', '<?php echo csrf_token(); ?>');

            $.ajax({
              type: 'POST',
              url: "/products/delete/image",
              data: form,
              contentType: false,
              processData: false,
              success: function(response) {
                for(var z = 0; z < hidden_images.length; z++) {
                  if(nxt[0].id == hidden_images[z].value) {
                    hidden_images[z].previousSibling.remove();
                    hidden_images[z].remove();
                  }
                }
                parent[0].remove();
              },
              error: function(response) {
                console.log(response);
              }
            });
          }

          imgs[cc].before(cl);
        }
      }
    }
  });

  $(".back-button").on('click', function(){
    var val = parseInt($("#header-counter").val());
    var children = $(".listing-header").children();

    if(val != 0) {
      children[val].classList.remove("done");
      $(".page"+val).addClass("d-none");
      var v = val-1;
      $(".page"+v).show();
      $("#header-counter").val(v);
    }
    else {
      $(".back-button").addClass("d-none");
    }

    if(val == 4) {
      $(".submit-button").addClass("d-none");
      $(".next-button").removeClass("d-none");
    }

    if(val == 1) {
      $(".back-button").addClass("d-none");
    }
  });

  $(".close").click(function(){
    $(".alert").remove();
  });

  $(".conf-modal").on("click", function(){
    $("#confirmation").modal("show");
  });

  function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31
      && (charCode < 48 || charCode > 57))
       return false;

    return true;
  }

  $("#product-image").on("change", function(){
    $("#image-req").hide();
    var fd = new FormData();
    var files = $(this)[0].files[0];
    var allowed = ["image/jpeg", "image/png"];
    fd.append('_token', '<?php echo csrf_token(); ?>');
    fd.append('product_image', files);
    if(allowed.includes(files.type)) {
      $.ajax({
        type: 'POST',
        url: "/products/ajax_upload",
        data: fd,
        contentType: false,
        processData: false,
        success: function(data) {
          var filename = JSON.parse(data);
          if($("#prod-img").length) {
            var im = document.createElement("IMG");
            var img = document.createElement("IMG");
            var img_gal = document.createElement("IMG");
            var div = document.createElement("DIV");
            var div2 = document.createElement("DIV");
            var span = document.createElement("SPAN");
            var input = document.createElement("INPUT");

            im.setAttribute("src", '<?php echo url('uploads/'); ?>'+'/'+filename);
            im.setAttribute("width", '200');
            im.className = "mt-1";

            img.setAttribute("src", '<?php echo url('uploads/'); ?>'+'/'+filename);
            img.setAttribute("height", "100");
            img.setAttribute("width", "100");
            img.style.marginRight = "10px";
            img.className = "mt-1";

            img_gal.setAttribute("src", '<?php echo url('uploads/'); ?>'+'/'+filename);
            img_gal.setAttribute("height", "100");
            img_gal.setAttribute("width", "100");
            img_gal.style.marginRight = "10px";
            img_gal.className = "mt-1";
            img_gal.id = filename;

            span.style.background = "#2cb7aa";
            span.style.fontSize = "14px";
            span.style.padding = "3px 5px";
            span.id = "p-label";
            span.innerText = "Primary photo";
            span.style.display = "block";
            span.style.width = "100px";
            span.style.position = "absolute";
            span.style.color = "#ffffff";
            span.style.marginTop = "-6%";

            input.type = "hidden";
            input.name = "images[]";
            input.value = filename;

            img.onclick = function(){
              var img_file = $(this).next("input").val();
              $("#primary-img").val(img_file);
              $(".listing-image-upload img").attr('src', this.src);
              $("#p-label").remove();
              $(this).after(span);
              $("#prod-img").attr('src', '<?php echo url('uploads/'); ?>'+'/'+filename);
            }

            $(".listing-image-upload").html(im);
            $("#prod-img").attr('src', '<?php echo url('uploads/'); ?>'+'/'+filename);

            div.appendChild(img);
            // div.appendChild(span);
            div.appendChild(input);

            div2.appendChild(img_gal);

            $("#image-gallery-wrapper").append(div);
            $("#image-gal").append(div2);
            
            $("#primary-img").val(filename);
            $(".img-err").addClass("d-none");

            var elems = $("#image-gallery-wrapper div img");
            
            var pspan = $("#image-gallery-wrapper div span");
            for(var u = 0; u < elems.length; u++) {
              if(img.src == elems[u].src) {
                if(pspan.length > 0) {
                  pspan.remove();
                }
                elems[u].after(span);
              }
            }
          }
        },
        error: function(data) {
          console.log("error");
        }
      });
    }
    else {
      $(".img-err").removeClass("d-none");
    }

  });

  $("input[name=available_for_sale]").on("change", function(){
    if($(this).is(':checked')) {
      $("input[name=sale_price]").attr("required", "required");
      $("#sale-req").show();
      $("#sale-price").prop("disabled", false);
    }
    else {
      $("#sale-price").val("");
      $("#sale-price").prop("disabled", true);
      $("input[name=sale_price]").removeAttr("required");
      $("#sale-req").hide();
    }
  });

  $("#daily-check").on("change", function(){
    if($(this).is(':checked')) {
      $("#daily-aed").attr("required", "required");
      $("#daily-req").show();
      $("#daily-aed").prop("disabled", false);
      rental++;
    }
    else {
      $("#daily-aed").val("");
      $("#daily-aed").prop("disabled", true);
      $("#daily-aed").removeAttr("required");
      $("#daily-req").hide();
      rental--;
    }
  });

  $("#weekly-check").on("change", function(){
    if($(this).is(':checked')) {
      $("#weekly-aed").attr("required", "required");
      $("#weekly-req").show();
      $("#weekly-aed").prop("disabled", false);
      rental++;
    }
    else {
      $("#weekly-aed").val("");
      $("#weekly-aed").prop("disabled", true);
      $("#weekly-aed").removeAttr("required");
      $("#weekly-req").hide();
      rental--;
    }
  });

  $("#monthly-check").on("change", function(){
    if($(this).is(':checked')) {
      $("#monthly-aed").attr("required", "required");
      $("#monthly-req").show();
      $("#monthly-aed").prop("disabled", false);
      rental++;
    }
    else {
      $("#monthly-aed").val("");
      $("#monthly-aed").prop("disabled", true);
      $("#monthly-aed").removeAttr("required");
      $("#monthly-req").hide();
      rental--;
    }
  });

  $(document).ready(function(){
    var json = '<?php echo $json; ?>';
    json = JSON.parse(json);

    // for category
    for(var j of Object.keys(json)) {
      var opt = document.createElement("OPTION");
      opt.value = j;
      opt.innerHTML = j;
      document.getElementById("category").appendChild(opt);
    }

    // for sub-category
    $("#category").on("change", function(){
      $(this).next("small").hide();
      var val = this.value;
      $("#sub-category").html('');
      $("#sub-category").next("small").show();
      $("#item-type").html('');
      $("#item-type").next("small").show();
      $("#sub-category").append("<option selected disabled>Select Sub-category</option>");
      for(var j of Object.keys(json[val])) {
        var opt = document.createElement("OPTION");
        opt.value = j;
        opt.innerHTML = j;
        document.getElementById("sub-category").appendChild(opt);
      }
    });

    // for item-type
    $("#sub-category").on("change", function(){
      $(this).next("small").hide();
      var cat = $("#category").val();
      var sub = this.value;
      $("#item-type").html('');
      $("#item-type").append("<option selected disabled>Item type</option>");
      for(var j of Object.keys(json[cat][sub])) {
        var opt = document.createElement("OPTION");
        opt.value = json[cat][sub][j];
        opt.innerHTML = json[cat][sub][j];
        document.getElementById("item-type").appendChild(opt);
      }
    });

    // Neighborhood
    var city = [];
      city["Abu Dhabi"] = [
        "ADAFZA",
        " AUH Int'l Airport Terminal 1",
        "Abu Dhabi Airport Freezone",
        "Abu Dhabi City Centre",
        " Abu Dhabi Falcon Hospital",
        " Abu Dhabi Formula 1",
        "Abu Dhabi Gate City",
        " Abu Dhabi Golf &amp; Equestrian Club",
        " Abu Dhabi Golf Club &amp; Spa",
        "Abu Dhabi Industrial City",
        "Abu Dhabi International Airport",
        "Abu Dhabi Island",
        " Abu Dhabi Mall",
        " Abu Dhabi National Exhibition Centre",
        " Abu Dhabi University",
        "Airport Road",
        "Al  Ghadeer Village",
        "Al Aman",
        "Al Bahia",
        " Al Bahia Park",
        "Al Bandar",
        "Al Bateen",
        "Al Bateen",
        "Al Bateen Airport",
        " Al Bateen Mall",
        "Al Bateen Villas",
        "Al Dana",
        "Al Dhafrah",
        "Al Fahid",
        "Al Falah City",
        "Al Faqa",
        "Al Ghadeer",
        " Al Ghaf Park",
        "Al Ghazal Golf Club",
        "Al Gurm Mangroves",
        "Al Hisn",
        "Al Ittihad",
        "Al Jurf",
        "Al Karamah",
        "Al Khaleej Al Arabi Street",
        "Al Khalidiyah",
        "Al Khubeirah",
        "Al Lissaily",
        "Al Madina Al Riyadiya",
        "Al Mafraq",
        " Al Mafraq Hospital",
        "Al Manaseer",
        "Al Manhal",
        "Al Maqtaa",
        "Al Maqtaa Village ",
        "Al Markaz",
        "Al Markaziyah",
        "Al Marsa Residences",
        "Al Marsa Villas",
        "Al Maryah Island",
        "Al Matar",
        "Al Mina",
        "Al Mirfa",
        "Al Muneera",
        "Al Muroor",
        "Al Musalla",
        "Al Mushrif",
        "Al Muzoon",
        "Al Nahda (Abu Dhabi)",
        "Al Nahyan",
        "Al Nahyan military Camp",
        "Al Najda",
        "Al Qubesat",
        "Al Qurayyah Island",
        "Al Qurm",
        "Al Qurm Gardens",
        "Al Raha Beach",
        "Al Raha Gardens",
        "Al Raha Lofts",
        " Al Raha Shopping Mall",
        "Al Rahba",
        "Al Ras Al Akhdar",
        "Al Razeem",
        "Al Reef",
        "Al Reef 2",
        "Al Reef Downtown",
        "Al Reef Villas",
        "Al Reem Island",
        "Al Rehhan",
        "Al Rowdah",
        "Al Rumaila",
        "Al Safarat",
        " Al Safeer Mall",
        "Al Salam street",
        "Al Samha",
        "Al Seef",
        "Al Shaleela",
        "Al Shamkha",
        "Al Shamkha South",
        "Al Shatie",
        "Al Shawamekh",
        "Al Thurayya",
        " Al Wahda Mall",
        "Al Wahdah",
        "Al Wathba",
        "Al Zaab",
        "Al Zahiya",
        "Al Zahraa",
        "Al Zeina",
        "Arabian Village",
        "Arzanah",
        "As Suwwah Island",
        "Bain Al Jisrain",
        "Balrmmd Island",
        "Bani Yas",
        "Baniyas City",
        "Belghailam Island Cluster",
        "Between two Bridges",
        "Bisrat Fahid Island Cluster",
        "Bloom Gardens",
        "Capital Centre",
        "Capital Plaza",
        "City of Lights",
        "Coconut Island",
        "Contemporary Village",
        "Corniche",
        "Danet Abu Dhabi",
        "Defense Road",
        "Delma Street",
        "Desert Village",
        "Eastern Road",
        "Electra",
        " Emirates Palace",
        "Futaysi Island",
        " Gargash Round About",
        "Gate District",
        "Ghantoot",
        "Golf Gardens",
        " Guggenheim &amp; Louvre Museums",
        "HIDD Al Saadiyat",
        "Hadbat Al Zafranah",
        " Hamdan Centre",
        "Hills Abu Dhabi",
        "Hodariyat Island",
        "Hydra City",
        "Hydra Village",
        "ICAD 3",
        " ICAD Main Gate",
        "Jawaher",
        " Khalidiyah Mall",
        "Khalifa City A",
        "Khalifa City C",
        "Khalifa Street",
        "Khor Al Raha",
        " Lifeline Hospital",
        "Liwa Street",
        "Liwa Village",
        "Lulu Island",
        "M-12",
        "M-13",
        "M-14",
        "M-15",
        "M-16",
        "M-17",
        "M-19",
        "M-20",
        "M-38",
        "M-39",
        "M-40",
        "M-42",
        "M-43",
        "M-45",
        "M-46",
        "M21",
        "ME-10",
        "ME-11",
        "ME-9",
        "MN-5",
        "MN-6",
        "Madinat Zayed",
        "Madinat Zayed City",
        " Madinat Zayed Shopping Centre",
        "Mamsha Al Saadiyat",
        "Mangrove Area North",
        " Marina Mall",
        "Marina Square",
        "Marina Village",
        "Masdar City",
        "Mediterranean Village",
        " Mina Mall",
        "Mohammed Bin Zayed City",
        "Motor World",
        "Mushrif Gardens",
        "Mussafah",
        "Mussafah Community",
        "Mussafah East",
        "Mussafah Industrial Area",
        "Mussafah Residential &amp; Commercial Area",
        "Najmat",
        " Najmat Reem Marina",
        "Nareel Island",
        "New Shahama",
        "Nudra",
        "Nurai Island",
        "Officers City",
        "Officers Club Area",
        " Police Traffic Dept",
        "Qasr Al Bahr",
        "Qasr El Shatie",
        "Qattouf",
        "Rowdhat",
        "Ruwais",
        "Saadiyat Beach",
        "Saadiyat Beach Residences",
        "Saadiyat Beach Villas",
        "Saadiyat Beach Villas 2",
        "Saadiyat Beach Villas 3",
        "Saadiyat Beach Villas 4",
        "Saadiyat Cultural District",
        "Saadiyat Island",
        "Saadiyat Marina",
        "Saadiyat Retreat",
        "Saadiyat South Beach Promenade",
        "Saadiyat Wetlands Reserve",
        "Samaliyah Island",
        "Sas Al Nakhl Village",
        "Sas An Nakhl Island",
        "Shabiya 12",
        " Shahama Market",
        "Shakhbout City (Khalifa City B)",
        "Shams Abu Dhabi",
        " Sheikh Khalifa Park",
        " Sheikh Zayed Grand Mosque",
        "Soho Square",
        "South Hodariyat Island",
        "Tamouh",
        "Tamouh CBD",
        "The Boardwalk Residence",
        "Tourist Club Area",
        "Umm Al Nar",
        "Umm Yifenah Island",
        "Yas Acres",
        "Yas Circuit &amp; Marina",
        "Yas Entertainment District",
        "Yas Island",
        "Yas Northern Marina Village",
        "Yas Northern Residential &amp; Golf",
        "Yas Southern Marina Village",
        "Yas Village",
        "Yas Waterfront Resorts &amp; Links",
        "Yas West",
        "Zayed Bay",
        "Zayed Sports City",
        "Zone 1",
        "Zone 1",
        "Zone 12",
        "Zone 13",
        "Zone 14",
        "Zone 15",
        "Zone 16",
        "Zone 17",
        "Zone 18",
        "Zone 19",
        "Zone 2",
        "Zone 2",
        "Zone 20",
        "Zone 21",
        "Zone 22",
        "Zone 23",
        "Zone 24",
        "Zone 25",
        "Zone 26",
        "Zone 27",
        "Zone 29",
        "Zone 3",
        "Zone 3",
        "Zone 30",
        "Zone 31",
        "Zone 32",
        "Zone 33",
        "Zone 34",
        "Zone 4",
        "Zone 4",
        "Zone 5",
        "Zone 5",
        "Zone 6",
        "Zone 6",
        "Zone 7",
        "Zone 7",
        "Zone 8",
        "Zone 8",
        "Zone 9"
      ];

      city["Ajman"] = [
        "Ajman Auto Market",
        "Ajman Global City",
        "Ajman Industrial Area",
        "Ajman Industrial Area 1",
        "Ajman Industrial Area 2",
        "Ajman Uptown",
        "Al Alia",
        "Al Bustan",
        "Al Butain",
        "Al Hamriya",
        "Al Helio",
        "Al Helio 1",
        "Al Helio 2",
        "Al Jarrf",
        "Al Jurf",
        "Al Jurf Industrial",
        "Al Manama",
        "Al Mowaihat",
        "Al Mowaihat 1",
        "Al Mowaihat 2",
        "Al Mowaihat 3",
        "Al Nakhil",
        "Al Nuaimia",
        "Al Nuaimia 1",
        "Al Nuaimia 2",
        "Al Nuaimia 3",
        "Al Owan",
        "Al Rashidiya",
        "Al Rawda 1",
        "Al Rawda 2",
        "Al Rawda 3",
        "Al Rumailah",
        "Al Sawan",
        "Al Yasmeen",
        "Al Zahra",
        "Al Zahya",
        "Al Zorah",
        "Corniche Ajman",
        "Emirates City",
        "Garden City",
        "Hamidiya",
        "Masfout",
        "Mushairef",
        "Paradise Lakes Towers",
        "Safia Island",
        "Sheikh Khalifa Bin Zayed"
      ];

      city["Al Ain"] = [
        "Abu Huraybah",
        "Abu Krayyah",
        "Abu Samrah",
        "Al Agabiyya",
        "Al Bateen",
        "Al Dhahra",
        "Al Falaj Hazzaa",
        "Al Foah",
        "Al Grayyeh",
        "Al Haiyir",
        "Al Hili",
        "Al Jimi",
        "Al Khabisi",
        "Al Khazna",
        "Al Maqam",
        "Al Masoudi",
        "Al Muraba'a",
        "Al Mutarad",
        "Al Mutawaa",
        "Al Muwaiji",
        "Al Niyadat",
        "Al Oyoun Village",
        "Al Qattara",
        "Al Quaa",
        "Al Rawdha",
        "Al Salamat",
        "Al Sinaiyah",
        "Al Tawia",
        "Al Wagan",
        "Al Yahar",
        "Al Zahir",
        "Asharij",
        "Gafat Al Nayyar",
        "Jabel Al Hafeet",
        "Mezyad",
        "Nahel",
        "Remah",
        "Shwaib",
        "Um El Zumool",
        "Um Ghafa",
        "Wahat Al Zaweya",
        "Zakher"
      ];

      city["Dubai"] = [
        "29 Burj Boulevard",
        "A La Carte Villas",
        "API Jumeirah Villas",
        "Abbey Crescent",
        "Abu Hail",
        "Acacia",
        "Acacia Avenues",
        "Academic City",
        "Acuna",
        "Adria Villas",
        "Afnan District",
        "Aknan Villas",
        "Aknan Villas",
        "Aknan Villas",
        "Akoya Oxygen",
        "Akoya Play",
        "Akoya Selfie",
        "Al Abraj Street",
        "Al Alka",
        "Al Arta",
        "Al Awir",
        "Al Badaa",
        "Al Badi Complex",
        "Al Baraha",
        "Al Barari",
        "Al Barari Villas",
        "Al Barsha",
        "Al Barsha 1",
        "Al Barsha 2",
        "Al Barsha 3",
        "Al Barsha South",
        "Al Barsha South 1",
        "Al Barsha South 2",
        "Al Barsha South 3",
        "Al Barsha Twin Towers",
        "Al Burooj",
        "Al Burooj Residence V",
        "Al Burooj Residence VII",
        "Al Buteen",
        "Al Daghaya",
        "Al Dhafrah",
        "Al Dhafrah",
        "Al Fattan Marine Towers",
        "Al Furjan",
        "Al Furjan Villas",
        "Al Furjan Villas Phase 2",
        "Al Ghaf",
        "Al Ghozlan",
        "Al Ghurair City Mall",
        "Al Habtoor City",
        "Al Habtoor Polo Resort &amp; Club - The Residences",
        "Al Jaddaf",
        "Al Jafiliya",
        "Al Jaz",
        "Al Khabaisi",
        "Al Khail Gate Phase 1",
        "Al Khail Gate Phase 2",
        "Al Khail Heights",
        "Al Khawaneej",
        "Al Kifaf",
        "Al Maha Towers",
        "Al Mahra",
        "Al Majara Towers",
        "Al Mamzar",
        "Al Manara",
        "Al Mankhool",
        "Al Mass Villas",
        "Al Mizhar",
        "Al Mizhar 1",
        "Al Murar",
        "Al Murooj Complex",
        "Al Muteena",
        "Al Nahda (Dubai)",
        "Al Nahda 1",
        "Al Nahda 2",
        "Al Nakheel",
        "Al Quoz",
        "Al Quoz 1",
        "Al Quoz 2",
        "Al Quoz 3",
        "Al Quoz 4",
        "Al Quoz Industrial Area 1",
        "Al Quoz Industrial Area 2",
        "Al Quoz Industrial Area 3",
        "Al Quoz Industrial Area 4",
        "Al Quoz Industrial District",
        "Al Qusais",
        "Al Qusais 1",
        "Al Qusais 2",
        "Al Qusais Industrial 1",
        "Al Qusais Industrial 2",
        "Al Qusais Industrial 3",
        "Al Qusais Industrial 4",
        "Al Qusais Industrial 5",
        "Al Raffa",
        "Al Rahaba Residences",
        "Al Ramth",
        "Al Ramth 21",
        "Al Ramth 37",
        "Al Ramth 41",
        "Al Ramth 45",
        "Al Ras",
        "Al Reem 1",
        "Al Reem 2",
        "Al Reem 3",
        "Al Rigga",
        "Al Sabkha",
        "Al Safa",
        "Al Safa 1",
        "Al Safa 2",
        "Al Sahab Tower",
        "Al Salam Townhouses",
        "Al Samar",
        "Al Shafar Village",
        "Al Sidir",
        "Al Sufouh",
        "Al Thamam",
        "Al Thammam 12",
        "Al Thammam 18",
        "Al Thammam 47",
        "Al Thammam 55",
        "Al Thammam 7",
        "Al Thayyal",
        "Al Thayyal 2",
        "Al Twar",
        "Al Twar 1",
        "Al Twar 2",
        "Al Twar 3",
        "Al Waha Villas",
        "Al Warqaa",
        "Al Warqaa 1",
        "Al Warqaa 2",
        "Al Warqaa 3",
        "Al Warqaa 4",
        "Al Warqaa 5",
        "Al Warsan",
        "Al Warsan 2",
        "Al Warsan 3",
        "Al Warsan 4",
        "Al Wasl",
        "Al Wasl",
        "Al Wasl Villas",
        "Al Wuheida",
        "Al Yousuf Towers",
        "Albizia",
        "Alma 1",
        "Alma 2",
        "Alma Townhomes",
        "Alvorada",
        "Alvorada 2",
        "Alvorada 3",
        "Alvorada 4",
        "Amaranta",
        "Amargo",
        "Amazonia",
        "American Hospital",
        "Amora Golf Verde",
        "Amsa",
        "Amwaj",
        "Anantara Residences",
        "Aqua Dunya",
        "Aquilegia",
        "Arabella Townhouses",
        "Arabella Townhouses 1",
        "Arabella Townhouses 2",
        "Arabella Townhouses 3",
        "Arabian Crown",
        "Arabian Ranches",
        "Arabian Ranches 2",
        "Arabian Ranches 3",
        "Arjan",
        "Arno",
        "Artesia",
        "Aster",
        "Atlantis The Palm",
        "Atlas Compound",
        "Aura",
        "Aurum Villas",
        "Aurum Villas",
        "Aurum Villas",
        "Aurum Villas",
        "Aurum Villas",
        "Autumn",
        "Avenue Residence",
        "Axis Residence",
        "Ayal Nasir",
        "Aykon City",
        "Azalea",
        "BLVD Crescent",
        "BLVD Heights",
        "BVLGARI Resort and Residences Dubai",
        "Bahar",
        "Balqis Residence Villas",
        "Baniyas Square",
        "Barsha Heights (Tecom)",
        "Barton House",
        "Basswood",
        "Bawadi",
        "Bay Central",
        "Bay Square",
        "Bayti 33",
        "Beach Vista",
        "Belgravia Ellington",
        "Bella Casa",
        "Bellevue Towers",
        "Bennett House",
        "Bliss",
        "Bloomingdale Townhouses",
        "Bluewaters",
        "Bluewaters Residences",
        "Boulevard Central",
        "Boulevard Central Towers",
        "Boulevard Plaza Towers",
        "Bristol Towers",
        "Brookfield",
        "Brookfield 1",
        "Brookfield 2",
        "Brookfield 3",
        "Bungalows Area",
        "Bur Dubai",
        "Burj Al Arab Hotel",
        "Burj Khalifa Area",
        "Burj Khalifa Tower",
        "Burj Park",
        "Burj Place",
        "Burj Residences",
        "Burj Views",
        "Burj Vista",
        "Burjuman Mall",
        "Business Bay",
        "Business Bay Bridge",
        "Business Park Motor City",
        "CASA at Arabian Ranches",
        "CBD (Central Business District)",
        "Cadi Residences",
        "Caesars Bluewaters Dubai",
        "Calida",
        "Camelia",
        "Canal Cove Frond A",
        "Canal Cove Frond B",
        "Canal Cove Frond C",
        "Canal Cove Frond D",
        "Canal Cove Frond E",
        "Canal Cove Frond F",
        "Canal Cove Frond G",
        "Canal Cove Frond H",
        "Canal Cove Frond I",
        "Canal Cove Frond J",
        "Canal Cove Frond K",
        "Canal Cove Frond L",
        "Canal Cove Frond M",
        "Canal Cove Frond N",
        "Canal Cove Frond O",
        "Canal Cove Frond P",
        "Canal Cove Villas",
        "Canal Residence",
        "Canal Villas",
        "Capital Bay",
        "Carmen",
        "Casa Dora",
        "Casa Familia",
        "Casa Flores",
        "Casa Viva",
        "Cassia at the Fields",
        "Cedre Villas",
        "Centaury",
        "Central Park Tower",
        "Century Mall",
        "Champions Towers",
        "Cherrywoods",
        "China Cluster",
        "Churchill Towers",
        "City Oasis",
        "City Walk",
        "City of Arabia",
        "Claren Towers",
        "Claret",
        "Claverton House",
        "Clock Tower",
        "Club Villas at Dubai Hills",
        "Corniche Deira",
        "Coursetia",
        "Creek Golf &amp; Yacht Club",
        "Creek Park",
        "Culture Village",
        "DAMAC Hills (Akoya by DAMAC)",
        "DAMAC Towers by Paramount",
        "DAMAC Towers by Paramount",
        "DANIA DISTRICT",
        "DEC Towers",
        "DIFC",
        "DIFC Gate Building",
        "DIFC Towers",
        "DMC, DIC &amp; KV Freezones",
        "DREAMZ",
        "Daria Island",
        "Deema",
        "Deema 1",
        "Deema 2",
        "Deema 3",
        "Deema 4",
        "Deira",
        "Deira City Centre Mall",
        "Desert Palm",
        "Diamond Arch",
        "Diamond Views",
        "Dickens Circus",
        "Discovery Gardens",
        "District 1",
        "District 2",
        "District 3",
        "District 4",
        "District 5",
        "District 6",
        "District 7",
        "District 7",
        "District 7",
        "District 8",
        "District 9",
        "District One",
        "District One Mansions",
        "District One Villas",
        "Down Town Jebel Ali",
        "Downtown Dubai",
        "Dragon City",
        "Dragon Mart",
        "Dragon Towers",
        "Dream Towers",
        "Dubai Airport Free Zone",
        "Dubai Autodrome",
        "Dubai Creek Golf Club",
        "Dubai Creek Harbour",
        "Dubai Design District",
        "Dubai Festival City",
        "Dubai Harbour",
        "Dubai Healthcare City",
        "Dubai Hills",
        "Dubai Hills Estate",
        "Dubai Hills Grove",
        "Dubai Hills View",
        "Dubai Hospital",
        "Dubai Industrial Park",
        "Dubai International Airport",
        "Dubai International Airport",
        "Dubai Internet City",
        "Dubai Investment Park",
        "Dubai Investment Park 1",
        "Dubai Investment Park 2",
        "Dubai Land",
        "Dubai Lifestyle City",
        "Dubai Marina",
        "Dubai Marina Towers (Emaar 6 Towers)",
        "Dubai Media City",
        "Dubai Museum",
        "Dubai Outlet Mall",
        "Dubai Outsource Zone",
        "Dubai Parks and Resorts",
        "Dubai Production City (IMPZ)",
        "Dubai Residence Complex",
        "Dubai Science Park",
        "Dubai Silicon Oasis",
        "Dubai South",
        "Dubai South 1",
        "Dubai Sports City",
        "Dubai Studio City",
        "Dubai Style Villas",
        "Dubai Taj Mahal",
        "Dubai Tennis Stadium",
        "Dubai World Central",
        "Dubai World Trade Centre",
        "Duraar Towers",
        "Earth",
        "Eden",
        "Eden Apartments",
        "Eden The Valley",
        "Elite Sports Residence",
        "Emaar Beachfront",
        "Emaar Business Park",
        "Emaar Business Park",
        "Emaar South",
        "Emirates Financial Towers",
        "Emirates Gardens 1",
        "Emirates Gardens 2",
        "Emirates Golf Club",
        "Emirates Golf Club Residences",
        "Emirates Hills",
        "Emirates Towers",
        "Empire Heights",
        "England Cluster",
        "Entertainment Foyer (Contemporary Clusters)",
        "Entertainment Foyer (European Clusters)",
        "Entertainment Foyer (Islamic Clusters)",
        "Entertainment Foyer (Mediterranean Clusters)",
        "Entertainment Foyer (Oasis Clusters)",
        "Esmeralda",
        "Eternity",
        "Ettore 971 Bugatti Style Villas",
        "Executive Towers",
        "Expo Golf Villas",
        "Fairway Vistas",
        "Falcon City of Wonders",
        "Family Villas",
        "Fendi Styled Villas",
        "Fiora Golf Verde",
        "Fire",
        "Flame Tree Ridge",
        "Floating Bridge",
        "Forat",
        "Forbidden City",
        "Forest Villas",
        "Forte",
        "Four Seasons Golf Club",
        "Foxhill",
        "France Cluster",
        "Garden East Apartments",
        "Garden Hall (Contemporary Clusters)",
        "Garden Hall (European Clusters)",
        "Garden Hall (Islamic Clusters)",
        "Garden Hall (Mediterranean Clusters)",
        "Garden Hall (Oasis Clusters)",
        "Garden Hall (Tropical Clusters)",
        "Garden Homes",
        "Garden Homes Frond A",
        "Garden Homes Frond B",
        "Garden Homes Frond C",
        "Garden Homes Frond D",
        "Garden Homes Frond E",
        "Garden Homes Frond F",
        "Garden Homes Frond G",
        "Garden Homes Frond H",
        "Garden Homes Frond I",
        "Garden Homes Frond J",
        "Garden Homes Frond K",
        "Garden Homes Frond L",
        "Garden Homes Frond M",
        "Garden Homes Frond N",
        "Garden Homes Frond O",
        "Garden Homes Frond P",
        "Garden View Villas",
        "Garden West Apartments",
        "Gardenia Townhomes",
        "Gardenia Villas",
        "Garhoud",
        "Garhoud Bridge",
        "Gate Precinct",
        "Gateway Towers",
        "German Sports Towers",
        "Ghadeer 1",
        "Ghadeer 2",
        "Ghadeer Community",
        "Ghantoot Race Course and Polo Club",
        "Ghoroob",
        "Glitz 3 by Danube",
        "Global Village",
        "Gold and Diamond Park",
        "Golden Mile",
        "Golden Wood Villas",
        "Golf City",
        "Golf Panorama",
        "Golf Place",
        "Golf Promenade",
        "Golf Promenade",
        "Golf Terrace",
        "Golf Terrace",
        "Golf Towers",
        "Golf Veduta",
        "Golf Vista",
        "Golf Vita",
        "Golfville",
        "Grand Boulevard",
        "Grand Horizon",
        "Grand Paradise",
        "Grand Paradise I",
        "Grand Paradise II",
        "Grand Views",
        "Grandeur Residences",
        "Greece Cluster",
        "Green Community",
        "Green Community East",
        "Green Community Market",
        "Green Community Motor City",
        "Green Community West",
        "Green Diamond Towers",
        "Hacienda",
        "Hajar Stone Villas",
        "Hamriya Port",
        "Hartland Gardenia",
        "Hartland Greens",
        "Hattan",
        "Hattan",
        "Hattan 1",
        "Hattan 2",
        "Hattan 3",
        "Hawthorne",
        "Hayat Townhouses",
        "Heaven",
        "Hor Al Anz",
        "Hor Al Anz East",
        "Hub-Golf Towers",
        "Hydra Twin Towers",
        "Ibn Batuta Mall",
        "Indigo Towers",
        "Indigo Ville 2",
        "Indigo Ville 4",
        "Indigo Ville 6",
        "International City",
        "International City Phase-2",
        "International Modern Hospital",
        "Iris Park Villas",
        "Italy Cluster",
        "J ONE",
        "JAFZA Jebel Ali Free Zone",
        "JAFZA Jebel Ali Free Zone",
        "JBR Jumeirah Beach Residence",
        "JLT Cluster A",
        "JLT Cluster B",
        "JLT Cluster C",
        "JLT Cluster D",
        "JLT Cluster E",
        "JLT Cluster F",
        "JLT Cluster G",
        "JLT Cluster H",
        "JLT Cluster I",
        "JLT Cluster J",
        "JLT Cluster K",
        "JLT Cluster L",
        "JLT Cluster M",
        "JLT Cluster N",
        "JLT Cluster O",
        "JLT Cluster P",
        "JLT Cluster Q",
        "JLT Cluster R",
        "JLT Cluster S (Green Lake Towers)",
        "JLT Cluster T",
        "JLT Cluster U (Al Seef Towers)",
        "JLT Cluster V",
        "JLT Cluster W",
        "JLT Cluster X (Jumeirah Bay Towers)",
        "JLT Cluster Y",
        "JLT Jumeirah Lake Towers",
        "JVC District 10",
        "JVC District 11",
        "JVC District 12",
        "JVC District 13",
        "JVC District 14",
        "JVC District 15",
        "JVC District 16",
        "JVC District 17",
        "JVC District 18",
        "JVC Jumeirah Village Circle",
        "JVT District 1",
        "JVT District 2",
        "JVT District 3",
        "JVT District 4",
        "JVT District 5",
        "JVT District 6",
        "JVT District 7",
        "JVT District 8",
        "JVT District 9",
        "JVT Jumeirah Village Triangle",
        "Janusia",
        "Jasmin",
        "Jebel Ali",
        "Jebel Ali Airport (planned)",
        "Jebel Ali Business Centre",
        "Jebel Ali Hills",
        "Jebel Ali Industrial Area",
        "Jebel Ali Industrial Area 1",
        "Jebel Ali Village",
        "Jenna",
        "Jenna Main Square",
        "Jouri Residences",
        "Joy",
        "Judi Residences",
        "Jumeirah",
        "Jumeirah 1",
        "Jumeirah 2",
        "Jumeirah 3",
        "Jumeirah Bay Island",
        "Jumeirah Beach Park",
        "Jumeirah Golf Estates",
        "Jumeirah Heights",
        "Jumeirah Islands",
        "Jumeirah Islands Townhouses",
        "Jumeirah Mosque",
        "Jumeirah Park",
        "Jumeirah Sands Villas",
        "Jumeirah Village",
        "Juniper",
        "Just Cavalli Villas",
        "Just Cavalli Villas",
        "Kamoon",
        "Karama",
        "Karama Park Area",
        "Kingdom of Sheba",
        "Knowledge Village",
        "La Mer",
        "La Quinta",
        "La Residencia Del Sol",
        "La Riviera Estate",
        "La Rosa",
        "Lake Allure",
        "Lake Almas East",
        "Lake Almas West",
        "Lake Apartments",
        "Lake Elucio",
        "Lakeview Apartments",
        "Layan",
        "Layan Community",
        "Le Grand Chateau",
        "Legacy Nova Villas",
        "Lehbab",
        "Lila",
        "Lilac Park",
        "Lime Tree Valley",
        "Living Legends",
        "Liwan",
        "Lootah Compound",
        "Lotus",
        "Lotus Park",
        "Luxury Villas Area",
        "MAG 5 Boulevard",
        "MAG Eye",
        "MIDTOWN",
        "Madinat Jumeirah Living",
        "Maeen",
        "Maeen 1",
        "Maeen 2",
        "Maeen 3",
        "Maeen 4",
        "Maeen 5",
        "Majan",
        "Maktoum Bridge",
        "Mall of the Emirates",
        "Mamzar Park",
        "Maple 1",
        "Maple 2",
        "Maple 3",
        "Maple at Dubai Hills Estate",
        "Marbella Village",
        "Marina Diamond",
        "Marina Gate",
        "Marina Promenade",
        "Marina Quays",
        "Marina Residence",
        "Marina Residences",
        "Marina View Tower",
        "Marina Walk",
        "Marina Wharf",
        "Marinascape",
        "Maritime City",
        "Marlowe House",
        "Marsa Al Arab",
        "Masakin Al Furjan",
        "Master View (Contemporary Clusters)",
        "Master View (European Clusters)",
        "Master View (Islamic Clusters)",
        "Master View (Mediterranean Clusters)",
        "Master View (Oasis Clusters)",
        "Master View (Tropical Clusters)",
        "Maysan Towers",
        "Mazaya Business Avenue",
        "Meadows Town Centre",
        "Media City",
        "Mediterranean Cluster",
        "Mercato Shopping Mall",
        "Metropolis Lofts",
        "Meydan",
        "Meydan Avenue",
        "Meydan Business Park",
        "Meydan City",
        "Meydan Gated Community",
        "Meydan Heights",
        "Meydan One (Azizi Riviera)",
        "Millenium Estates",
        "Millennium Estate",
        "Mimosa",
        "Mina Rashid",
        "Mira",
        "Mira 1",
        "Mira 2",
        "Mira 3",
        "Mira 4",
        "Mira 5",
        "Mira Oasis",
        "Mira Oasis 1",
        "Mira Oasis 2",
        "Mira Oasis 3",
        "Mirabella",
        "Mirabella 1",
        "Mirabella 2",
        "Mirabella 3",
        "Mirabella 4",
        "Mirabella 5",
        "Mirabella 6",
        "Mirabella 7",
        "Mirabella 8",
        "Mirador",
        "Mirador La Coleccion 1",
        "Mirador La Coleccion 2",
        "Mirador La Colección",
        "Mirdif",
        "Mirdif Hills",
        "Mirdif Villas",
        "Mogul Cluster - Building 148 to Building 202",
        "Mohammad Bin Rashid Boulevard",
        "Mohammed Bin Rashid Al Maktoum City",
        "Mohammed Bin Rashid Gardens",
        "Montgomerie Golf Club",
        "Montrose Residences",
        "Morocco Cluster",
        "Motor City",
        "Mudon",
        "Muhaisnah",
        "Muhaisnah 1",
        "Muhaisnah 2",
        "Muhaisnah 3",
        "Muhaisnah 4",
        "Mulberry",
        "Mulberry Mansions Villas",
        "Mulberry Park",
        "Murano Residences",
        "Muraqqabat",
        "Murjan",
        "Mushrif Park",
        "NASA Villas",
        "NSHAMA Town Square",
        "Nad Al Hamar",
        "Nad Al Shiba",
        "Nad Al Shiba Horse Racing",
        "Naif",
        "Nakheel Townhouses",
        "Nakheel Villas",
        "Naseem Townhouses",
        "Naseem Villas",
        "New Bridge Hills",
        "Nibras Oasis",
        "Niki Lauda Twin Towers",
        "Nirvana",
        "Noor Townhouses",
        "North Village",
        "North West Garden Apartments",
        "Norton Court",
        "OIA Residence",
        "Oasis Towers",
        "Oceana Residences",
        "Oceanic",
        "Odora",
        "Oia Residence",
        "Old Town Residences",
        "Oliva",
        "Olive Point",
        "One Central",
        "Opera District",
        "Opera Villas",
        "Orange Lake",
        "Orchid Park",
        "Oud Al Muteena",
        "Oud Metha",
        "Oxford Villas",
        "Pacific Village",
        "Pacifica",
        "Palm Deira",
        "Palm Jebel Ali",
        "Palm Jebel Ali Gate",
        "Palm Jebel Ali Gate",
        "Palm Views",
        "Palma",
        "Palmera",
        "Palmera 1",
        "Palmera 3",
        "Paloverde",
        "Paloverde",
        "Panorama at the Views",
        "Park Avenue",
        "Park Heights",
        "Park Heights 1",
        "Park Heights 2",
        "Park Island",
        "Park Lane",
        "Park Towers",
        "Park Villas",
        "Parkway Vistas",
        "Pearl Jumeirah",
        "Persia Cluster",
        "Phase 1",
        "Phase 2",
        "Platinum Residences",
        "Polo Homes",
        "Polo Residence",
        "Ponderosa",
        "Port Saeed",
        "Port de La Mer",
        "Prime Villas",
        "Primrose",
        "Queens Meadow",
        "Queue Point",
        "Rahat Villas",
        "Ras Al Khor",
        "Ras Al Khor Car Market",
        "Ras Al Khor Industrial",
        "Ras Al Khor Industrial 1",
        "Ras Al Khor Industrial 2",
        "Ras Al Khor Industrial 3",
        "Rasha",
        "Rashidia",
        "Rashidiya",
        "Redwood",
        "Redwood Avenue",
        "Redwood Park",
        "Reehan",
        "Reem",
        "Reem Community",
        "Regent House",
        "Remraam",
        "Residential City",
        "Richmond Villas",
        "Riggat Al Buteen",
        "Rimal",
        "Ritaj",
        "Rosa",
        "Roxana Residences",
        "Royal Golf Boutique Villas",
        "Royal Pearls",
        "Royal Residence",
        "Ruba",
        "Rufi Residency",
        "Rukan",
        "Russia Cluster",
        "Sadaf",
        "Safa Park",
        "Safeer Towers",
        "Saffron",
        "Safi",
        "Safi Townhouses",
        "Sahara Meadows",
        "Saheel",
        "Samara",
        "Sanctnary",
        "Sanctuary Falls",
        "Satwa",
        "Satwa Round About",
        "Savannah",
        "Seasons Community",
        "Sector E",
        "Sector H",
        "Sector HT",
        "Sector J",
        "Sector L",
        "Sector P",
        "Sector R",
        "Sector S",
        "Sector V",
        "Sector W",
        "Serena",
        "Serenia Residences",
        "Shaikh Hamdan Colony",
        "Shakespeare Circus",
        "Shams",
        "Sheikh Zayed Road",
        "Sherlock Circus",
        "Sherlock House",
        "Shindagha Tunnel",
        "Shoreline Apartments",
        "Shorooq",
        "Sidra Villas",
        "Sidra Villas 1",
        "Sidra Villas 2",
        "Sidra Villas 3",
        "Sienna Lakes",
        "Signature Villas",
        "Signature Villas Frond A",
        "Signature Villas Frond B",
        "Signature Villas Frond C",
        "Signature Villas Frond D",
        "Signature Villas Frond E",
        "Signature Villas Frond F",
        "Signature Villas Frond G",
        "Signature Villas Frond H",
        "Signature Villas Frond I",
        "Signature Villas Frond J",
        "Signature Villas Frond K",
        "Signature Villas Frond L",
        "Signature Villas Frond M",
        "Signature Villas Frond N",
        "Signature Villas Frond O",
        "Signature Villas Frond P",
        "Silver Springs",
        "Silverene",
        "Skycourts Towers",
        "Skyline",
        "Sobha Daffodil",
        "Sobha Hartland",
        "Sobha Hartland Villas",
        "Sobha Ivory Towers",
        "Somerset Mews",
        "Sonapur",
        "South Ridge",
        "South Village",
        "Southwest Apartments",
        "Spain Cluster",
        "Sparkle Towers",
        "Splendour Villas",
        "Spring",
        "Standpoint Towers",
        "Summer",
        "Sun",
        "Sunset Gardens",
        "Sycamore",
        "Tameem Villas",
        "Technology Park",
        "Terrace Apartments",
        "Terranova",
        "The 8",
        "The Address Residences Fountain Views",
        "The Address Sky View Towers",
        "The Aldea",
        "The Alef Residences",
        "The Centro",
        "The Crescent",
        "The Derby Residences",
        "The Dubai Mall",
        "The Fairmont Palm Residences",
        "The Fairways",
        "The Field",
        "The Flora",
        "The Fresh Market",
        "The Galleria Villas",
        "The Gardens",
        "The Gate Village",
        "The Greens",
        "The Heart of Europe",
        "The Hills",
        "The Hive",
        "The Imperial Residence",
        "The Jewels",
        "The Lagoons",
        "The Lakes",
        "The Lawns",
        "The Links",
        "The Lofts",
        "The Meadows",
        "The Meadows 1",
        "The Meadows 2",
        "The Meadows 3",
        "The Meadows 4",
        "The Meadows 5",
        "The Meadows 6",
        "The Meadows 7",
        "The Meadows 8",
        "The Meadows 9",
        "The Nest",
        "The Offices",
        "The Old Town Island",
        "The Onyx Towers",
        "The Palm Deira",
        "The Palm Jebel Ali",
        "The Palm Jebel Ali Gate",
        "The Palm Jumeirah",
        "The Parkway at Dubai Hills",
        "The Plantation, Equestrian &amp; Polo Club",
        "The Polo Townhouses",
        "The Pulse",
        "The Pulse Townhouses Townhouses",
        "The Rainforest",
        "The Roots Akoya Oxygen",
        "The Royal Estates",
        "The Springs",
        "The Springs 1",
        "The Springs 10",
        "The Springs 11",
        "The Springs 12",
        "The Springs 14",
        "The Springs 15",
        "The Springs 2",
        "The Springs 3",
        "The Springs 4",
        "The Springs 5",
        "The Springs 6",
        "The Springs 7",
        "The Springs 8",
        "The Springs 9",
        "The Sundials",
        "The Sustainable City",
        "The Turf",
        "The Valley",
        "The Views",
        "The Villa",
        "The Waves",
        "The Woods",
        "The World",
        "The collection",
        "The-Hills",
        "Tiara Residences",
        "Tijara Town",
        "Tilal Al Ghaf",
        "Time Square Mall",
        "Townhouses",
        "Townhouses Area",
        "Townhouses Area",
        "Travo",
        "Trinity",
        "Trixis",
        "Trump Estates",
        "Tulip Park",
        "Turia",
        "Tuscan Residences",
        "Ubora Towers",
        "Umm Al Sheif",
        "Umm Hurair",
        "Umm Hurair 1",
        "Umm Hurair 2",
        "Umm Ramool",
        "Umm Suqeim",
        "Umm Suqeim 1",
        "Umm Suqeim 2",
        "Umm Suqeim 3",
        "Umm Suqeim Public Beach",
        "Universal Apartments",
        "Uptown Mirdif",
        "Uptown Mirdiff Mall",
        "Uptown Motor City",
        "Urbana",
        "Valencia Park Townhouses",
        "Vardon",
        "Victoria",
        "Victory Heights",
        "Vida Residence",
        "Villa Lantana 1",
        "Villa Lantana 2",
        "Villanova",
        "Viridian at the Fields",
        "Vista Lux",
        "WASL1",
        "Wadi Almardi",
        "Wafi City Mall",
        "Warda Apartments",
        "Warsan Village",
        "Wasl Crystal",
        "Wasl Gate",
        "Water Canal Villas",
        "Waterfront Jebel Ali",
        "West Phase 3",
        "Westar Casablanca Villas",
        "Westar Constellation Villas",
        "Westar Les Castelets",
        "Westar Reflections Villas",
        "Westar Terrace Garden Villas",
        "Westar Vista",
        "Westburry Square",
        "Western Residence North",
        "Weston Court",
        "Whispering Pines",
        "Whitefield",
        "Widcombe House",
        "Wildflower",
        "Winter",
        "World Trade Center",
        "World Trade Centre Residence",
        "Xanadu Residences",
        "Yansoon",
        "Yasmin",
        "Zaafaran",
        "Zabeel",
        "Zabeel 1",
        "Zabeel 2",
        "Zabeel Palace",
        "Zahra Apartments",
        "Zahra Townhouses",
        "Zanzebeel",
        "Zen by Indigo",
        "Zenith Towers",
        "Zinnia",
        "Zinnia",
        "Zulal",
        "Zulal 1",
        "Zulal 2",
        "Zulal 3"
      ];

      city["Fujairah"] = [
        "Address Residences Fujairah Resort",
        "Al Faseel",
        "Dibba",
        "Fujairah Freezone",
        "Gurfah",
        "Hail",
        "Hayl",
        "Kalba",
        "Khor Fakkan",
        "Merashid",
        "Sakamkam",
        "Saniaya",
        "Sharm"
      ];

      city["Ras al Khaimah"] = [
        "AL Mataf",
        "Al Darbijaniyah",
        "Al Dhait",
        "Al Dhait North",
        "Al Dhait South",
        "Al Duhaisah",
        "Al Faslayn",
        "Al Ghail Industrial Area",
        "Al Ghubb",
        "Al Hamra",
        "Al Hamra Village",
        "Al Hudaibah",
        "Al Jazirah Al Hamra",
        "Al Juwais",
        "Al Kharran",
        "Al Mairid",
        "Al Mamourah",
        "Al Marjan Island",
        "Al Nadiyah",
        "Al Nakheel",
        "Al Nudood",
        "Al Qir",
        "Al Qurm",
        "Al Qusaidat",
        "Al Rams",
        "Al Riffa",
        "Al Seer",
        "Al Sharishah",
        "Al Turfa",
        "Al Uraibi",
        "Bab Al Bahr Residences",
        "Cove",
        "Dafan Al Khor",
        "Dahan",
        "Ghalilah",
        "Khuzam",
        "Marina Residences",
        "Mina Al Arab",
        "RAK City",
        "Ras Al Khaimah (South)",
        "Ras Al Khaimah Waterfront",
        "Seih",
        "Shamal Julphar",
        "Shams",
        "Sidroh",
        "Suhaim",
        "The Lagoons",
        "Yasmin Village"
      ];

      city["Sharjah"] = [
        "Abu Shagara",
        "Al Abar",
        "Al Azra",
        "Al Barashi",
        "Al Darari",
        "Al Dhaid",
        "Al Falaj",
        "Al Fayha",
        "Al Fisht",
        "Al Ghaphia",
        "Al Gharayen",
        "Al Gharb",
        "Al Ghubaiba",
        "Al Ghuwair",
        "Al Goaz",
        "Al Hamriyah Free Zone",
        "Al Hazana",
        "Al Heera",
        "Al Jazzat",
        "Al Jubail",
        "Al Juraina",
        "Al Khan",
        "Al Layyeh",
        "Al Mahatah",
        "Al Majaz",
        "Al Majaz 3",
        "Al Mamzar",
        "Al Manakh",
        "Al Mansura",
        "Al Mareija",
        "Al Mirgab",
        "Al Mujarrah",
        "Al Musalla",
        "Al Nabba",
        "Al Nahda (Sharjah)",
        "Al Nasserya",
        "Al Nouf",
        "Al Nud",
        "Al Qadisia",
        "Al Qasba",
        "Al Qasimia",
        "Al Qulayaa",
        "Al Rahmaniya",
        "Al Ramaqia",
        "Al Ramla",
        "Al Ramtha",
        "Al Rifaah",
        "Al Riffa",
        "Al Sabkha",
        "Al Sajaa",
        "Al Shahba",
        "Al Shuwaihean",
        "Al Soor",
        "Al Sweihat",
        "Al Taawun",
        "Al Tai",
        "Al Tala'a",
        "Al Yarmook",
        "Al Zahia",
        "Al Zubair",
        "Al Zubair Orchards",
        "Al khaledia",
        "Al khezamia",
        "Al nishama",
        "Al turrfa",
        "Aljada",
        "Bu Tina",
        "Corniche Al Buhaira",
        "Dasman",
        "Elyash",
        "Emirates Industrial City",
        "Halwan Suburb",
        "Hoshi Area",
        "Industrial Area 1",
        "Industrial Area 10",
        "Industrial Area 11",
        "Industrial Area 12",
        "Industrial Area 13",
        "Industrial Area 14",
        "Industrial Area 15",
        "Industrial Area 16",
        "Industrial Area 17",
        "Industrial Area 2",
        "Industrial Area 3",
        "Industrial Area 4",
        "Industrial Area 5",
        "Industrial Area 6",
        "Industrial Area 7",
        "Industrial Area 8",
        "Industrial Area 9",
        "Juwaiza'a",
        "Maryam Island",
        "Maysaloon",
        "Muwafjah",
        "Muwaileh",
        "Muwailih Commercial",
        "Nasma Residences",
        "Rolla Area",
        "Saif Zone",
        "Samnan",
        "Sharjah Industrial Area",
        "Sharjah Industrial Area 18",
        "Sharjah Waterfront City",
        "Sharqan",
        "Souq Al Haraj / Tasjeel Village",
        "Tilal City",
        "Um Tarrafa",
        "University City",
        "batayeh"
      ];

      city["Umm al Quwain"] = [
        "Al Aahad",
        "Al Dar Al Baida",
        "Al Haditha",
        "Al Hawiyah",
        "Al Humrah",
        "Al Khor",
        "Al Maidan",
        "Al Raas",
        "Al Ramlah",
        "Al Raudah",
        "Al Riqqah",
        "Al Salamah",
        "Defence Camp",
        "Emirates Modern Industrial",
        "Masjid Al Mazroui",
        "Old Town Area",
        "U.A.Q Industrial Area",
        "Umm Al Quwain Marina"
      ];

      //initialize neighbourhood
      var default_city = $("#city").val();
      for(var j = 0; j < city[default_city].length; j++) {
        $("#neighbourhood").append("<option value='"+city[default_city][j]+"'>"+city[default_city][j]+"</option>");
      }
      
      $("#city").on("change", function(){
        var ct = $(this).val();
        $("#neighbourhood").html('');
        // $("#neighbourhood").html('<option>Select Neighborhood</option>');
        for(var i = 0; i < city[ct].length; i++) {
          $("#neighbourhood").append("<option value='"+city[ct][i]+"'>"+city[ct][i]+"</option>");
        }
        $('#neighbourhood').trigger('chosen:updated');
      });

      //
      $("#item-type").on("change", function(){
        $(this).next("small").hide();
      });

      $("#item-name").on("change", function(){
        if(!!this.value) {
          $(this).next("small").hide();
        }
        else {
          $(this).next("small").show();
        }
      });

      $("#description").on("change", function(){
        if(!!this.value) {
          $(this).next("small").hide();
        }
        else {
          $(this).next("small").show(); 
        }
      });

      $("#daily-aed").on("change", function() {
        if(!!this.value) {
          $(this).next("small").hide();
        }
        else {
          $(this).next("small").show(); 
        }
      });

      $("#weekly-aed").on("change", function() {
        if(!!this.value) {
          $(this).next("small").hide();
        }
        else {
          $(this).next("small").show(); 
        }
      });

      $("#monthly-aed").on("change", function() {
        if(!!this.value) {
          $(this).next("small").hide();
        }
        else {
          $(this).next("small").show(); 
        }
      });

      $("#sale-price").on("change", function() {
        if(!!this.value) {
          $(this).next("small").hide();
        }
        else {
          $(this).next("small").show(); 
        }
      });

      $("#location-1").on("change", function() {
        if(!!this.value) {
          $(this).next("small").hide();
        }
        else {
          $(this).next("small").show(); 
        }
      });

      $("#location-2").on("change", function() {
        if(!!this.value) {
          $(this).next("small").hide();
        }
        else {
          $(this).next("small").show(); 
        }
      });

      $("#street").on("change", function() {
        if(!!this.value) {
          $(this).next("small").hide();
        }
        else {
          $(this).next("small").show(); 
        }
      });

      $("#area").on("change", function() {
        if(!!this.value) {
          $(this).next("small").hide();
        }
        else {
          $(this).next("small").show(); 
        }
      });

      $("#city").on("change", function() {
        if(!!this.value) {
          $(this).next("small").hide();
        }
        else {
          $(this).next("small").show(); 
        }
      });

      // initialize chosen jquery
      $("#neighbourhood").chosen({width: "100%"});
  });

</script>

<script src="https://kit.fontawesome.com/b6de54a31f.js" crossorigin="anonymous"></script>

</body>
</html>
