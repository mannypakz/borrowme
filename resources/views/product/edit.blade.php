@extends('layouts.admin')

@section('content')
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-info">
                  <div class="card-header">
                    <h3 class="card-title">Edit Product</h3>
                  </div>
                    <form class="form-horizontal" action="{{route('products.update', $product->id)}}" method="post" enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="sku" class="col-md-4 col-form-label">{{ __('Sku') }}</label>
                                <div class="col-md-6">
                                    <input id="sku" type="text" class="form-control @error('sku') is-invalid @enderror" name="sku" value="{{ $product->sku }}" required autocomplete="sku" autofocus>

                                    @error('sku')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label">{{ __('Title') }}</label>
                                <div class="col-md-6">
                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ $product->title }}" required autocomplete="title" autofocus>

                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="product_description" class="col-md-4 col-form-label">{{ __('Product Description') }}</label>
                                <div class="col-md-6">
                                    <textarea name="product_description" class="form-control  @error('product_description') is-invalid @enderror" rows="3" placeholder="Enter ..." required>{{ $product->product_description }}</textarea>
                                    @error('product_description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="vendor" class="col-md-4 col-form-label">{{ __('Vendor') }}</label>
                                <div class="col-md-6">
                                    <input id="vendor" type="text" class="form-control @error('vendor') is-invalid @enderror" name="vendor" value="{{ $product->vendor }}" required autocomplete="vendor" autofocus>
                                    @error('vendor')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="product_type" class="col-md-4 col-form-label">{{ __('Product Type') }}</label>
                                <div class="col-md-6">
                                    <input id="product_type" type="text" class="form-control @error('product_type') is-invalid @enderror" name="product_type" value="{{ $product->product_type }}" required autocomplete="product_type" autofocus>
                                    @error('product_type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="price" class="col-md-4 col-form-label">{{ __('Price') }}</label>
                                <div class="col-md-6">
                                    <input id="price" type="text" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ $product->price }}" required autocomplete="price" autofocus>
                                    @error('price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="quantity" class="col-md-4 col-form-label">{{ __('Quantity') }}</label>
                                <div class="col-md-6">
                                    <input id="quantity" type="text" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ $product->quantity }}" required autocomplete="quantity" autofocus>
                                    @error('quantity')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="barcode" class="col-md-4 col-form-label">{{ __('Barcode') }}</label>
                                <div class="col-md-6">
                                    <input id="barcode" type="text" class="form-control @error('barcode') is-invalid @enderror" name="barcode" value="{{ $product->barcode }}" required autocomplete="barcode" autofocus>
                                    @error('barcode')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="product_image" class="col-md-4 col-form-label">{{ __('Product Image') }}</label>
                                @if (isset($product->product_image) && !empty($product->product_image))
                                    <img src="{{asset('uploads/' . $product->product_image)}}" id="prod-img" alt="Image" width="100px" height="100px">
                                @endif
                                <div class="col-md-6">
                                    <input id="product_image" type="file" class="form-control @error('product_image') is-invalid @enderror" name="product_image" autocomplete="product_image" autofocus style="border:none;">
                                    @error('barcode')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <script type="text/javascript">
                                    $("#product_image").on('change', function(){
                                        var fd = new FormData();
                                        var files = $(this)[0].files[0];
                                        fd.append('_token', '<?php echo csrf_token(); ?>');
                                        fd.append('product_image', files);

                                        console.log(files);
                                        $.ajax({
                                            type: 'POST',
                                            url: "/products/ajax_upload",
                                            data: fd,
                                            contentType: false,
                                            processData: false,
                                            success: function(data) {
                                                var filename = JSON.parse(data);
                                                console.log(filename);
                                                if($("#prod-img").length) {
                                                    $("#prod-img").attr('src', '<?php echo url('uploads/'); ?>'+'/'+filename);
                                                }
                                            },
                                            error: function(data) {
                                                console.log("error");
                                            }
                                        });
                                    });
                                </script>
                            </div>

                            <div class="form-group row">
                                <label for="term" class="col-md-4 col-form-label">{{ __('For') }}</label>
                                <div class="col-md-6">
                                    <select id="term" class="form-control @error('term') is-invalid @enderror" name="term" value="{{$product->term}}" autofocus>
                                        <option {{$product->term == 'Sale' ? 'selected' : ''}} value="Sale">Sale</option>
                                        <option {{$product->term == 'Rent' ? 'selected' : ''}} value="Rent">Rent</option>
                                    </select>
                                    @error('location')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row ext-p-day">
                                <label for="extra_per_day" class="col-md-4 col-form-label">{{ __('Extra Per Day') }}</label>
                                <div class="col-md-6">
                                    <input id="extra_per_day" type="text" class="form-control @error('extra_per_day') is-invalid @enderror" name="extra_per_day" value="{{ $product->extra_per_day }}" autocomplete="extra_per_day">
                                    @error('extra_per_day')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <script type="text/javascript">
                                    var term = $("#term").val();
                                    if(term == 'Sale') {
                                        $(".ext-p-day").addClass("d-none");
                                    }
                                    $("#term").on('change', function(){
                                        if($(this).val() == 'Rent') {
                                            $(".ext-p-day").removeClass("d-none");
                                        }
                                        else {
                                            $(".ext-p-day").addClass("d-none");   
                                        }
                                    });
                                </script>
                            </div>

                            <div class="form-group row">
                                <label for="location" class="col-md-4 col-form-label">{{ __('Location') }}</label>
                                <div class="col-md-6">
                                    <input id="location" type="text" class="form-control @error('location') is-invalid @enderror" name="location" value="{{ $product->location }}" required autocomplete="location" autofocus>
                                    @error('location')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                      <button type="submit" class="btn btn-info float-right">Update</button>
                    </div>
                    <!-- /.card-footer -->
                    </form>
                </div>
        </div>
    </div>
</div>
@endsection


