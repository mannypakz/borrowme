@extends('layouts.template')

@section('content')
<div class="container">
	<div class="row mt-5">
		<div class="col-md-3">
			@include('layouts/item_nav')
		</div>
		<div class="col-md-9">
			<div class="content-section">
				<h3 class="mb-5">Change Password</h3>
				<form class="reset-password" action="{{route('update_password')}}" method="post">
					@csrf
					<div class="form-group">
						<div class="row align-items-center mb-5">
							<div class="col-md-3">
								<label for="current-password">Current Password</label>
							</div>
							<div class="col-md-9">
								<div class="form-field">
									<input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current-password" name="current_password">
									@error('current_password')
	                                    <span class="invalid-feedback" role="alert">
	                                        <strong>{{ $message }}</strong>
	                                    </span>
	                                @enderror
									<div class="show-hide">
					          			<span class="password-show" data="current"><i class="fas fa-eye"></i></span>
					          			<span class="password-hide d-none" data="current"><i class="fas fa-eye-slash"></i></span>
				          			</div>
			          			</div>
							</div>
						</div>
	        		</div>
	        		<div class="form-group">
	        			<div class="row align-items-center mb-5">
							<div class="col-md-3">
								<label for="new-password">New Password</label>
							</div>
							<div class="col-md-9">
								<div class="form-field">
									<input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new-password" name="new_password">
									@error('new_password')
	                                    <span class="invalid-feedback" role="alert">
	                                        <strong>{{ $message }}</strong>
	                                    </span>
	                                @enderror
									<div class="show-hide">
					          			<span class="password-show" data="new"><i class="fas fa-eye"></i></span>
	          							<span class="password-hide d-none" data="new"><i class="fas fa-eye-slash"></i></span>
				          			</div>
			          			</div>
							</div>
						</div>
	        		</div>
	        		<div class="form-group">
	        			<div class="row align-items-center mb-5">
							<div class="col-md-3">
								<label for="confirm-password">Confirm Password</label>
							</div>
							<div class="col-md-9">
								<div class="form-field">
									<input type="password" class="form-control @error('confirm_password') is-invalid @enderror" id="confirm-password" name="confirm_password">
									@error('confirm_password')
	                                    <span class="invalid-feedback" role="alert">
	                                        <strong>{{ $message }}</strong>
	                                    </span>
	                                @enderror
									<div class="show-hide">
					          			<span class="password-show" data="confirm"><i class="fas fa-eye"></i></span>
	          							<span class="password-hide d-none" data="confirm"><i class="fas fa-eye-slash"></i></span>
				          			</div>
			          			</div>
							</div>
						</div>
	        		</div>
	        		@if(null != session('pass_status') && 'success' == session('pass_status'))
	        			<div style="color:green;text-align: right" class="mb-2">Password changed!</div>
	        		@endif
	        		<div class="text-right">
	        			<button type="submit" class="btn btn-primary">Update Password</button>
	        		</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('.password-show').on('click', function(){
		var mode = $(this).attr('data');
		document.getElementById(mode+'-password').type='text';
		$(this).next().removeClass('d-none');
		$(this).addClass('d-none');
	});

	$('.password-hide').on('click', function(){
		var mode = $(this).attr('data');
		document.getElementById(mode+'-password').type='password';
		$(this).prev().removeClass('d-none');
		$(this).addClass('d-none');
	});
</script>
@endsection