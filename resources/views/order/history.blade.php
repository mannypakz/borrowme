@extends('layouts.template')
@section('content')
<<!--script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> -->
<script type="text/javascript" src="{{ asset('rating.js') }}"></script>

<div class="container">
	<div class="row mt-5">
		<div class="col-md-3">@include('layouts/item_nav')</div>
		<div class="col-md-9">
			<div class="d-flex d-row justify-content-end history-filter">
				<div>
					<form id="filter-form">
					<select class="custom-select form-control" name="filter" id="filter">
						<option @if($filter == 'all') selected @endif value="all">All</option>
						<option @if($filter == 'active') selected @endif value="active">Active</option>
						<option @if($filter == 'completed') selected @endif value="completed">Completed</option>
					</select>
				</div>
				<div>
					<select class="custom-select form-control" name="sort" id="sort">
						<option @if($sort == 'new_to_old') selected @endif value="new_to_old">New to Old</option>
						<option @if($sort == 'old_to_new') selected @endif value="old_to_new">Old to New</option>
					</select>
					</form>
				</div>
			</div>
			<div id="item-history">
				<div class="row">
					@for($i = 0; $i < count($orders); $i++)
					<div class="item-history-content">
						<div class="row">
							<div class="col-md-3">
								<img src="{{asset('uploads') . '/' . $orders[$i]->primary_img}}" style="max-width:100%;">
							</div>
							<div class="col-md-9">
								<span class="status">{{ucwords($orders[$i]->status)}}</span>
								<div class="item-history-details">
									<h4>Order # {{$orders[$i]->id}}</h4>
									<p>Status:
										{{$orders[$i]->p_status}}
									</p>
									<p>Item Type: {{$orders[$i]->item_type}}</p>
									<p>Borrowed Date: {{$orders[$i]->date_rented}}</p>
									<p>Return Date: {{$orders[$i]->date_available}}</p>
									<p class="mb-0">Borrowed Price: AED-{{$orders[$i]->daily_aed}}</p>
									<div class="row align-items-center">
										<div class="col-md-3">
											<p class="mb-0">Recieved Review: </p>
										</div>
										<div class="col-md-3">
											<span class="star-ratings">
												@for($g = 0; $g < $orders[$i]->rating; $g++)
													<i class="fas fa-star"></i>
												@endfor
										</span>
										</div>
										<div class="col-md-6">
											<button type="button" class="btn btn-primary btn-sm show-review-comments" data="{{$orders[$i]->id}}">Show Review Comments</button>
										</div>
									</div>
									<div class="text-center mt-3">
										<button type="button" class="btn btn-primary provide-btn" data="{{$orders[$i]->id}}">Provide Review</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					@endfor
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Provide Review Modal -->
<div class="modal fade" id="review_modal" tabindex="-1" role="dialog" aria-labelledby="review_modal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="review_modalLongTitle">Give Feedback</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<form method="post" action="{{route('store_review')}}">
      		@csrf
        <p>Tell us about your borrower and rented item condition and share your experience of renting your items on "BorrowMe" with us and other users. Thanks!</p>
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
        	<input type="hidden" name="order_id">
        	<input type="hidden" name="stars" value="0">
    		<input type="hidden" name="ref" value="{{$_SERVER['REQUEST_URI']}}">
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-block">Submit</button>
        <!-- <button type="button" class="btn btn-outline-primary btn-block" data-dismiss="modal" style="border:0;color:#000!important;">Close</button> -->
      </div>
      </form>
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
        			<th>Rating</th>
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

<script type="text/javascript" defer>
	$('.provide-btn').on('click', function(){
		var id = $(this).attr('data');
		$('input[name=order_id]').val(id);
		$('#review_modal').modal('show');
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
		fd.append('order_id', id);

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
					var txt = json[i].feedback.substring(0, 15);
					var stars = '';
					for(var j = 0; j < json[i].stars; j++) {
						stars += '<i class="fas fa-star" style="color:#2cb7aa;"></i>';
					}
					var tr = "<tr><td>" + txt + "</td><td>" + stars+ "</td></tr>";
					$("#review-table-body").append(tr);
				}
				$('#show_review').modal('show');
			},
			error: function(){
				console.log("error");
			}
		});
	});

	$("#filter, #sort").on("change", function(){
		$("#filter-form").submit();
	});

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

</script>
@endsection