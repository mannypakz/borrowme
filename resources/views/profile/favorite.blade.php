@extends('layouts.template')

@section('content')
<div class="container">
	<div class="row mt-5">
		<div class="col-md-3">
			@include('layouts/item_nav')
		</div>
		<div class="col-md-9">
			<div class="content-section">
				<h3 class="mb-5">Favorite</h3>
				@for($i = 0; $i < count($saved); )
					<a href="{{$saved[$i]->url}}">
						<div class="row">
							@for($j = 0; $i < count($saved) && $j < 2; $j++)
								<div class="col-md-6">
									<div class="favorites-wrapper">
										<i class="fas fa-heart"></i>
										<div class="row">
											<div class="col-md-2">
												<img src="{{asset('uploads') . '/'. $saved[$i]->image}}" alt="Image" width="50px" height="50px">
											</div>
											<div class="col-md-10">
												<div>{{$saved[$i]->name}}</div>
												<small>Offer by {{$saved[$i]->vendor}}</small>
											</div>
										</div>
										<div class="notification">You added {{$saved[$i]->name}} as favorite item on @php $date = strtotime($saved[$i]->created_at); echo date("j M Y", $date); @endphp</div>
									</div>
								</div>
								@php
									$i++
								@endphp
							@endfor
						</div>
					</a>
				@endfor
			</div>
		</div>
	</div>
</div>
@endsection