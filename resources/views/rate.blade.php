@extends('layouts.app')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('rating.js') }}"></script>

<div class="container">
	<div class="row">
		<form method="post" action="{{route('rate_store')}}">
			@csrf
			<div class="col-md-12">
				<h3>Give Feedback</h3>
				<br>
				<p>
					Tell us about your borrower and rented item condition and share your experience of renting your items on "BorrowMe" with us and other users. Thanks!
				</p>
				<div>
					Rating: 
					<span id="rating"></span>
					<input type="hidden" name="stars">
				</div>
				<div class="form-group">
	    			<textarea class="form-control @error('feedback') is-invalid @enderror" id="review" rows="10" name="feedback"></textarea>
	    			@error('feedback')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
	  			</div>
	  			<input type="hidden" name="redirect" value="{{$redirect}}">
	  			<input type="hidden" name="product_id" value="{{$product_id}}">
	  			<div>
	  				<button type="submit" class="btn btn-primary">Submit</button>
	  			</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
	$("#rating").rating({
		"click": function(e){
			$("input[name=stars]").val(e.stars);
		}
	});
</script>
@endsection
