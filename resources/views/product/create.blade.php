@extends('layouts.admin')

@section('content')
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-info">
                  <div class="card-header">
                    <h3 class="card-title">Add Product</h3>
                  </div>
                    <form class="form-horizontal" action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="sku" class="col-md-4 col-form-label">{{ __('Sku') }}</label>
                                <div class="col-md-6">
                                    <input id="sku" type="text" class="form-control @error('sku') is-invalid @enderror" name="sku" value="" required autocomplete="sku" autofocus>

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
                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="" required autocomplete="title" autofocus>

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
                                    <textarea name="product_description" class="form-control  @error('product_description') is-invalid @enderror" rows="3" placeholder="Enter ..." required></textarea>
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
                                    <input id="vendor" type="text" class="form-control @error('vendor') is-invalid @enderror" name="vendor" value="" required autocomplete="vendor" autofocus>
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
                                    <input id="product_type" type="text" class="form-control @error('product_type') is-invalid @enderror" name="product_type" value="" required autocomplete="product_type" autofocus>
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
                                    <input id="price" type="text" class="form-control @error('price') is-invalid @enderror" name="price" value="" required autocomplete="price" autofocus>
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
                                    <input id="quantity" type="text" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="" required autocomplete="quantity" autofocus>
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
                                    <input id="barcode" type="text" class="form-control @error('barcode') is-invalid @enderror" name="barcode" value="" required autocomplete="barcode" autofocus>
                                    @error('barcode')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="product_image" class="col-md-4 col-form-label">{{ __('Product Image') }}</label>
                                <div class="col-md-6">
                                    <input id="product_image" type="file" class="form-control @error('product_image') is-invalid @enderror" name="product_image" value="" required autocomplete="product_image" autofocus style="border:none;">
                                    @error('product_image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="term" class="col-md-4 col-form-label">{{ __('For') }}</label>
                                <div class="col-md-6">
                                    <select id="term" class="form-control @error('term') is-invalid @enderror" name="term" value="" autofocus>
                                        <option selected value="Sale">Sale</option>
                                        <option value="Rent">Rent</option>
                                    </select>
                                    @error('term')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row d-none ext-p-day">
                                <label for="extra_per_day" class="col-md-4 col-form-label">{{ __('Extra Per Day') }}</label>
                                <div class="col-md-6">
                                    <input id="extra_per_day" type="text" class="form-control @error('extra_per_day') is-invalid @enderror" name="extra_per_day" value="" autocomplete="extra_per_day">
                                    @error('extra_per_day')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <script type="text/javascript">
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
                                    <input id="location" type="text" class="form-control @error('location') is-invalid @enderror" name="location" value="" required autocomplete="location" autofocus>
                                    @error('location')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                      <button type="submit" class="btn btn-info float-right">Create</button>
                    </div>
                    <!-- /.card-footer -->
                    </form>
                </div>
        </div>
    </div>
</div>
@endsection


