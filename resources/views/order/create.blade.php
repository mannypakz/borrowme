@extends('layouts.template')

@section('content')
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript" src="{{ asset('rating.js') }}"></script>
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> -->
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>

<div class="container">
	@if(Session::has('product_update') && Session::get('product_update') == 'success')
		<div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			Product marked as available!
		</div>
	@endif
	<div class="row page0">
		<div class="col-md-12">
			<div class="item-title mb-4 mt-4">
				<h3>{{$product->item_name}}</h3>
			</div>
		</div>
		<div class="col-md-8">
			<div class="item-image mb-4">
				<img src="{{asset('uploads')}}{{'/'.$product->primary_img}}" height="600px" width="600px" id="main-image">
			</div>
			<div class="item-image-thumbnail d-flex" style="flex-wrap: wrap;">
				@php
					$imgs = json_decode($product->images);
				@endphp
				@foreach($imgs as $i)
					<div>
						<img src="{{asset('uploads')}}{{'/'.$i}}" height="100px" width="100px" class="second-img mt-1">
					</div>
				@endforeach
			</div>

			<div class="item-description mt-5">
				<h3>Description</h3>
				<p>{{$product->description}}</p>
				<a href="/products/single/{{$product->id}}">Read more about this item</a>
			</div>
		</div>
		<div class="col-md-4">
			<div class="item-content">
				<h3 class="mb-3">
					@if($product->rental_duration_daily)
						AED-{{$product->daily_aed}} per day
					@elseif($product->rental_duration_weekly)
						AED-{{$product->weekly_aed}} per week
					@elseif($product->rental_duration_monthly)
						AED-{{$product->monthly_aed}} per month
					@endif
				</h3>
				<span>{{$vendor}}</span>
				<span class="rating">
					@for($p = 0; $p < $pr_rating; $p++)
						<i class="fas fa-star"></i>	
					@endfor
					({{ceil($pr_rating)}})
				</span>
				<div class="row mt-4 mb-4">
					@if($product->daily_aed)
					<div class="col-md-4">
						<div class="rental text-center" rent="daily" data="{{$product->daily_aed}}">AED-{{$product->daily_aed}} <br/>
							<small>Per day</small>
						</div>
					</div>
					@endif
					
					@if($product->weekly_aed)
					<div class="col-md-4">
						<div class="rental text-center" rent="weekly" data="{{$product->weekly_aed}}">AED-{{$product->weekly_aed}} <br/>
							<small>Per week</small>
						</div>
					</div>
					@endif
					
					
					@if($product->monthly_aed)
					<div class="col-md-4">
						<div class="rental text-center" rent="monthly" data="{{$product->monthly_aed}}">AED-{{$product->monthly_aed}} <br/>
							<small>Per month</small>
						</div>
					</div>
					@endif
					
					<input type="hidden" name="rental_value">
				</div>
				<div>
					When do you want it?
					<input type="text" name="daterange" id="daterange">
				</div>
				<div class="availability">
					<div class="row">
						<div class="col-md-2">
							<i class="far fa-calendar-alt"></i>
						</div>
						<div class="col-md-10">
							<h5>Check availability</h5>
							<p>Check if the item is available on the dates you want.</p>
						</div>
					</div>
					<div class="row">
						@if($product->available_for_sale == 'yes' )
							<div class="col-md-2">
								<i class="fas fa-shopping-basket"></i>
							</div>
							<div class="col-md-10">
								<h5>Available for sale</h5>
								<p>AED-{{$product->sale_price}}</p>
							</div>
						@endif
					</div>
				</div>
				<div class="row text-center">
					@if($product->sale_status != 'Sold' && $product->rent_status != 'Renting')
						@if($product->for_rent)
							<div class="col-md-6">
								<button type="button" class="btn btn-primary rent-btn" @if(Auth::check() && $product->vendor_id == $user->id) disabled @endif>Rent this Item</button>
							</div>
						@endif
						@if($product->available_for_sale == 'yes')
							<div class="col-md-6">
								<button type="button" class="btn btn-outline-primary buy-btn" @if(Auth::check() && $product->vendor_id == $user->id) disabled @endif>Buy this item!</button>
							</div>
						@endif
						
					@else
						@if(Auth::check() && $product->vendor_id == $user->id && $available_now && $product->rent_status == 'Renting')
							<div class="col-md-12">
								<form method="post" action="{{route('mark_as_available')}}">
									@csrf
									<input type="hidden" name="referrer" value="{{$_SERVER['REQUEST_URI']}}">
									<input type="hidden" name="product_id" value="{{$product->id}}">
									<button type="submit" class="btn btn-primary">Mark as available</button>
								</form>
							</div>
						@endif
					@endif
				</div>
			</div>

			<div class="item-buttons mt-4 mb-4">
				@if($product->phone)
					<a href="tel: {{ $product->phone ?? '000-000-000'}}" class="btn btn-outline-primary btn-block mb-3">
						<i class="fas fa-phone-alt"></i>
						{{ $product->phone ?? '000-000-000' }}
					</a>
				@endif
				<a href="/chat/message/add/{{$product->vendor_id}}" class="btn btn-primary btn-block  mb-3">Message Lender</a>
				<!-- <button type="submit" class="btn btn-primary btn-block  mb-3">Message Lender</button> -->
				
				<form method="post" action="{{route('save_item')}}">
					@csrf
					<input type="hidden" name="wishlist_product_id" value="{{$product->id}}">
					<input type="hidden" name="wishlist_product_name" value="{{$product->item_name}}">
					<input type="hidden" name="wishlist_description" value="{{$product->description}}">
					<input type="hidden" name="wishlist_vendor" value="{{$vendor}}">
					<input type="hidden" name="wishlist_image" value="{{$product->primary_img}}">
					<input type="hidden" name="wishlist_url" value="/products/single/{{$product->id}}">
					<button type="submit" class="btn btn-outline-primary btn-block  mb-3"><i class="fas fa-heart"></i>Save</button>	
				</form>
				<button type="button" class="btn btn-primary btn-block share-but"><i class="fas fa-share-square"></i>Share</button>
			</div>

			<div class="show-map">
				<button type="button" class="btn btn-outline-primary show-map btn-block">Show Map</button>
			</div>

			<div style="height: 500px; width: 355px; display: none;" class="map-div mt-2">
				<div id="map" style="height: 500px; width: 355px;"></div>
			</div>
		</div>

		<div class="row mt-4">
			<div class="col-md-12">
				<hr/>
			</div>
			<div class="col-md-8">
				<div>
					<h3 class="seller-name mb-4">Meet {{$vendor}}</h3>
					<div class="row align-items-center mb-3">
						<div class="col-md-2">
							<div class="seller-avatar">
								<img src="{{asset('uploads')}}{{'/'.$avatar}}" class="br-30" width="50px" height="50px">
							</div>
						</div>
						<div class="col-md-10">
							<div class="seller-rating">
								<p>{{$vendor}}</p>
								@if(count($vendor_review) > 0)
									@for($cnt = 0; $cnt < $vendor_review[0]->stars; $cnt++)
										<i class="fas fa-star"></i>	
									@endfor
									({{$vendor_review[0]->stars}})
								@endif
							</div>
						</div>
					</div>
					<div class="mb-3">
						@if(count($vendor_review) > 0)
							{{$vendor_review[0]->feedback}}
						@endif
					</div>
					<div>
						<a href="/chat/message/add/{{$product->vendor_id}}" class="btn btn-primary btn-block  mb-3">Message Lender</a>
						<!-- <button type="button" class="btn btn-primary">Message Lender</button> -->
					</div>
				</div>
			</div>
			<div class="col-md-4">
				&nbsp;
			</div>
			<div class="col-md-12 mt-5">
				<hr/>
			</div>
			<div class="col-md-8">
				<div class="client-rating mt-5">
					<div class="row align-items-center">
						<div class="col-md-12">
							<h3>{{$vendor_review->count()}} Reviews</h3>
						</div>
						<!--<div class="col-md-9">
							<div class="star-rating">
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
							</div>
						</div> -->
					</div>
				</div>
				<div class="view-reviews mt-3">
					<a href="/review/user/{{$product->vendor_id}}">See all reviews of {{$vendor}}</a>
				</div>
			</div>
			<div class="col-md-4">
				&nbsp;
			</div>
		</div>

		<div class="row mt-4" style="width: 100%;margin: 0 auto;">
			<div class="col-md-12">
				<div>
					<h3 class="mt-4 mb-5">Other items from {{$vendor}}</h3>
					<div class="row">
						@foreach($other as $o)
							<div class="col-md-4">
								<div class="item-wrapper">
									<div class="other-items-thumbnail">
										<a href="/product/view/{{$o->id}}">
											<img src="{{asset('uploads')}}{{'/'.$o->primary_img}}" width="300px" height="300px">
										</a>
										<small>AED{{$o->daily_aed}}/day</small>
									</div>
									<div class="item-short-desc">
										{{$o->description}}
									</div>
									<div class="row align-items-center" style="margin: 0 1rem 1rem;">
										<div class="col-md-6">
											<div class="row align-items-center">
												<div class="col-md-4">
													<img src="{{asset('uploads')}}{{'/'.$avatar}}" class="br-30" width="30px" height="32px">
												</div>
												<div class="col-md-8">
													<p class="other-items-seller-naame mb-0">{{$vendor}}</p>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="other-items-rating text-right">
												@for($v = 0; $v < $o->rating; $v++)
													<i class="fas fa-star"></i>
												@endfor
												({{ceil($o->rating)}})
											</div>
										</div>
									</div>
								</div>
							</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row page1 mt-5" style="display: none;">
		<div class="col-md-7">
			<div class="mb-4">
				<h2>Review your order</h2>
				<p>Kindly read the and check the details and item which you are going to borrow carefully. Before sending and borrow request.</p>
			</div>

			<div class="mt-5">
				<h4>1. No fee</h4>
				<p>We do not proceed any service or platform fee from borrower and either for lender. BorrowMe is totally free of cost for both borrower and lender</p>
			</div>

			<div class="mt-5 mb-5">
				<h4>2. Pay directly to lender</h4>
				<p>No need to use or put your payment method on BorrowMe for paying lender. BorrowMe solve this by paying lender directly or face to face.</p>
			</div>
			<div>
				<button type="button" class="btn btn-outline-primary back-btn">Back</button>
				<button type="button" class="btn btn-primary place-btn custom-button-size">Place an Order</button>
			</div>
		</div>
		<div class="col-md-5">
			<div class="review-order-content">
				<div class="row">
					<div class="col-md-12">
						<div class="text-right">
							<a href="javascript:void(0);" style="color:#2cb7aa;" onclick="back();">Edit</a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div>
							<img src="{{asset('uploads')}}{{'/'.$product->primary_img}}" width="100p" height="100px">
						</div>
					</div>
					<div class="col-md-8">
						<div>
							<h4 class="mb-0">{{$product->item_name}}</h4>
							<p>{{$vendor}}</p>
						</div>
					</div>
				</div>
				<div class="date-rental mt-4 mb-4 text-center">
					<div class="row align-items-center">
						<div class="col-md-4">
							<span id="start" class="d-block text-left"></span>
						</div>
						<div class="col-md-4">
							<span>&#8594;</span>
						</div>
						<div class="col-md-4">
							<span id="end" class="d-block text-right"></span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="text-left calculate">
							AED-<span id="conf-rental-value"></span> X
							<span id="conf-rental-days"></span> Days
						</div>
					</div>
					<div class="col-md-6">
						<div class="text-right">
							<span class="conf-rental-total"></span>
						</div>
					</div>
				</div>
				<div class="service-fee">
					<div class="row">
						<div class="col-md-6">
							<div class="text-left">
								<p>Service Fee:</p>
							</div>
						</div>
						<div class="col-md-6">
							<div class="text-right">
								<p>--</p>
							</div>
						</div>
					</div>
				</div>
				<div class="total-amount">
					<div class="row">
						<div class="col-md-6">
							<div class="text-left">
								<span>Total:</span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="text-right">
								<span class="conf-rental-total"></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- the form -->
<form method="post" action="{{ route('checkout') }}" id="order_form">
	@csrf
	<input type="hidden" name="order_type">
	<input type="hidden" name="start_date">
	<input type="hidden" name="end_date">
	<input type="hidden" name="days">
	<input type="hidden" name="price">
	<input type="hidden" name="total">
	<input type="hidden" name="vendor_id" value="{{$product->vendor_id}}">
	<input type="hidden" name="product_id" value="{{$product->id}}">
	<input type="hidden" name="sale_price" value="{{$product->sale_price}}">
</form>

<!-- Place order Modal -->
<div class="modal fade order-modal" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <h3>BorrowMe is not liable for any damage</h3>
        <img src="{{ asset('/images/order-modal.jpg') }}" />
      </div>
      <div class="order-button">
        <button type="button" class="btn btn-primary btn-block conf-place-order">Place Order</button>
        <button type="button" class="btn btn-outline-primary btn-block" data-dismiss="modal" style="border:0;color:#000!important;margin-bottom: 20px;">Cancel Order</button>
      </div>
    </div>
  </div>
</div>

<!-- Review Modal -->
<div class="modal fade" id="product_review_modal" tabindex="-1" role="dialog" aria-labelledby="review_modal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      	<h4>Give Feedback</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{route('store_review')}}">
        	@csrf
        	<p>
        		Tell us about your borrower and rented item condition and share your experience of renting your items on "BorrowMe" with us and other users. Thanks!
        	</p>
        	<div class="row">
        		<div class="col-md-6">
        			<p><b>Rating</b></p>
        		</div>
        		<div class="col-md-6">
        			<div class="text-right d-flex" style="justify-content: flex-end;">
        				<div id="rating"></div>
        				<div class="ml-2 rating-number"></div>
        			</div>
        		</div>
        	</div>
        	<textarea name="feedback" placeholder="Type your review here..." rows="10" cols="53"></textarea>
        	<input type="hidden" name="product_id" value="{{$product->id}}">
        	<input type="hidden" name="stars" value="0">
        	<input type="hidden" name="ref" value="{{$_SERVER['REQUEST_URI']}}">
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-block">Submit</button>
        <!-- <button type="button" class="btn btn-outline-primary btn-block" data-dismiss="modal" style="border:0;color:#000!important;">Close</button> -->
        </form>
      </div>
    </div>
  </div>
</div>

<!-- User review modal -->
<div class="modal fade" id="user_review_modal" tabindex="-1" role="dialog" aria-labelledby="review_modal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      	<h4>Give Feedback</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{route('store_review')}}">
        	@csrf
        	<p>
        		Tell us about your borrower and rented item condition and share your experience of renting your items on "BorrowMe" with us and other users. Thanks!
        	</p>
        	<div class="row">
        		<div class="col-md-6">
        			<p><b>Rating</b></p>
        		</div>
        		<div class="col-md-6">
        			<div class="text-right d-flex" style="justify-content: flex-end;">
        				<div id="user_rating"></div>
        				<div class="ml-2 user-rating-number"></div>
        			</div>
        		</div>
        	</div>
        	<textarea name="feedback" placeholder="Type your review here..." rows="10" cols="53" required></textarea>
        	<input type="hidden" name="type" value="user">
        	<input type="hidden" name="user_stars" value="0">
        	<input type="hidden" name="ref" value="{{$_SERVER['REQUEST_URI']}}">
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-block">Submit</button>
        <!-- <button type="button" class="btn btn-outline-primary btn-block" data-dismiss="modal" style="border:0;color:#000!important;">Close</button> -->
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Share modal -->
<div class="modal fade" id="share-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       	<center>
       		<h3>Share!</h3>
       		<p style="font-size: 20px">Share this item with your friends and family or any where by using this url or share it directly on social media.</p>
       		<p style="font-size: 20px">Thanks!</p>
       		<div>
       			<input type="text" name="share_link" size="35">
       		</div>
       		<div>
       			<!-- <a href="javascript:void(0);" style="font-size: 25px;" class="mr-2" onclick="fb_share();">
       				<i class="fab fa-facebook-f"></i>
       			</a> -->
       			<a href="#" style="font-size: 25px;" class="mr-2" target="_blank" id="linkedin-share">
       				<i class="fab fa-linkedin-in"></i>	
       			</a>
       			<a href="#" style="font-size: 25px;" target="_blank" id="twitter-share">
       				<i class="fab fa-twitter"></i>
       			</a>
       		</div>
       	</center>
      </div>
      <div class="modal-footer">
        <center>
        	
        </center>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	var current_uri = window.location.href;
	var item_title = $(".item-title h3").text();
	var linked_share_url = "https://www.linkedin.com/shareArticle?mini=true&url=" + current_uri + "&title=" + item_title;
	var twitter_share_url = "http://twitter.com/share?text="+item_title+"&url="+current_uri;
	$("#linkedin-share").attr("href", linked_share_url);
	$("#twitter-share").attr("href", twitter_share_url);

	$('input[name="daterange"]').daterangepicker({
		minDate:new Date()
	});

	$("#daterange").val("Start date                 \u2192               End date");

	var script = document.createElement('script');
	// <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAIISsYkS-hwalG7P-iknMoisUzRCyBbz0" defer>
	script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyAIISsYkS-hwalG7P-iknMoisUzRCyBbz0';
	script.defer = true;

	function initMap() {
		var map = new google.maps.Map(document.getElementById("map"), {
    		center: { lat: -34.397, lng: 150.644 },
    		zoom: 15
  		});

  		var loc_1 = '<?php echo $product->location_1; ?>';
  		var loc_2 = '<?php echo $product->location_2; ?>';
  		var st = '<?php echo $product->street; ?>';
  		var area = '<?php echo $product->area; ?>';
  		var city = '<?php echo $product->city; ?>';

	    const geocoder = new google.maps.Geocoder();
	    
	    geocoder.geocode({ address:  loc_1 + " " + loc_2 +" "+st+" "+area+" "+city}, (results, status) => {
	    if (status === "OK") {
	      map.setCenter(results[0].geometry.location);
	      new google.maps.Marker({
	        map: map,
	        position: results[0].geometry.location,
	      });
	    } else {
	      alert("Geocode was not successful for the following reason: " + status);
	    }
    });
	}

	document.head.appendChild(script);

	const nth = function(d) {
  		if (d > 3 && d < 21) return 'th';
  		switch (d % 10) {
    		case 1:  return "st";
    		case 2:  return "nd";
    		case 3:  return "rd";
    		default: return "th";
  		}
	}

	$(".show-map").on('click', function(){
		initMap();
		$(".map-div").show();
	});

	$(".rental").hover(function(){
		$(this).css("cursor", "pointer");
	});

	$(".rental").on('click', function(){
		$(".rental").each(function(index){
			$(this).removeAttr("style");
		});

		$(this).css("border", "1px solid #2cb7aa");
		$("input[name=rental_value]").val($(this).attr('data'));

	});

	var ref = new URL(window.location.href);
	
	$(".rent-btn").on('click', function(){
		var rental = $("input[name=rental_value]").val();
		var is_logged = '<?php echo Auth::check(); ?>';
		var product_id = '<?php echo $product->id; ?>';
		var date = $("#daterange").val().split("-");

		if(!!rental && date.length == 2) {
			if(!is_logged) {
				window.location.href = "/login?ref="+product_id;
			}
			else {
				var dates = $("#daterange").val();
				dates = dates.split("-");
				var date1 = new Date(dates[0]);
				var date2 = new Date(dates[1]);
				const oneDay = 24 * 60 * 60 * 1000;
				var diffDays = Math.round(Math.abs((date1.getTime() - date2.getTime()) / oneDay));
				const monthNames = ["January", "February", "March", "April", "May", "June",
	  								"July", "August", "September", "October", "November", "December"];
	  			if(diffDays == 0) {
	  				diffDays = 1;
	  			}
				$("#start").text(date1.getDate() + nth(date1.getDate()) + " " + monthNames[date1.getMonth()]);
				$("#end").text(date2.getDate() + nth(date2.getDate()) + " " + monthNames[date2.getMonth()]);
				$("#conf-rental-value").text($("input[name=rental_value]").val());
				$("#conf-rental-days").text(diffDays);
				var a = parseInt($("input[name=rental_value]").val());
				var b = parseInt(diffDays);
				$(".conf-rental-total").text("AED-" + (a*b));
				$(".page0").hide();
				$(".page1").show();
				$(".date-rental").show();
				$(".calculate").show();
				$("input[name=order_type]").val("rent");

				$("input[name=start_date]").val(dates[0]);
				$("input[name=end_date]").val(dates[1]);
				$("input[name=days]").val(diffDays);
				$("input[name=price]").val($("input[name=rental_value]").val());
				$("input[name=total]").val(a*b);
			}
		}
		else {
			alert("Please select a price and a date");
		}
	});

	$(".buy-btn").on('click', function(){
		var is_logged = '<?php echo Auth::check(); ?>';
		var product_id = '<?php echo $product->id; ?>';
		if(!is_logged) {
			window.location.href = "/login?ref="+product_id;
		}
		else {
			$(".date-rental").hide();
			$(".conf-rental-total").text("AED-" + $("input[name=sale_price]").val());
			$(".calculate").hide();
			$(".page0").hide();
			$(".page1").show();
			$("input[name=order_type]").val("sale");
		}
	});

	$(".back-btn").on('click', function(){
		$(".page1").hide();
		$(".page0").show();
	});

	// show confirmation modal
	$(".place-btn").on('click', function(){
		$("#exampleModalCenter").modal('show');
	});

	// submit order form
	$(".conf-place-order").on('click', function(){
		$("#order_form").submit();
	});

	// show review modal
	$(".rating").on("click", function(){
		$("#product_review_modal").modal("show");
	});

	$("#rating").rating({
		"click": function(e){
			$("input[name=stars]").val(e.stars);
			$(".rating-number").html(e.stars);
		}
	});

	//user review modal
	$(".seller-rating").on("click", function(){
		$("#user_review_modal").modal("show");
	});

	$("#user_rating").rating({
		"click": function(e){
			$("input[name=user_stars]").val(e.stars);
			$(".user-rating-number").html(e.stars);
		}
	});

	// change image
	$(".second-img").on("click", function(){
		$("#main-image").attr("src", this.src);
	});

	// share modal
	$(".share-but").on("click", function(){
		$("#share-modal").modal("show");
		$("input[name=share_link]").val('');
		$("input[name=share_link]").val(window.location.href);
	});

	function back() {
		$(".page1").hide();
		$(".page0").show();
	}

	// var pimgs = $(".item-image-thumbnail img");
	// for(var x = 0; x < pimgs.length; x++) {
	// 	if($("#main-image").attr("src") == pimgs[x].src) {
	// 		var sp = document.createElement("SPAN");
	// 		sp.style.background = "#2cb7aa";
	// 		sp.style.fontSize = "14px";
	// 		sp.style.padding = "3px 5px";
	// 		sp.id = "p-label2";
	// 		sp.innerText = "Primary photo";
	// 		sp.style.display = "block";
	// 		sp.style.width = "100px";
	// 		sp.style.position = "absolute";
	// 		sp.style.color = "#ffffff";
	// 		sp.style.marginLeft = "4px";
	// 		sp.style.marginTop = "-6%";
	// 		pimgs[x].after(sp);
	// 	}
	// }

	window.fbAsyncInit = function(){
	FB.init({
	appId: '1048006435702721', status: true, cookie: true, xfbml: true, version: 'v9.0' }); 
	};
		(function(d, debug){var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
		if(d.getElementById(id)) {return;}
		js = d.createElement('script'); js.id = id; 
		js.async = true;js.src = "//connect.facebook.net/en_US/all" + (debug ? "/debug" : "") + ".js";
		ref.parentNode.insertBefore(js, ref);}(document, /*debug*/ false));
		function postToFeed(title, desc, url, image){
		var obj = {method: 'feed',link: url, picture: 'http://www.url.com/images/'+image,name: title,description: desc};
		function callback(response){}
		FB.ui(obj, callback);
	}

	function fb_share() {
		// postToFeed(elem.data('title'), elem.data('desc'), elem.prop('href'), elem.data('image'));
		var image = $("#main-image").attr("src");
		var title = $(".item-title h3").text();
		var desc = $(".item-description p").text();
		var href = window.location.href;
		postToFeed(title, desc, href, image);
	}
</script>
@endsection
