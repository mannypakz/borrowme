@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card register-page">
            
                <div class="card-body">
                    <form method="POST" action="{{ route('register_company') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-8">
                                <h2>{{ __('Sign Up') }}</h2>
                                <p>Kindly provide the correct details for signing up as a rental business in borrowme.</p>  
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="business-logo">
                                        <label for="company_logo" class="img-label">Upload Business<br>Logo here!<br><span>(Optional)</span></label>
                                        <input type="file" name="company_logo" class="form-control-file" id="company_logo">
                                    </div>
                                    <small style="color:red" class="img_err d-none">Format is not supported, please upload .png, .jpeg or .jpg</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="company_name" class="col-md-4 col-form-label text-md-right"></label>

                            <div class="col-md-12">
                                <input id="company_name" type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name') }}" required autocomplete="company_name" autofocus placeholder="Company Name">
                                <small style="color: red;">Required</small>
                                @error('company_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="company_web_address" class="col-md-4 col-form-label text-md-right"></label>

                            <div class="col-md-12">
                                <input id="company_web_address" type="text" class="form-control @error('company_web_address') is-invalid @enderror" name="company_web_address" value="{{ old('company_web_address') }}" autocomplete="company_web_address" autofocus placeholder="Company web address">
                                @error('company_web_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="first_name" class="col-md-4 col-form-label text-md-right"></label>

                            <div class="col-md-12">
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus placeholder="Contact first name">
                                <small style="color: red;">Required</small>
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="last_name" class="col-md-4 col-form-label text-md-right"></label>

                            <div class="col-md-12">
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus placeholder="Contact last name">
                                <small style="color: red;">Required</small>
                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right"></label>

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email Address">
                                <small style="color: red;">Required</small>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="location_code" class="col-md-4 col-form-label text-md-right"></label>

                                    <select id="location_code" class="form-control @error('location_code') is-invalid @enderror" name="location_code" value="{{old('location_code')}}" required>
                                        <option value="uae">U.A.E</option>
                                    </select>

                                    @error('location_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone" class="col-md-4 col-form-label text-md-right"></label>

                                    <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" autocomplete="phone" autofocus placeholder="+971">
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right"></label>

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">
                                <small style="color: red;">Required</small>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right"></label>

                            <div class="col-md-12">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Re-password">
                                <small style="color: red;">Required</small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address_line1" class="col-md-4 col-form-label text-md-right"></label>

                            <div class="col-md-12">
                                <input id="address_line1" type="text" class="form-control @error('address_line1') is-invalid @enderror" name="address_line1" value="{{ old('address_line1') }}" required autocomplete="address_line1" autofocus placeholder="Address line #1">
                                <small style="color: red;">Required</small>
                                @error('address_line1')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address_line2" class="col-md-4 col-form-label text-md-right"></label>

                            <div class="col-md-12">
                                <input id="address_line2" type="text" class="form-control @error('address_line2') is-invalid @enderror" name="address_line2" value="{{ old('address_line2') }}" required autocomplete="address_line2" autofocus placeholder="Address line #2">
                                <small style="color: red;">Required</small>
                                @error('address_line2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="city" class="col-md-4 col-form-label text-md-right"></label>
                            <div class="col-md-12">

                                <select id="city" class="form-control @error('city') is-invalid @enderror" name="city" value="{{old('city')}}" required>
                                    <option selected disabled>City</option>
                                    <option value="Abu Dhabi">Abu Dhabi</option>
                                    <option value="Ajman">Ajman</option>
                                    <option value="Al Ain">Al Ain</option>
                                    <option value="Dubai">Dubai</option>
                                    <option value="Fujairah">Fujairah</option>
                                    <option value="Ras al Khaimah">Ras al Khaimah</option>
                                    <option value="Sharjah">Sharjah</option>
                                    <option value="Umm al Quwain">Umm al Quwain</option>
                                </select>
                                <small style="color: red;">Required</small>
                                @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="country" class="col-md-4 col-form-label text-md-right"></label>
                            <div class="col-md-12">

                                <!--<select id="country" class="form-control @error('country') is-invalid @enderror" name="country" value="{{old('country')}}">
                                    <option value="U.A.E">U.A.E</option>
                                </select>
                                <small style="color: red;">Required</small>
                                @error('country')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror -->
                                <input type="hidden" id="country" class="form-control" name="country" value="U.A.E" />
                            </div>
                        </div>

                        <input type="hidden" name="registration_type" value="company">

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <small>Already have an account? <a href="#">Log in</a></small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#company_logo").on("change", function(){
            var fd = new FormData();
            var files = $(this)[0].files[0];
            var allowed = ["image/jpeg", "image/png"];
            fd.append('_token', '<?php echo csrf_token(); ?>');
            fd.append('image', files);

            if(allowed.includes(files.type)) {
                $(".img_err").addClass("d-none");
                $.ajax({
                    type: 'POST',
                    url: "/register/upload",
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        var filename = JSON.parse(data);
                        var im = document.createElement("IMG");
                        im.setAttribute("src", '<?php echo url('uploads/'); ?>'+'/'+filename);
                        im.setAttribute("width", '150');
                        im.setAttribute("height", '150');
                        
                        $(".img-label").html(im);
                        
                    },
                    error: function(data) {
                        console.log("error");
                    }
                });
            }
            else {
                $(".img_err").removeClass("d-none");
            }
        });
    });
</script>
