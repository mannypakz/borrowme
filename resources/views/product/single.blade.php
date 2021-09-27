@extends('layouts.template')

@section('content')
<div class="container mt-5">
	<div class="row">
		<div class="col-md-8">
			<div class="item-image">
				<img src="{{asset('uploads') . '/' .$product->primary_img}}" width="500px" height="500px" id="primary-img">
			</div>
			<div class="mt-2">
				<div class="item-image-thumbnail">
					@foreach($images as $i)
						<img src="{{asset('uploads') . '/' . $i}}" width="100px" height="100px" onclick="change_primary(this)">
					@endforeach
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="item-content">
				<div><b>Details</b></div>
				<div>Item Name: {{$product->item_name}}</div>
				<div>Vendor: {{$vendor->name}}</div>
				<div>Description: {{$product->description}}</div>
				<div>Item Condition: {{$product->item_condition}}</div>
				<div>Item Age: {{$product->age}}</div>
				<div>Daily AED: {{$product->daily_aed ?? ''}}</div>
				<div>Weekly AED: {{$product->weekly_aed ?? ''}}</div>
				<div>Monthly AED: {{$product->monthly_aed ?? ''}}</div>
				<div>Cash Deposit: {{$product->cash_deposit ?? ''}}</div>
				@if($product->available_for_sale == 'yes')
					<div>Sale Price: {{$product->sale_price}}</div>
				@endif
				<br>
				<div><b>Location</b></div>
				<div>Flat No.: {{$product->location_1}}</div>
				<div>Building: {{$product->location_2}}</div>
				<div>Street: {{$product->street}}</div>
				<div>Area: {{$product->area}}</div>
				<div>City: {{$product->city}}</div>

				<br>
				<div><b>Status</b></div>
				<div>Rent Status: {{$product->rent_status ? $product->rent_status : 'N/A'}}</div>
				<div>Sale Status: {{$product->sale_status ? $product->sale_status : 'N/A'}}</div>

				<br>
				<div><b>Availability</b></div>
				<div>Date Rented: {{$product->date_rented ? $product->date_rented : 'N/A'}}</div>
				<div>Date Available: {{$product->date_available ? $product->date_available : 'N/A'}}</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function change_primary(data) {
		document.getElementById("primary-img").src = data.src;
	}
</script>
@endsection