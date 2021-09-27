@extends('layouts.template')

@section('content')
<div class="container">
	<div class="row mt-5">
		<div class="col-md-3">
			@include('layouts/item_nav')
		</div>
		<div class="col-md-9">
			<form class="profile" method="post" action="{{route('update_profile')}}" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="registration_type" value="{{$user->registration_type}}">
          <input type="hidden" name="user_id" value="{{$user->id}}">
          @if($user->registration_type == 'company')
            <div class="form-group d-flex align-items-center mb-5">
              <label for="company-name">Company Name</label>
              <input type="text" class="form-control @error('company_name') is-invalid @enderror" id="company-name" value="{{$user->company_name}}" name="company_name">
              @error('company_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <div class="form-group d-flex align-items-center mb-5">
              <label for="company-web">Company Web Address</label>
              <input type="text" class="form-control @error('company_web_address') is-invalid @enderror" id="company-web" value="{{$user->company_web_address}}" name="company_web_address">
              @error('company_web_address')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
          @endif
				  <div class="form-group d-flex align-items-center mb-5">
    				<label for="first-name">First Name</label>
    				<input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first-name" value="{{$user->first_name}}" name="first_name">
            @error('first_name')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
  				</div>
  				<div class="form-group d-flex align-items-center mb-5">
    				<label for="last-name">Last Name</label>
    				<input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last-name" value="{{$user->last_name}}" name="last_name">
            @error('last_name')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
  				</div>
  				<div class="form-group d-flex align-items-center mb-5">
    				<label for="email">Email</label>
    				<input type="text" class="form-control @error('email') is-invalid @enderror" id="email" value="{{$user->email}}" name="email">
            @error('email')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
  				</div>
  				<div class="form-group d-flex align-items-center mb-5">
    				<label for="mobile">Mobile</label>
    				<input type="text" class="form-control @error('phone') is-invalid @enderror" id="mobile" value="{{$user->phone}}" name="phone">
            @error('phone')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
  				</div>
  				<div class="form-group d-flex align-items-center mb-5">
    				<label for="address">Address line 1</label>
    				<input type="text" class="form-control @error('address_line1') is-invalid @enderror" id="address1" value="{{$user->address_line1}}" name="address_line1">
            @error('address_line1')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
  				</div>
          <div class="form-group d-flex align-items-center mb-5">
            <label for="address">Address line 2</label>
            <input type="text" class="form-control @error('address_line2') is-invalid @enderror" id="address2" value="{{$user->address_line2}}" name="address_line2">
            @error('address_line2')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
  				<div class="form-group d-flex align-items-center mb-5">
    				<label for="city">City</label>
    				<select class="form-control" id="city" name="city">
    					<option value="{{$user->city}}">{{$user->city}}</option>
    				</select>
  				</div>
  				<div class="form-group d-flex align-items-center mb-5">
    				<label for="country">Country</label>
    				<select class="form-control" id="country" name="country">
    					<option disabled selected>U.A.E</option>
    				</select>
  				</div>
          <div class="form-group d-flex align-items-center mb-5">
            <label for="neigborhood">Neigborhood</label>
            <select class="form-control" id="neigborhood" name="neigborhood">
              @php
                $nb = explode(",", $user->neighbourhood);
              @endphp
              @foreach($nb as $n)
                <option value="{{$n}}">{{$n}}</option>
              @endforeach
            </select>
          </div>

          @if($user->registration_type == 'company')
            <div class="form-group text-center">
              <h3>Company Logo</h3>
              <label for="image" class="img-label">
              @if(null !== $user->company_logo)
                <img src="{{asset('/uploads/'.$user->company_logo)}}" class="profile-image" alt="Image" width="100px" height="100px">
              @else
                <img src="{{asset('/uploads/default6738888.jpg')}}" class="profile-image" alt="Image" width="100px" height="100px">
              @endif
              <div class="img-overlay">Click to edit</div>
              </label>
              <input type="file" name="image" class="form-control-file" id="image">
              <input type="hidden" name="filename" value="{{$user->company_logo}}">
            </div>
            <div class="form-group text-center">
              <small class="img-err d-none" style="color:red;">Format is not supported, please upload .png, .jpeg or .jpg</small>
            </div>
          @else
            <div class="form-group text-center">
              <h3>Profile Picture</h3>
              <label for="image" class="img-label">
              @if(null !== $user->profile_image)
                <img src="{{asset('/uploads/'.$user->profile_image)}}" class="profile-image" alt="Image" width="100px" height="100px">
              @else
                <img src="{{asset('/uploads/default6738888.jpg')}}" class="profile-image" alt="Image" width="100px" height="100px">
              @endif
              <div class="img-overlay">Click to edit</div>
              </label>
              <input type="file" name="image" class="form-control-file" id="image">
              <input type="hidden" name="filename" value="{{$user->profile_image}}">
            </div>
            <div class="form-group text-center">
              <small class="img-err d-none" style="color:red;">Format is not supported, please upload .png, .jpeg or .jpg</small>
            </div>
          @endif
          <div class="form-group text-center">
            <button type="submit" class="btn submit-button btn-primary">Submit</button>
          </div>
			</form>
		</div>
	</div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $("#image").on("change", function(){
      var fd = new FormData();
      var files = $(this)[0].files[0];
      var allowed = ["image/jpeg", "image/png"];
      fd.append('_token', '<?php echo csrf_token(); ?>');
      fd.append('image', files);
      if(allowed.includes(files.type)) {
        $.ajax({
          type: 'POST',
          url: "/profile/upload",
          data: fd,
          contentType: false,
          processData: false,
          success: function(data) {
            console.log(data);
            var filename = JSON.parse(data);
            $("input[name=filename]").val(filename);
            $(".profile-image").attr("src", '<?php echo url('uploads/'); ?>'+'/'+filename);
          },
          error: function(data) {
            console.log("error uploading file");
          }
        });
      }
      else {
        $(".img-err").removeClass("d-none");
      }
    });
  });
</script>
<style type="text/css">
  .img-overlay {
    position: absolute; 
    top: 87%; 
    left: 47%; 
    visibility: hidden;
  }

  .img-label:hover .profile-image{
    opacity: 0.3;
    cursor: pointer;
  }

  .img-label:hover .img-overlay {
    visibility: visible;
    cursor: pointer;
  }
</style>