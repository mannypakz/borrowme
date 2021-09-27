@extends('layouts.template')
@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>

<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> -->
<script type="text/javascript" src="{{ asset('rating.js') }}"></script>

<div class="container">
	@if(Session::has('page_expired_error'))
		<div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
		  <strong>Page Expired!</strong> Please login to continue.
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>
	@endif
	<div class="row mt-5">
		<div class="col-md-3">
			@include('layouts/item_nav')
		</div>
		<div class="col-md-9">
			<div class="content-section">
				<div class="d-flex d-row justify-content-end history-filter">
				<div>
					<label for="filter" style="display:none;">Filter:</label>
					<select class="custom-select form-control" id="filter">
						<option @if($filter=='all') selected @endif value="all">All</option>
						<option @if($filter=='active') selected @endif value="active">Active</option>
						<option @if($filter=='completed') selected @endif value="completed">Completed</option>
					</select>
				</div>
				<div>
					<label for="sort" style="display:none;">Sort:</label>
					<select class="custom-select form-control" id="sort">
						<option @if($sort == 'new_to_old') selected @endif value="new_to_old">New to Old</option>
						<option @if($sort == 'old_to_new') selected @endif value="old_to_new">Old to New</option>
					</select>
				</div>
			</div>
			<div id="item-history">
				<div class="row">
				@for($i = 0; $i < count($products); $i++)
				<div class="col-md-12 item-history-content">
					<div class="row">
						<div class="col-md-3">
							<img src="{{asset('uploads') . '/' . $products[$i]->primary_img}}" style="max-width:100%;">
						</div>
						<div class="col-md-9">
							<span class="status">
								@if(null != $products[$i]->sale_status && $products[$i]->sale_status == 'Sold')
									{{$products[$i]->sale_status}}
								@elseif(null != $products[$i]->rent_status)
									{{$products[$i]->rent_status}}
								@endif
							</span>
							<div class="item-history-details">
								<p>Order #: {{$products[$i]->id}}</p>
								<p>Status: {{$products[$i]->status}}</p>
								<p>Item Type: {{$products[$i]->item_type}}</p>
								@if($products[$i]->date_rented)
								<p>Rented Date: {{$products[$i]->date_rented}}</p>
								@endif
								@if($products[$i]->date_available)
								<p>Return Date: {{$products[$i]->date_available}}</p>
								@endif
								<p class="mb-0">Rent Price: <?php echo $products[$i]->daily_aed ? 'AED-'.$products[$i]->daily_aed : ''; ?></p>
								<div class="row align-items-center">
									<div class="col-md-4">
										<p class="mb-0">Recieved Review: </p>
									</div>
									<div class="col-md-3">
										<span class="star-ratings">
											@for($v = 0; $v < $products[$i]->rating; $v++)
												<i class="fas fa-star"></i>	
											@endfor
									</span>
									</div>
									<div class="col-md-5">
										<button type="button" class="btn btn-primary btn-sm show-review-comments" data="{{$products[$i]->id}}">Show Review Comments</button>
									</div>
								</div>
								@if(count($products[$i]->provided_review) > 0)
									<p>
										Provided Review: <span class="star-ratings">
										@for($j = 0; $j < $products[$i]->provided_review[0]->stars; $j++)
											<i class="fas fa-star"></i>	
										@endfor
										</span>
									</p>
								@endif
							</div>
						</div>
						<div class="col-md-12">
							@if(count($products[$i]->provided_review) == 0)
							<div class="text-center mt-3">
								<button type="button" class="btn btn-primary provide-btn" data="{{$products[$i]->id}}">Provide Review</button>
							</div>
							@endif
						</div>
					</div>
				</div>
				@endfor
				</div>
			</div>
			</div>
		</div>
	</div>
</div>

<!-- Review Modal -->
<div class="modal fade item-history-modal" id="review_modal" tabindex="-1" role="dialog" aria-labelledby="review_modal" aria-hidden="true">
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
        	<textarea name="feedback" placeholder="Type your review here..." rows="10" cols="53" required></textarea>
        	<input type="hidden" name="product_id">
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

<!-- Show Review Modal -->
<div class="modal fade" id="show_review" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="show_reviewLongTitle">Reviews</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body review-body">
        <table class="table table-striped">
        	<thead>
        		<tr>
        			<th>Comments</th>
        			<th >Rating</th>
        		</tr>
        	</thead>
        	<tbody id="review-table-body">
        		
        	</tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border:0;color:#000!important;">Close</button>
      </div>
    </div>
  </div>
</div>

<form method="GET" id="filter-form">
	<input type="hidden" name="filter" value="{{$filter}}">
</form>

<form method="GET" id="sort-form">
	<input type="hidden" name="sort" value="{{$sort}}">
</form>

<script type="text/javascript">
	// $(document).ready( function () {
 //    	$('#item-history').DataTable();
	// });
	$(".provide-btn").on('click', function(){
		var product_id = $(this).attr('data');
		$("input[name=product_id]").val(product_id);
		$("#review_modal").modal('show');
	});

	$("#rating").rating({
		"click": function(e){
			$("input[name=stars]").val(e.stars);
			$(".rating-number").html(e.stars);
		}
	});

	$('.show-review-comments').on('click', function(){
		var id = $(this).attr('data');
		var fd =  new FormData();
		fd.append('_token', '<?php echo csrf_token(); ?>');
		fd.append('product_id', id);

		$.ajax({
			type: "POST",
			url: "/item/ajax_get_reviews",
			data: fd,
			contentType: false,
			processData: false,
			success: function(data){
				var json = JSON.parse(data);
				$("#review-table-body").empty();
				for(var i = 0; i < json.length; i++) {
					var txt = json[i].feedback;
					var stars = '';
					for(var j = 0; j < json[i].stars; j++) {
						stars += '<i class="fas fa-star" style="color:#2cb7aa;"></i>';
					}
					var tr = "<tr><td>" + txt + "</td><td width='120'>" + stars+ "</td></tr>";
					$("#review-table-body").append(tr);
				}
				$('#show_review').modal('show');
			},
			error: function(){
				console.log("error");
			}
		});
	});
	
	
	$("#sort, #filter").on("change", function(){
		redirect();
	});

	function redirect() {
		var f = $("#filter").val();
		var s = $("#sort").val();
		
	}

	$(window).on('load',function() {
	 // executes when complete page is fully loaded, including all frames, objects and images
	 $("select#filter option:selected").prepend('Filter: ');
	 $("select#sort option:selected").prepend('Sort by: ');
	});

	$("select#filter").click(function(){
		var update_filter = $("select#filter option:selected").text().replace('Filter: ', ' ');
		$("select#filter option:selected").text(update_filter);
	});
	$("select#sort").click(function(){
		var update_sort = $("select#sort option:selected").text().replace('Sort by: ', ' ');
		$("select#sort option:selected").text(update_sort);
	});

	// filter change
	$("#filter").on("change", function(){
		$("input[name=filter]").val(this.value);
		$("#filter-form").submit();
	});

	// sort change
	$("#sort").on("change", function(){
		$("input[name=sort]").val(this.value);
		$("#sort-form").submit();
	});

</script>
@endsection