@extends('layouts.template')
@section('content')
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> -->

<div class="container">
	<div class="row mt-5">
		<div class="col-md-3">
			@include('layouts/item_nav')
		</div>
		<div class="col-md-9">
			<div class="content-section">
				@for($i = 0; $i < count($products); )
				<div class="row">
					@for($j = 0; $i < count($products) && $j < 3; $j++)
						<div class="col-md-4">
							<div class="item-border">
								<a data-toggle="collapse" class="op-settings" href="#collapse_{{$i}}{{$j}}"><i class="fas fa-ellipsis-h" style="color: #2cb7aa;font-size: 25px;"></i></a>
								<div class="collapse" id="collapse_{{$i}}{{$j}}">
  									<div><a href="/product/view/{{$products[$i]->id}}">View</a></div>
  									<div><a href="{{'/item/edit/'.$products[$i]->id}}">Edit</a></div>
  									<div><a href="javascript:void(0);" onclick="delete_item('{{$products[$i]->id}}')">Delete</a></div>
  									<!-- <div><a href="javascript:void(0);" onclick="update_status('{{$products[$i]->id}}')">Update status</a></div> -->
								</div>
								<div style="position:relative;">
									
										<img src="@if(null != $products[$i]->primary_image){{asset('uploads')}}{{'/'.$products[$i]->primary_image}} @else {{asset('/uploads/no-image-icon.png')}} @endif" height="250px" width="270px" style="max-width:100%;cursor:auto;object-fit:cover;">
									
									
										@if(!!$products[$i]->date_available)
										<div class="not-rented rented">
											Rented until {{$products[$i]->date_available}}
										</div>
										@elseif($products[$i]->sale_status == 'Sold')
											
										@else
											<div class="not-rented">
												Not yet rented
											</div>
										@endif
									
								</div>
								<div class="product-short-desc">{!! $products[$i]->item_name !!}</div> 
								<div class="item-price">
									<div class="row">
										<div class="col-md-5">
											@if($products[$i]->daily_aed)
												<div style="width:100px;">
													<span>AED-{{$products[$i]->daily_aed ?? ''}}/day</span>
												</div>
											@elseif($products[$i]->weekly_aed)
												<div style="width:100px;">
													<span>AED-{{$products[$i]->weekly_aed ?? ''}}/week</span>
												</div>
											@elseif($products[$i]->monthly_aed)
												<div style="width:100px;">
													<span>AED-{{$products[$i]->monthly_aed ?? ''}}/month</span>
												</div>
											@else
												<div>&nbsp;</div>
											@endif
										</div>
										<div class="col-md-7 text-right">
											@if(!!$products[$i]->sale_status)
												{{$products[$i]->sale_status}}
											@endif
										</div>
									</div>
								</div>
							</div>
						</div>
						@php
							$i++
						@endphp
					@endfor
				</div>
			@endfor	
			</div>
		</div>
	</div>
</div>
<!-- Delete Form -->
<form method="post" action="{{route('delete_product')}}" id="delete-form">
	@csrf
	<input type="hidden" name="product_id">
</form>

<!-- Delete Modal -->
<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="delete_modal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h2>Delete Items</h2>
        <p>Are you sure you want to delete this item for listing? If you delete this item it will be deleted from your items and also from "BorrowMe" items listing.</p>
        <p>Note: If item is on rent it cannot be deleted until borrow time period is completed.</p>
         <img src="{{ asset('/images/delete-items.jpg') }}" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-block continue-btn">Continue</button>
        <button type="button" class="btn btn-outline-primary btn-block" style="border: 0;color: #000!important;" data-dismiss="modal">Not Now</button>
      </div>
    </div>
  </div>
</div>

<!-- Update Modal -->
<div class="modal fade" id="update_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="">
        	<h4>Current Status: </h4>
        	<input type="hidden" name="update_id">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary btn-block" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-block continue-btn">Save changes</button>
      </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" defer>
	function delete_item(id) {
		if(!!id) {
			$("input[name=product_id]").val(id);
			$("#delete_modal").modal('show');
		}
	}

	function update_status(id) {
		if(!!id) {
			$("#update_modal").modal('show');
		}
	}

	$(".continue-btn").on('click', function(){
		$("#delete-form").submit();
	});
</script>
@endsection