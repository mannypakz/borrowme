@extends('layouts.template')

@section('content')
<div class="container mt-2">
	<h3 class="mt-5 mb-5">Reviews</h3>
	@foreach($data as $d)
		<div class="reviews-wrapper">
			<div class="row">
				<div class="col-md-4">
					<img src="{{asset('uploads') . '/' . $d->image}}" width="60px" height="50px">
					<b>{{$d->reviewer}}</b>
				</div>
				<div class="col-md-8">
					<div>
					@for($b = 0; $b < $d->stars; $b++)
						<i class="fas fa-star"></i>
					@endfor
					</div>
					<div>
						{{$d->feedback}}
					</div>
				</div>
			</div>
		</div>
	@endforeach
</div>
@endsection