@extends('layouts.template')

@section('content')
<div class="container mt-2">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<div class="section-header text-center">
				@if(Session::has('contact_sent'))
					<div class="alert alert-success" role="alert">
	  					Message Sent!
	  					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    					<span aria-hidden="true">&times;</span>
	  					</button>
					</div>
				@endif
        		<h1>Contact</h1>
      		</div>
      		<div class="rte">
          		<div style="text-align: center;">Have a question? Shoot us a message.</div>
				<div style="text-align: center;">We will get back to you within a few hours.</div>
        	</div>
			<form method="post" action="{{route('send_contact_msg')}}">
				@csrf
				<div class="form-group">
					<label for="name">Name</label>
					<input type="text" class="form-control" name="name" id="name" autocomplete="off">
				</div>
				<div class="form-group">
					<label for="email">Email*</label>
					<input type="email" class="form-control" name="email" id="email" required autocomplete="off">
				</div>
				<div class="form-group">
					<label for="phone">Phone Number</label>
					<input type="text" class="form-control" name="phone" id="phone" autocomplete="off">
				</div>
				<div class="form-group">
					<label for="message">Message</label>
					<textarea class="form-control" name="message" id="message" rows="10"></textarea>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary float-right">Send</button>
				</div>
			</form>
		</div>
		<div class="col-md-2"></div>
	</div>
</div>
@endsection